<?php

namespace App\Services;

use App\Models\Supplier;
use Inertia\Inertia;

class SupplierService
{

    public function index()
    {
        return Inertia::render('views/Suppliers');
    }

    public function getAllSuppliers()
    {
        return response()->json(['success' => true, 'suppliers' => Supplier::all()]);
    }
    public function getSupplierById($id)
    {
        $s = Supplier::find($id);
        if (!$s) return response()->json(['success' => false, 'message' => 'Fournisseur non trouvé'], 404);
        return response()->json(['success' => true, 'supplier' => $s]);
    }
    public function createSupplier($data)
    {
        try {
            $s = Supplier::create($data);
            return response()->json(['success' => true, 'supplier' => $s], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    public function updateSupplier($id, $data)
    {
        try {
            $s = Supplier::findOrFail($id);
            $s->update($data);
            return response()->json(['success' => true, 'supplier' => $s]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    public function deleteSupplier($id)
    {
        try {
            $s = Supplier::findOrFail($id);
            $s->delete();
            return response()->json(['success' => true, 'message' => 'Fournisseur supprimé']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
