<?php

namespace App\Services;

use App\Models\Supplier;
use Inertia\Inertia;

class SupplierService
{

    public function index()
    {
        $all = Supplier::all();

        return Inertia::render('views/Suppliers', [
            'suppliers' => $all,  // <-- ici on passe les utilisateurs
        ]);
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
            $s = Supplier::updateOrCreate([
                "email" => $data['email'],
            ], [
                'name' => $data['name'],
                'last_name' => $data['last_name'],
                'address' => $data['address'] ?? null,
                // 'phone' => $data['phone'] ?? null,
                // 'contact_person' => $data['contact_person'] ?? null,
            ]);
            return back(303)->with('success', 'User created successfully');
        } catch (\Exception $e) {
            return back(303)->with('error', 'An error occurred: ' . $e->getMessage());
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
