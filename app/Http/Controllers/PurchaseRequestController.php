<?php

namespace App\Http\Controllers;

use App\Services\PurchaseRequestService;
use Illuminate\Http\Request;

class PurchaseRequestController extends Controller
{
    protected $service;
    public function __construct(PurchaseRequestService $service)
    {
        $this->service = $service;
    }
    public function index()
    {
        return $this->service->index();
    }
    public function show($id)
    {
        return $this->service->getRequestById($id);
    }
    public function store(Request $request)
    {
        return $this->service->createRequest($request->all());
    }
    public function update(Request $request, $id)
    {
        return $this->service->updateRequest($id, $request->all());
    }
    public function destroy($id)
    {
        return $this->service->deleteRequest($id);
    }
}
