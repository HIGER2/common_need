<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\PurchaseOrder;

class InvoiceService
{

    public function createInvoice($data)
    {
        try {
            $order = PurchaseOrder::findOrFail($data['purchase_order_id']);
            $invoice = Invoice::create([
                'supplier_id' => $order->supplier_id,
                'purchase_order_id' => $data['purchase_order_id'],
                'invoice_number' => $data['invoice_number'] ?? 'INV' . time(),
                'invoice_date' => $data['invoice_date'] ?? now(),
                'amount' => $data['amount'],
                'status' => 'pending'
            ]);
            return response()->json(['success' => true, 'invoice' => $invoice], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function validateInvoice($id)
    {
        try {
            $invoice = Invoice::findOrFail($id);
            $invoice->status = 'validated';
            $invoice->save();
            return response()->json(['success' => true, 'invoice' => $invoice]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
