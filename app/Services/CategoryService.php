<?php

namespace App\Services;

use Exception;
use App\Models\Category;
use App\Helpers\ClientResponderHelper;
use App\Http\Resources\CategoryResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CategoryService {
    use ClientResponderHelper;

    private $modelCategory;

    public function __construct()
    {
        $this->modelCategory = new Category();
    }

    // List Category
    public function listCategoryService($params)
    {
        try {
            $sort_by = $params->sort_by ?? 'created_at';
            $sort    = $params->sort ?? 'desc';
            $limit   = $params->limit ?? 10;
            $keyword = $params->keyword ?? "";

            $query = $this->modelCategory->orderBy($sort_by, $sort);
            $query->when(
                $keyword != "",
                function ($q) use ($keyword) {
                    $q->search($keyword);
                }
            );
            $itemData = $query->paginate($limit);
            return $this->responsePaginate(200, 'Success.', CategoryResource::collection($itemData));
        } catch (\Exception $e) {
            return $this->responseFailed($e->getMessage());
        }
    }

    // Create Category
    public function crateCategoryService($params)
    {
        try {
            $payloadCategory = $this->modelCategory->rawPayload($params);
            return $this->modelCategory->create($payloadCategory);
        } catch (\Exception $e) {
            return $this->responseFailed($e->getMessage());
        }
    }

    // Show Category
    public function showCategoryService($id)
    {
        try {
            $category = $this->modelCategory::where('id',$id)->first();
            if(!$category) throw new Exception("Category not found");

            return $this->responseSuccess(200, 'Success Create Category.', new CategoryResource($category));
        } catch (\Exception $e) {
            return $this->responseFailed($e->getMessage());
        }
    }

    // Update Category
    public function updateCategoryService($params, $id)
    {
        try {
            $category = $this->modelCategory->where('id', $id)->first();
            if(!$category) throw new Exception("Category not found");

            $payloadUpdateCategory = $this->modelCategory->rawPayload($params);
            $updateCategory = $category->update($payloadUpdateCategory);
            if (!$updateCategory) throw new Exception("Failed to update Category.");

            return $this->responseSuccess(200, 'Success Update Category.', new CategoryResource($category));
        } catch (\Exception $e) {
            return $this->responseFailed($e->getMessage());
        }
    }

    // Destroy Categoty
    public function destroyCategoryService($id)
    {
        try {
            DB::beginTransaction();
            $category = $this->modelCategory->destroy($id);
            if(!$category) throw new Exception("Category not found");

            DB::commit();
            return $this->responseSuccess(200, 'Success delete Category.', null);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->responseFailed($e->getMessage());
        }
    }
}
