<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

    public function __construct()
    {
       $this->productService    = new ProductService();
    }

    public function index(Request $request)
    {
        return $this->productService->listProductService($request);
    }

    public function store(ProductRequest $request)
    {
        return $this->productService->createProductService($request);
    }

    public function show($id)
    {
       return $this->productService->showProductService($id);
    }

    public function update(Request $request, $id)
    {
        return $this->productService->updateProductService($request, $id);
    }

    public function destroy($id)
    {
        return $this->productService->destroyProduct($id);
    }
}
