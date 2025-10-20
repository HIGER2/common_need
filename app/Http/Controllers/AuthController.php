<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\AuthService;

class AuthController extends Controller
{
    protected $service;

    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    public function loginPassword(Request $request)
    {
        return $this->service->loginPassword($request->email, $request->password);
    }

    public function sendOtp(Request $request)
    {
        return $this->service->sendOtp($request->email);
    }

    public function verifyOtp(Request $request)
    {
        return $this->service->verifyOtp($request->email, $request->otp);
    }

    public function logout()
    {
        return $this->service->logout();
    }
}
