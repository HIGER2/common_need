<?php

namespace App\Services;

use App\Models\PurchaseOrder;
use App\Models\PurchaseRequest;
use Inertia\Inertia;

class PurchaseOrderService
{

    public function index($request)
    {
        return Inertia::render('views/Users');
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
}
