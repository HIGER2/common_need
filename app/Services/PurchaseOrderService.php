<?php

namespace App\Services;

use App\Mail\PurchaseOrderStatusMail;
use App\Models\Delivery;
use App\Models\DeliveryRequest;
use App\Models\DeliveryRequestItem;
use App\Models\PurchaseOrder;
use App\Models\PurchaseRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class PurchaseOrderService
{

    public function index()
    {
        $all = PurchaseOrder::orderBy('created_at', 'desc')->get();
        return Inertia::render('views/PurchaseOrders', [
            'orders' => $all,
        ]);
    }

    public function createOrder($request_id, $liaison_officer_id)
    {
        try {
            $req = PurchaseRequest::findOrFail($request_id);
            if ($req->status != 'approved') return response()->json(['success' => false, 'message' => 'Demande non approuvée'], 400);

            $order = PurchaseOrder::create([
                'purchase_request_id' => $request_id,
                'liaison_officer_id' => $liaison_officer_id,
                'supplier_id' => $req->supplier_id,
                'order_date' => now(),
                'order_number' => 'PO' . time(),
                'status' => 'sent'
            ]);

            $req->status = 'ordered';
            $req->save();

            return response()->json(['success' => true, 'order' => $order, 'request' => $req]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function getOrder($uuid)
    {
        $all = PurchaseOrder::with('purchaseRequest.requester', 'purchaseRequest.budgetOfficer', 'purchaseRequest.requests.items', 'purchaseRequest.requests.supplier')
            ->where('uuid', $uuid)->first();
        return Inertia::render('views/PurchaseOrderDetail', [
            'data' => $all,
        ]);
    }

    public function updateStatusFromMail($uuid, $status)
    {
        $order = PurchaseOrder::with(['purchaseRequest.requester', 'purchaseRequest.requests.items', 'purchaseRequest.requests.supplier'])
            ->where('uuid', $uuid)
            ->firstOrFail();

        if ($order->status === $status) {
            $message = "This order has already been {$status}.";
        } else {
            $order->status = $status;
            $order->save();
            // Envoi d’un mail au requester pour l’informer du statut
            if ($order->purchaseRequest->requester && $order->purchaseRequest->requester->email) {
                Mail::to($order->purchaseRequest->requester->email)
                    ->send(new PurchaseOrderStatusMail($order));
            }

            $message = "Order status has been updated to {$status}.";
        }

        return Inertia::render('views/StatusUpdated', [
            'message' => $message,
            'reference' => $order->reference,
            'status' => $status
        ]);
    }
}
