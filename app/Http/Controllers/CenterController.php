<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\CenterService;

class CenterController extends Controller
{
    protected $service;

    public function __construct(CenterService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return $this->service->getAllCenters();
    }
    public function show($id)
    {
        return $this->service->getCenterById($id);
    }
    public function store(Request $request)
    {
        return $this->service->createCenter($request->all());
    }
    public function update(Request $request, $id)
    {
        return $this->service->updateCenter($id, $request->all());
    }
    public function destroy($id)
    {
        return $this->service->deleteCenter($id);
    }
}
