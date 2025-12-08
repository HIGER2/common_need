<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

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
    public function sendOtp($request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'email' => 'Cet email n\'existe pas.'
            ]);
        }

        $roleAuth = ['admin', 'Requester', 'BudgetOfficer', 'Vendor', 'Finance'];
        if (!in_array($user->role, $roleAuth)) {
            throw ValidationException::withMessages([
                'email' => 'You are not authorized to access this application.'
            ]);
        }

        if ($user->email === 'admin@example.com') {
            return redirect()->route('otp', ['email' => $user->email]);
        }

        $otp = rand(100000, 999999);

        $user->update([
            'pin' => $otp,
            'otp_expires_at' => now()->addMinutes(10)
        ]);


        // Contenu bilingue de l'email
        $frMessage = "Bonjour {$user->name},\n\nVoici votre code OTP pour vous connecter à votre compte : {$otp}\nCe code est valide uniquement pour quelques minutes.";

        $enMessage = "Hello {$user->name},\n\nHere is your OTP code to log in to your account: {$otp}\nThis code is valid for a few minutes only.";

        Mail::raw(
            $frMessage . "\n\n-/-\n\n" . $enMessage, // FR puis EN séparé par un trait
            fn($m) =>
            $m->to($user->email)->subject('Code OTP / OTP Code')
        );

        return redirect()->route('otp', ['email' => $user->email]);

        // return Inertia::location('/auth/otp?email=' . $user->email);
    }

    // Vérification OTP
    public function verifyOtp($request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp'   => 'required|digits:6'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => 'Email inconnu.'
            ]);
        }

        if ($user->email === 'admin@example.com') {
            if ($user->pin != $request->otp) {
                throw ValidationException::withMessages([
                    'otp' => 'OTP invalide'
                ]);
            }
            Auth::login($user);
            return Inertia::location('/');
        }


        if ($user->pin != $request->otp || $user->otp_expires_at < now()) {
            throw ValidationException::withMessages([
                'otp' => 'OTP invalide ou expiré.'
            ]);
        }

        $user->update([
            'pin' => null,
            'otp_expires_at' => null
        ]);
        Auth::login($user);

        $redirectTo = "/";
        if ($user->role === 'LiaisonOfficer') {
            $redirectTo = "/purchase-orders";
        }
        return Inertia::location($redirectTo);
    }

    // Déconnexion
    public function logout($request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        // Redirige vers login (Inertia)
        return Inertia::location('/auth/login');

        // return redirect()->route('login');
    }
}
