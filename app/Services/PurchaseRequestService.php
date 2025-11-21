<?php

namespace App\Services;

use App\Mail\PurchaseOrderBudgetMail;
use App\Mail\PurchaseRequestMail;
use App\Mail\PurchaseRequestStatusMail;
use App\Models\Product;
use App\Models\PurchaseGlobal;
use App\Models\PurchaseGlobalApproval;
use App\Models\PurchaseOrder;
use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestItem;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class PurchaseRequestService
{

    public function index()
    {
        $all = PurchaseGlobal::orderBy('created_at', 'desc')->get();
        $products = Product::all();
        $budgetOfficer = User::where('role', 'budgetOfficer')->get();
        return Inertia::render('views/PurchaseRequests', [
            'requests' => $all,
            'productSelect' => $products,
            'budgetOfficer' => $budgetOfficer,
        ]);
    }

    public function getRequest($uuid)
    {
        $all = PurchaseGlobal::with('requests.items', 'budgetOfficer', 'requests.supplier', 'requester')
            ->where('uuid', $uuid)->first();
        return Inertia::render('views/PurchaseRequestDetail', [
            'requests' => $all,
        ]);
    }

    public function requestApproved($uuid, $status)
    {
        DB::beginTransaction();
        try {
            // 1️⃣ Récupérer le PurchaseGlobal
            $global = PurchaseGlobal::where('uuid', $uuid)->firstOrFail();

            // 2️⃣ Mise à jour du statut global
            $global->status = $status;
            $global->save();

            // 4️⃣ Cas : rejet → on s'arrête ici
            if ($status === 'rejected') {
                DB::commit();
                return back()->with('message', 'Publication status updated successfully');
            }

            $this->generateOrderRequest($global, $status);
            DB::commit();
            return back()->with('message', 'Publication status updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function createRequest($data)
    {
        try {

            DB::beginTransaction();
            // check liaison officer
            $liaisonOfficer = User::find($data['budget_officer_id'])->value('email');
            if (!$liaisonOfficer) {
                // throw new \Exception('Liaison officer not found.');
                ValidationException::withMessages([
                    'message' => 'Liaison officer not found.'
                ]);
            }
            // 1️⃣ GROUPER LES PRODUITS PAR FOURNISSEUR
            // -----------------------------
            $productsBySupplier = collect($data['products'])
                ->groupBy('supplier_id')
                ->toArray();

            // 2️⃣ CALCUL DU GLOBAL
            $totalQuantity = array_sum(array_column($data['products'], 'quantity'));
            $totalAmount = array_sum(array_map(fn($p) => $p['quantity'] * $p['price'], $data['products']));
            $totalProducts = count($data['products']);

            $requester_id = Auth::id();
            // 3️⃣ CREATE PurchaseGlobal
            // -----------------------------
            $global = PurchaseGlobal::create([
                'requester_id'   => $requester_id,
                'total_quantity'   => $totalQuantity,
                'total_item'   => $totalProducts,
                'total_amount'   => $totalAmount,
                'budget_officer_id'   => $data['budget_officer_id'] ?? null,
                // 'remarks'        => $data['remarks'] ?? null,
            ]);

            if (!$global) {
                throw new \Exception('Failed to create Purchase Global.');
            }

            // Log::debug('data', $global);


            // 4️⃣ BOUCLE SUR CHAQUE FOURNISSEUR → CRÉER PurchaseRequest
            // -----------------------------
            $requests = [];

            foreach ($productsBySupplier as $supplierId => $items) {
                // Créer la Request
                $req = PurchaseRequest::create([
                    'purchase_global_id' => $global->id,
                    'supplier_id'        => $supplierId,
                    'total_amount'       => array_sum(array_map(fn($p) => $p['quantity'] * $p['price'], $items)),
                    'total_quantity'       => array_sum(array_column($items, 'quantity')),
                    'total_item'       => count($items),
                    // 'remarks'            => $data['remarks'] ?? null
                ]);
                // Créer les items
                foreach ($items as $p) {
                    PurchaseRequestItem::create([
                        'purchase_request_id' => $req->id,
                        'product_id'          => $p['id'],
                        'quantity'            => $p['quantity'],
                        'unit_price'          => $p['price'],
                        'name'            => $p['product'],
                        'subtotal'            => (int) $p['quantity'] * (int) $p['price'],
                    ]);
                }

                $requests[] = $req->load('items');
            }

            DB::commit();
            $this->sendPurchaseRequest($global->id, $liaisonOfficer);

            return back(303)->with('success', 'User created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            throw ValidationException::withMessages([
                'api' => $e->getMessage()
            ]);
            // return response()->json([
            //     'status' => false,
            //     'message' => $e->getMessage(),
            // ], 200);
            // return back(303)->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function updateRequest($id, $data)
    {
        try {
            $req = PurchaseRequest::findOrFail($id);
            $req->update($data);
            return response()->json(['success' => true, 'request' => $req]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function deleteRequest($id)
    {
        try {
            $req = PurchaseRequest::findOrFail($id);
            $req->delete();
            return response()->json(['success' => true, 'message' => 'Demande supprimée']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function updateStatusFromMail($uuid, $status)
    {
        $request = PurchaseGlobal::with(['requester', 'requests.items', 'requests.supplier'])
            ->where('uuid', $uuid)
            ->firstOrFail();

        // Vérifie si le statut est déjà défini
        if ($request->status !== 'pending') {
            $message = "Request already {$request->status}.";
        } else {
            $request->status = $status;
            $request->save();
            // Envoi d'un mail au requester
            if ($request->requester && $request->requester->email) {
                Mail::to($request->requester->email)
                    ->send(new PurchaseRequestStatusMail($request));
            }
            $message = "Request has been {$status} successfully!";

            // 2️⃣ Génération de l'ordre d'achat
            $order = $this->generateOrderRequest($request, $status);
            if ($order) {
                Log::info('Purchase Order generated from request approval via mail', ['order' => $order]);
            }
        }


        // Retourne une vue Inertia simple
        return Inertia::render('views/StatusUpdated', [
            'message' => $message,
            'reference' => $request->reference,
            'status' => $request->status
        ]);
    }

    public function generateOrderRequest($global, $status)
    {
        // 3️⃣ Enregistrement dans purchase_global_approvals

        // $approval = PurchaseGlobalApproval::create([
        //     'purchase_global_id' => $global->id,
        //     'approved_by'        => Auth::id(),
        //     'status'             => $status,
        //     // 'comment'            => request('comment') ?? null,
        //     'date'     => now(),
        // ]);
        // 5️⃣ Cas : APPROUVÉ → créer un PURCHASE ORDER
        $order = null;
        if ($status === 'approved') {
            // Calcule infos PO
            $liaison_officer = User::firstWhere('role', 'liaisonOfficer')->value('id');
            $totalQty = $global->total_quantity;
            $totalItems = $global->total_item;
            $totalAmount = $global->total_amount;
            $order = PurchaseOrder::create([
                'purchase_global_id'  => $global->id,
                "liaison_officer_id" => $liaison_officer,
                // 'liaison_officer_id'  => Auth::id() ?? null,
                'total_item'          => $totalItems,
                'total_amount'        => $totalAmount,
                'total_quantity'      => $totalQty,
            ]);
            $order = PurchaseOrder::with(
                'purchaseRequest.requester',
                'purchaseRequest.requests.items',
                'purchaseRequest.requests.supplier',
                'purchaseRequest.budgetOfficer'
            )->find($order->id);
            // Ensuite envoie le mail
            Mail::to("exe@example.com")->send(new PurchaseOrderBudgetMail($order));
        }
        return $order;
    }


    public function sendPurchaseRequest($requestId, $liaisonOfficer)
    {
        $request = PurchaseGlobal::with(['requester', 'requests.items', 'requests.supplier'])
            ->findOrFail($requestId);
        Mail::to($liaisonOfficer)->send(new PurchaseRequestMail($request));
    }
}
