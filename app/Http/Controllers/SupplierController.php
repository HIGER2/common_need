<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SupplierService as ServicesSupplierService;

class SupplierController extends Controller
{
    protected $service;
    public function __construct(ServicesSupplierService $service)
    {
        $this->service = $service;
    }
    public function index()
    {
        return $this->service->index();
    }
    public function show($id)
    {
        return $this->service->getSupplierById($id);
    }
    public function store(Request $request)
    {
        return $this->service->createSupplier($request->all());
    }
    public function update(Request $request, $id)
    {
        return $this->service->updateSupplier($id, $request->all());
    }
    public function destroy($id)
    {
        return $this->service->deleteSupplier($id);
    }
}
