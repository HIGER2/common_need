<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService as ServicesAuthService;

class AuthController extends Controller
{
    protected $service;

    public function __construct(ServicesAuthService $service)
    {
        $this->service = $service;
    }

    public function loginPassword(Request $request)
    {
        return $this->service->loginPassword($request->email, $request->password);
    }

    public function sendOtp(Request $request)
    {
        return $this->service->sendOtp($request);
    }

    public function verifyOtp(Request $request)
    {
        return $this->service->verifyOtp($request);
    }

    public function logout(Request $request)
    {
        return $this->service->logout($request);
    }
}
