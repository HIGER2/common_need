<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\InvoiceService;

class InvoiceController extends Controller
{
    protected $service;
    public function __construct(InvoiceService $service)
    {
        $this->service = $service;
    }
    public function store(Request $request)
    {
        return $this->service->createInvoice($request->all());
    }
    public function validateInvoice($id)
    {
        return $this->service->validateInvoice($id);
    }
}
