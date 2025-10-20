<?php

namespace App\Services;

use App\Models\PurchaseApproval;
use App\Models\PurchaseRequest;

class PurchaseApprovalService
{

    public function approve($request_id, $budget_officer_id, $status, $comment = null)
    {
        try {
            $req = PurchaseRequest::findOrFail($request_id);
            $req->status = $status == 'approved' ? 'approved' : 'rejected';
            $req->save();

            $approval = PurchaseApproval::create([
                'purchase_request_id' => $request_id,
                'approved_by' => $budget_officer_id,
                'status' => $status,
                'approval_date' => now(),
                'comment' => $comment
            ]);

            return response()->json(['success' => true, 'approval' => $approval, 'request' => $req]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
