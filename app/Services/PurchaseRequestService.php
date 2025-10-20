<?php

namespace App\Services;

use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestItem;
use Inertia\Inertia;

class PurchaseRequestService
{

    public function index()
    {
        return Inertia::render('views/Suppliers');
    }

    public function getRequestById($id)
    {
        $req = PurchaseRequest::with('items', 'requester', 'supplier')->find($id);
        if (!$req) return response()->json(['success' => false, 'message' => 'Demande non trouvée'], 404);
        return response()->json(['success' => true, 'request' => $req]);
    }

    public function createRequest($data)
    {
        try {
            $req = PurchaseRequest::create([
                'requester_id' => $data['requester_id'],
                'supplier_id' => $data['supplier_id'],
                'status' => 'pending',
                'request_date' => now(),
                'total_amount' => $data['total_amount'],
                'remarks' => $data['remarks'] ?? null
            ]);

            // Création items
            foreach ($data['items'] as $item) {
                PurchaseRequestItem::create([
                    'purchase_request_id' => $req->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'subtotal' => $item['quantity'] * $item['unit_price']
                ]);
            }

            return response()->json(['success' => true, 'request' => $req->load('items')], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
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
}
