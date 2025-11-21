<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use Illuminate\Http\Request;
use App\Services\PurchaseOrderService;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

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

    public function getOrder($uuid)
    {
        return $this->service->getOrder($uuid);
    }

    public function orderDelivery($uuid)
    {
        return $this->service->orderDelivery($uuid);
    }


    public function confirmFromMail($uuid)
    {
        return $this->service->updateStatusFromMail($uuid, 'approved');
    }

    public function rejectFromMail($uuid)
    {
        return $this->service->updateStatusFromMail($uuid, 'rejected');
    }
}
