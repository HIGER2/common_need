<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthService
{
    // Connexion par mot de passe
    public function loginPassword($email, $password)
    {
        $user = User::where('email', $email)->first();
        if (!$user || !Hash::check($password, $user->password)) {
            return response()->json(['success' => false, 'message' => 'Email ou mot de passe incorrect'], 401);
        }

        auth()->login($user);
        return response()->json(['success' => true, 'user' => $user]);
    }

    // Envoi OTP
    public function sendOtp($email)
    {
        $user = User::where('email', $email)->first();
        if (!$user) return response()->json(['success' => false, 'message' => 'Utilisateur non trouvé'], 404);

        $otp = rand(100000, 999999);
        $user->otp = $otp;
        $user->otp_expires_at = now()->addMinutes(10);
        $user->save();

        Mail::raw("Votre code OTP est : $otp", function ($message) use ($user) {
            $message->to($user->email)->subject('OTP de connexion');
        });

        return response()->json(['success' => true, 'message' => 'OTP envoyé']);
    }

    // Vérification OTP
    public function verifyOtp($email, $otp)
    {
        $user = User::where('email', $email)->first();
        if (!$user) return response()->json(['success' => false, 'message' => 'Utilisateur non trouvé'], 404);

        if ($user->otp != $otp || $user->otp_expires_at < now()) {
            return response()->json(['success' => false, 'message' => 'OTP invalide ou expiré'], 401);
        }

        auth()->login($user);
        $user->otp = null;
        $user->otp_expires_at = null;
        $user->save();

        return response()->json(['success' => true, 'user' => $user]);
    }

    // Déconnexion
    public function logout()
    {
        auth()->logout();
        return response()->json(['success' => true, 'message' => 'Déconnexion réussie']);
    }
}
