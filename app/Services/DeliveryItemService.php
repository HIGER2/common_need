<?php

namespace App\Services;

use App\Models\DeliveryItem;

class DeliveryItemService
{

    public function confirmItems($delivery_id, $items)
    {
        try {
            $deliveryItems = [];
            foreach ($items as $item) {
                $deliveryItems[] = DeliveryItem::create([
                    'delivery_id' => $delivery_id,
                    'product_id' => $item['product_id'],
                    'quantity_received' => $item['quantity_received']
                ]);
            }
            return response()->json(['success' => true, 'delivery_items' => $deliveryItems]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
