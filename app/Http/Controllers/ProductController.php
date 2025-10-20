<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $service;
    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }
    public function index()
    {
        return $this->service->index();
    }
    public function show($id)
    {
        return $this->service->getProductById($id);
    }
    public function store(Request $request)
    {
        return $this->service->createProduct($request->all());
    }
    public function update(Request $request, $id)
    {
        return $this->service->updateProduct($id, $request->all());
    }
    public function destroy($id)
    {
        return $this->service->deleteProduct($id);
    }
}
