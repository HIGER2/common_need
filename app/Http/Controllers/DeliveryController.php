<?php

namespace App\Http\Controllers;

use App\Services\DeliveryService;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    protected $service;
    public function __construct(DeliveryService $service)
    {
        $this->service = $service;
    }
    public function deliveryOrder($uuid)
    {
        return $this->service->deliveryOrder($uuid);
    }

    public function deliveryQuantity(Request $request, $uuid)
    {
        return $this->service->deliveryQuantity($request, $uuid);
    }
    public function show($id)
    {
        return $this->service->getDeliveryById($id);
    }
    public function store(Request $request)
    {
        return $this->service->createDelivery($request->all());
    }
}
