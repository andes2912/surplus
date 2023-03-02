<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryProductRequest;
use App\Services\CategoryProductService;
use Illuminate\Http\Request;

class CategoryProductController extends Controller
{
    protected $categoryProductService;

    public function __construct()
    {
        $this->categoryProductService   = new CategoryProductService;
    }

    public function index(Request $request)
    {
        return $this->categoryProductService->listCategoryProductService($request);
    }

    public function store(CategoryProductRequest $request)
    {
        return $this->categoryProductService->createCategoryProduct($request);
    }

    public function show($id)
    {
        return $this->categoryProductService->showCategoryProduct($id);
    }

    public function update(CategoryProductRequest $request, $id)
    {
        return $this->categoryProductService->updateCategoryProduct($request, $id);
    }

    public function destroy($id)
    {
        return $this->categoryProductService->destroyCategoryProduct($id);
    }
}
