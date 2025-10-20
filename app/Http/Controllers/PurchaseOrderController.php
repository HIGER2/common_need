<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PurchaseOrderService;

class PurchaseOrderController extends Controller
{
    protected $service;
    public function __construct(PurchaseOrderService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        return $this->service->index($request);
    }


    public function store(Request $request)
    {
        return $this->service->createOrder($request->request_id, $request->liaison_officer_id);
    }
}
