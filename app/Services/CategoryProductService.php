<?php

namespace App\Services;

use Exception;
use App\Models\CategoryProduct;
use App\Helpers\ClientResponderHelper;
use App\Http\Resources\CategoryProductResource;
use Illuminate\Support\Facades\DB;

class CategoryProductService {
    use ClientResponderHelper;

    protected $modelCategoryProduct;

    public function __construct()
    {
        $this->modelCategoryProduct = new CategoryProduct();
    }

    // List Category Product
    public function listCategoryProductService($params)
    {
       try {
            $sort_by = $params->sort_by ?? 'created_at';
            $sort    = $params->sort ?? 'desc';
            $limit   = $params->limit ?? 10;
            $keyword = $params->keyword ?? "";

            $query = $this->modelCategoryProduct->orderBy($sort_by, $sort);
            $query->when(
                $keyword != "",
                function ($q) use ($keyword) {
                    $q->search($keyword);
                }
            );
            $itemData = $query->paginate($limit);
            return $this->responsePaginate(200, 'Success.', CategoryProductResource::collection($itemData));
       } catch (\Exception $e) {
            return $this->responseFailed($e->getMessage());
       }
    }

    // Create Category Product
    public function createCategoryProduct($params)
    {
        try {
            $payloadCategoryProduct = $this->modelCategoryProduct->rawPayload($params);
            return $this->modelCategoryProduct->create($payloadCategoryProduct);
        } catch (\Exception $e) {
            return $this->responseFailed($e->getMessage());
        }
    }

    // Show Category Product
    public function showCategoryProduct($id)
    {
        try {
            $categoryProduct = $this->modelCategoryProduct->where('id',$id)->first();
            if(!$categoryProduct) throw new Exception("Category Product not found");

            return $this->responseSuccess(200, 'Success.', new CategoryProductResource($categoryProduct));
        } catch (\Exception $e) {
            return $this->responseFailed($e->getMessage());
        }
    }

    // Update Category Product
    public function updateCategoryProduct($params,$id)
    {
        try {
            $categoryProduct = $this->modelCategoryProduct->where('id',$id)->first();
            if(!$categoryProduct) throw new Exception("Category Product not found");

            $payloadUpdateCategoryProduct   = $this->modelCategoryProduct->rawPayload($params);
            $updateCategoryProduct  = $categoryProduct->update($payloadUpdateCategoryProduct);
            if (!$updateCategoryProduct) throw new Exception("Failed to update Category Product.");

            return $this->responseSuccess(200, 'Success Update Category Product.', new CategoryProductResource($categoryProduct));
        } catch (\Exception $e) {
            return $this->responseFailed($e->getMessage());
        }
    }

    // Destroy Category Product
    public function destroyCategoryProduct($id)
    {
        try {
            DB::beginTransaction();
            $categoryProduct = $this->modelCategoryProduct->destroy($id);
            if(!$categoryProduct) throw new Exception("Category Product not found");

            DB::commit();
            return $this->responseSuccess(200, 'Success delete Category Product.', null);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->responseFailed($e->getMessage());
        }
    }

}
