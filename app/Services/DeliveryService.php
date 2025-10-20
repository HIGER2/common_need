<?php

namespace App\Services;

use App\Models\Delivery;
use App\Models\PurchaseOrder;

class DeliveryService
{

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
