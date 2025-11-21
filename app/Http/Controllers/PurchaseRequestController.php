<?php

namespace App\Http\Controllers;

use App\Mail\PurchaseRequestStatusMail;
use App\Models\PurchaseGlobal;
use App\Services\PurchaseRequestService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

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
    public function show($uuid)
    {
        return $this->service->getRequest($uuid);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'products' => ['required', 'array', 'min:1'],
            'products.*.product' => ['required', 'string', 'max:255'],
            'products.*.quantity' => ['required', 'integer', 'min:1'],
            'products.*.price' => ['nullable', 'numeric', 'min:0'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        return $this->service->createRequest($request->all());
    }
    public function update(Request $request, $id)
    {
        return $this->service->updateRequest($id, $request->all());
    }

    public function requestApproved($uuid, $status)
    {
        return $this->service->requestApproved($uuid, $status);
    }
    public function destroy($id)
    {
        return $this->service->deleteRequest($id);
    }

    public function approveFromMail($uuid)
    {
        return $this->service->updateStatusFromMail($uuid, 'approved');
    }

    public function rejectFromMail($uuid)
    {
        return $this->service->updateStatusFromMail($uuid, 'rejected');
    }


    // private function updateStatusFromMail($uuid, $status)
    // {
    //     return $this->service->updateStatusFromMail($uuid, $status);
    // }
}
