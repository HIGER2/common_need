<?php

namespace App\Services;

use App\Models\PurchaseRequestItem;
use Exception;

class PurchaseRequestItemService
{
    /**
     * Créer un item pour une demande d'achat
     */
    public function create(array $data): PurchaseRequestItem
    {
        try {
            $item = PurchaseRequestItem::create([
                'purchase_request_id' => $data['purchase_request_id'],
                'product_id' => $data['product_id'],
                'quantity' => $data['quantity'],
                'unit_price' => $data['unit_price'],
                'subtotal' => $data['quantity'] * $data['unit_price'],
            ]);
            return $item;
        } catch (Exception $e) {
            throw new Exception("Impossible de créer l'item : " . $e->getMessage());
        }
    }

    /**
     * Mettre à jour un item
     */
    public function update(PurchaseRequestItem $item, array $data): PurchaseRequestItem
    {
        try {
            $item->update([
                'product_id' => $data['product_id'] ?? $item->product_id,
                'quantity' => $data['quantity'] ?? $item->quantity,
                'unit_price' => $data['unit_price'] ?? $item->unit_price,
                'subtotal' => ($data['quantity'] ?? $item->quantity) * ($data['unit_price'] ?? $item->unit_price),
            ]);
            return $item;
        } catch (Exception $e) {
            throw new Exception("Impossible de mettre à jour l'item : " . $e->getMessage());
        }
    }

    /**
     * Supprimer un item
     */
    public function delete(PurchaseRequestItem $item): bool
    {
        try {
            return $item->delete();
        } catch (Exception $e) {
            throw new Exception("Impossible de supprimer l'item : " . $e->getMessage());
        }
    }
}
