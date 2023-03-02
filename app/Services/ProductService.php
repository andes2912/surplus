<?php

namespace App\Services;

use Exception;
use App\Models\Product;
use App\Helpers\ClientResponderHelper;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\DB;

class ProductService {
    use ClientResponderHelper;

    protected $modelProduct;

    public function __construct()
    {
        $this->modelProduct = new Product();
    }

    // List Product
    public function listProductService($params)
    {
        try {
            $sort_by = $params->sort_by ?? 'created_at';
            $sort    = $params->sort ?? 'desc';
            $limit   = $params->limit ?? 10;
            $keyword = $params->keyword ?? "";

            $query = $this->modelProduct->orderBy($sort_by, $sort);
            $query->when(
                $keyword != "",
                function ($q) use ($keyword) {
                    $q->search($keyword);
                }
            );
            $itemData = $query->paginate($limit);
            return $this->responsePaginate(200, 'Success.', ProductResource::collection($itemData));
        } catch (\Exception $e) {
            return $this->responseFailed($e->getMessage());
        }
    }

    // Create Product
    public function createProductService($params)
    {
        try {
            $payloadProduct = $this->modelProduct->rawPayload($params);
            return $this->modelProduct->create($payloadProduct);
        } catch (\Exception $e) {
            return $this->responseFailed($e->getMessage());
        }
    }

    // Show Product
    public function showProductService($id)
    {
        try {
            $product = $this->modelProduct->where('id', $id)->first();
            if(!$product) throw new Exception("Product not found");

            return $this->responseSuccess(200, 'Success.', new ProductResource($product));
        } catch (\Exception $e) {
            return $this->responseFailed($e->getMessage());
        }
    }

    // Update Product
    public function updateProductService($params, $id)
    {
        try {
            $product = $this->modelProduct->where('id', $id)->first();
            if(!$product) throw new Exception("Product not found");

            $payloadUpdateProduct = $this->modelProduct->rawPayload($params);
            $updateProduct = $product->update($payloadUpdateProduct);
            if (!$updateProduct) throw new Exception("Failed to update Product.");

            return $this->responseSuccess(200, 'Success Update Product.', new ProductResource($product));
        } catch (\Exception $e) {
            return $this->responseFailed($e->getMessage());
        }
    }

    // Destroy Product
    public function destroyProduct($id)
    {
        try {
            DB::beginTransaction();
            $product = $this->modelProduct->destroy($id);
            if(!$product) throw new Exception("Product not found");

            DB::commit();
            return $this->responseSuccess(200, 'Success delete Product.', null);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->responseFailed($e->getMessage());
        }
    }
}
