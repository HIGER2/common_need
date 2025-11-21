<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;

class UserController extends Controller
{
    protected $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return $this->service->index();
    }
    public function show($id)
    {
        return $this->service->getUserById($id);
    }
    public function store(Request $request)
    {
        return $this->service->createUser($request->all());
    }
    public function update(Request $request, $id)
    {
        return $this->service->updateUser($id, $request->all());
    }
    public function destroy($id)
    {
        return $this->service->deleteUser($id);
    }
}
