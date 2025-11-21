<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class UserService
{
    public function index()
    {
        $all = User::all();
        return Inertia::render('views/Users', [
            'users' => $all,  // <-- ici on passe les utilisateurs
        ]);
    }

    public function createUser($data)
    {
        try {
            $user = User::updateOrCreate([
                "email" => $data['email'],
            ], [
                'name' => $data['name'],
                'last_name' => $data['last_name'],
                // 'phone' => $data['phone'],
                'role' => $data['role'],
                // 'password' => Hash::make($data['password']),
                // 'center_id' => $data['center_id'] ?? null,
                // 'status' => $data['status'] ?? 'active',
            ]);
            return back(303)->with('success', 'User created successfully');
        } catch (\Exception $e) {
            return back(303)->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function updateUser($id, $data)
    {
        try {
            $user = User::findOrFail($id);
            $user->update($data);
            return response()->json(['success' => true, 'user' => $user]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function deleteUser($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return response()->json(['success' => true, 'message' => 'Utilisateur supprimé']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function getUserById($id)
    {
        $user = User::find($id);
        if (!$user) return response()->json(['success' => false, 'message' => 'Utilisateur non trouvé'], 404);
        return response()->json(['success' => true, 'user' => $user]);
    }
}
