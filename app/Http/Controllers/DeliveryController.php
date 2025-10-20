<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\DeliveryService;

class DeliveryController extends Controller
{
    protected $service;
    public function __construct(DeliveryService $service)
    {
        $this->service = $service;
    }
    public function index()
    {
        return $this->service->getAllDeliveries();
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
