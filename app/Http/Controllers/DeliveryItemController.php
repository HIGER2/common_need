<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\DeliveryItemService;

class DeliveryItemController extends Controller
{
    protected $service;
    public function __construct(DeliveryItemService $service)
    {
        $this->service = $service;
    }
    public function confirm(Request $request)
    {
        return $this->service->confirmItems($request->delivery_id, $request->items);
    }
}
