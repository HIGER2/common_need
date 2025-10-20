<?php

namespace App\Services;

use App\Models\Center;

class CenterService
{
    public function getAllCenters()
    {
        return response()->json(['success' => true, 'centers' => Center::all()]);
    }

    public function getCenterById($id)
    {
        $center = Center::find($id);
        if (!$center) return response()->json(['success' => false, 'message' => 'Centre non trouvé'], 404);
        return response()->json(['success' => true, 'center' => $center]);
    }

    public function createCenter($data)
    {
        try {
            $center = Center::create([
                'name' => $data['name'],
                'location' => $data['location'],
                'liaison_officer_id' => $data['liaison_officer_id'] ?? null
            ]);
            return response()->json(['success' => true, 'center' => $center], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function updateCenter($id, $data)
    {
        try {
            $center = Center::findOrFail($id);
            $center->update($data);
            return response()->json(['success' => true, 'center' => $center]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function deleteCenter($id)
    {
        try {
            $center = Center::findOrFail($id);
            $center->delete();
            return response()->json(['success' => true, 'message' => 'Centre supprimé']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
