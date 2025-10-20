<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PurchaseRequestItem;
use App\Services\PurchaseRequestItemService;
use Illuminate\Http\JsonResponse;

class PurchaseRequestItemController extends Controller
{
    protected PurchaseRequestItemService $service;

    public function __construct(PurchaseRequestItemService $service)
    {
        $this->service = $service;
    }

    // Créer un item
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'purchase_request_id' => 'required|exists:purchase_requests,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1',
            'unit_price' => 'required|numeric|min:0',
        ]);

        try {
            $item = $this->service->create($request->all());
            return response()->json(['message' => 'Item créé avec succès', 'data' => $item], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    // Mettre à jour un item
    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'product_id' => 'exists:products,id',
            'quantity' => 'numeric|min:1',
            'unit_price' => 'numeric|min:0',
        ]);

        try {
            $item = PurchaseRequestItem::findOrFail($id);
            $item = $this->service->update($item, $request->all());
            return response()->json(['message' => 'Item mis à jour', 'data' => $item]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    // Supprimer un item
    public function destroy($id): JsonResponse
    {
        try {
            $item = PurchaseRequestItem::findOrFail($id);
            $this->service->delete($item);
            return response()->json(['message' => 'Item supprimé']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
