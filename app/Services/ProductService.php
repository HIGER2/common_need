<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Supplier;
use Inertia\Inertia;

class ProductService
{
    public function index()
    {
        $suppliers = Supplier::all();
        $products = Product::with('supplier')->get();

        return Inertia::render('views/Products', [
            'suppliers' => $suppliers,
            'products' => $products,
        ]);
        return Inertia::render('views/Products');
    }

    public function getProductById($id)
    {
        $p = Product::find($id);
        if (!$p) return response()->json(['success' => false, 'message' => 'Produit non trouvé'], 404);
        return response()->json(['success' => true, 'product' => $p]);
    }

    public function createProduct($data)
    {
        try {
            $p = Product::create($data);
            return back(303)->with('success', 'User created successfully');
        } catch (\Exception $e) {
            return back(303)->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function updateProduct($id, $data)
    {
        try {
            $p = Product::findOrFail($id);
            $p->update($data);
            return response()->json(['success' => true, 'product' => $p]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    public function deleteProduct($id)
    {
        try {
            $p = Product::findOrFail($id);
            $p->delete();
            return response()->json(['success' => true, 'message' => 'Produit supprimé']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
