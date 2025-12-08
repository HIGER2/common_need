<?php

namespace App\Services;

use App\Models\Delivery;
use App\Models\DeliveryRequest;
use App\Models\DeliveryRequestItem;
use App\Models\PurchaseOrder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Request;

class DeliveryService
{
    public function deliveryOrder($uuid)
    {
        $all = PurchaseOrder::with('deliveries.deliveryRequest.items', 'deliveries.deliveryRequest.supplier')
            ->where('uuid', $uuid)->first();
        return Inertia::render('views/PurchaseOrderDelivery', [
            'data' => $all,
        ]);
    }

    public function deliveryOrderConfirm($uuid)
    {
        try {
            DB::beginTransaction();

            $order = PurchaseOrder::with(
                'purchaseRequest.requester',
                'purchaseRequest.requests.items',
                'purchaseRequest.requests.supplier'
            )->where('uuid', $uuid)->firstOrFail();

            if ($order->deliveries) {
                return back()->with('message', 'livraison déjá confirmée');
            }
            // Create delivery
            $delivery = Delivery::create([
                'purchase_order_id' => $order->id,
                'received_by'       => Auth::id(),
                'quantity_ordered'  => $order->total_quantity,
                'total_ordered'     => $order->total_amount,
            ]);

            $requests = [];

            foreach ($order->purchaseRequest->requests as $request) {
                // Create / update DeliveryRequest
                $deliveryRequest = $delivery->deliveryRequest()->updateOrCreate(
                    [
                        "supplier_id" => $request->supplier_id
                    ],
                    [
                        'delivery_id'       => $delivery->id,
                        'supplier_id'       => $request->supplier_id,
                        'quantity_ordered'  => $request->total_quantity,
                        'total_ordered'     => $request->total_amount,
                    ]
                );

                // Loop on request items
                foreach ($request->items as $item) {

                    $deliveryRequest->items()->updateOrCreate(
                        [
                            "product_id" => $item->product_id
                        ],
                        [
                            'delivery_request_id' => $deliveryRequest->id,
                            'product_id'          => $item->product_id,
                            'quantity_ordered'    => $item->quantity,
                            'subtotal_ordered'    => $item->subtotal,
                            'unit_price'          => $item->unit_price,
                            'name'                => $item->name,
                        ]
                    );
                }

                $requests[] = $request->load('items');
            }

            DB::commit();

            return back()->with('message', 'Delivery successfully created.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'An error occurred: ' . $th->getMessage());
        }
    }


    public function deliveryQuantity(Request $request, $uuid)
    {
        try {
            DB::beginTransaction();

            $delivery = Delivery::where('uuid', $uuid)->firstOrFail();
            $deliveryRequest = $delivery->deliveryRequest()->firstWhere("uuid", $request['uuid']);

            $totalReceivedDiff = 0;
            $totalValueDiff = 0;

            foreach ($request['items'] as $item) {
                $deliveryItem = $deliveryRequest->items()->where('id', $item['id'])->first();

                if ($deliveryItem) {
                    // Différence entre la nouvelle quantité et l'ancienne
                    $quantityDiff = $item['quantity_received'] - $deliveryItem->quantity_received;
                    $subtotalDiff = $quantityDiff * (float) $item['unit_price'];

                    // Incrément ou décrémenter les totaux globaux
                    $totalReceivedDiff += $quantityDiff;
                    $totalValueDiff += $subtotalDiff;

                    // Mettre à jour l'item
                    $deliveryItem->update([
                        'quantity_received' => $item['quantity_received'],
                        'subtotal_received' => (float) $item['unit_price'] * (float) $item['quantity_received'],
                    ]);

                    // Ici tu peux mettre à jour d'autres tables dépendantes si nécessaire
                    // Exemple : Stock::where('product_id', $deliveryItem->product_id)->increment('quantity', $quantityDiff);
                }
            }

            // Mettre à jour les totaux globaux
            $delivery->increment('quantity_received', $totalReceivedDiff);
            $delivery->increment('total_received', $totalValueDiff);

            $deliveryRequest->increment('quantity_received', $totalReceivedDiff);
            $deliveryRequest->increment('total_received', $totalValueDiff);

            DB::commit();

            return back()->with('message', 'Delivery successfully updated.');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw \Illuminate\Validation\ValidationException::withMessages([
                'message' => $th->getMessage()
            ]);
        }
    }

    public function getAllDeliveries()
    {
        return response()->json(['success' => true, 'deliveries' => Delivery::with('order', 'receivedBy')->get()]);
    }

    public function getDeliveryById($id)
    {
        $delivery = Delivery::with('order', 'receivedBy')->find($id);
        if (!$delivery) return response()->json(['success' => false, 'message' => 'Livraison non trouvée'], 404);
        return response()->json(['success' => true, 'delivery' => $delivery]);
    }

    public function createDelivery($data)
    {
        try {
            $order = PurchaseOrder::findOrFail($data['purchase_order_id']);
            $delivery = Delivery::create([
                'purchase_order_id' => $data['purchase_order_id'],
                'received_by' => $data['received_by'],
                'delivery_date' => $data['delivery_date'] ?? now(),
                'grn_number' => 'GRN' . time(),
                'remarks' => $data['remarks'] ?? null
            ]);

            // Mettre à jour la commande et la demande
            $order->status = 'received';
            $order->save();
            $order->purchaseRequest->status = 'delivered';
            $order->purchaseRequest->save();

            return response()->json(['success' => true, 'delivery' => $delivery]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
