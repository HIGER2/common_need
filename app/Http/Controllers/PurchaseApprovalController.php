<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\PurchaseApprovalService;

class PurchaseApprovalController extends Controller
{
    protected $service;
    public function __construct(PurchaseApprovalService $service)
    {
        $this->service = $service;
    }

    public function approve(Request $request)
    {
        return $this->service->approve($request->request_id, $request->budget_officer_id, $request->status, $request->comment ?? null);
    }
}
