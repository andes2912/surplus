<?php

namespace App\Services;

use Exception;
use App\Models\Image;
use App\Helpers\ImageHelper;
use App\Http\Resources\ImageResource;
use App\Helpers\ClientResponderHelper;

class ImageService {
    use ClientResponderHelper, ImageHelper;

    protected $modelImage;

    public function __construct()
    {
        $this->modelImage   = new Image();
    }

    // List Image
    public function listImageService($params)
    {
        try {
            $sort_by = $params->sort_by ?? 'created_at';
            $sort    = $params->sort ?? 'desc';
            $limit   = $params->limit ?? 10;
            $keyword = $params->keyword ?? "";

            $query = $this->modelImage->orderBy($sort_by, $sort);
            $query->when(
                $keyword != "",
                function ($q) use ($keyword) {
                    $q->search($keyword);
                }
            );
            $itemData = $query->paginate($limit);
            return $this->responsePaginate(200, 'Success.', ImageResource::collection($itemData));
        } catch (\Exception $e) {
            return $this->responseFailed($e->getMessage());
        }
    }

    // Create Image
    public function createImageService($params)
    {
        try {
            $payloadImage = $this->modelImage->rawPayload($params);
            $payloadImage['name']   = $params->name;
            $uploadFile = $params->file('image');
            if($uploadFile->isValid()) {
                $fileUpload = $this->uploadFile($uploadFile, 'image');
                $imageFile  = $fileUpload['thumbnail'];
            }
            $payloadImage['file']   = $imageFile;
            $payloadImage['enable'] = $params->enable;
            return $this->modelImage->create($payloadImage);
        } catch (\Exception $e) {
            return $this->responseFailed($e->getMessage());
        }
    }

    // Show Image
    public function showImageService($id)
    {
        try {
            $image = $this->modelImage->where('id',$id)->first();
            if(!$image) throw new Exception("Image not found");

            return $this->responseSuccess(200, 'Success.', new ImageResource($image));
        } catch (\Exception $e) {
            return $this->responseFailed($e->getMessage());
        }
    }

    // Update Image
    public function updateImageService($params, $id)
    {
        try {
            $image = $this->modelImage->where('id',$id)->first();
            if(!$image) throw new Exception("Image not found");

            $payloadUpdateImage = $this->modelImage->rawPayload($params);
            $payloadUpdateImage['name']   = $params->name;
            if ($params->hasFile('image')) {
                $uploadFile = $params->file('image');
                if($uploadFile->isValid()) {
                    $fileUpload = $this->uploadFile($uploadFile, 'image');
                    $imageFile  = $fileUpload['thumbnail'];
                }
                $payloadUpdateImage['file']   = $imageFile;
            }
            $payloadUpdateImage['enable'] = $params->enable;
            $updateImage = $image->update($payloadUpdateImage);
            if (!$updateImage) throw new Exception("Failed to update Image.");

            return $this->responseSuccess(200, 'Success Update Image.', new ImageResource($image));
        } catch (\Exception $e) {
            return $this->responseFailed($e->getMessage());
        }
    }

    // Destroy Image
    public function destroyImageService($id)
    {
        try {
            $image = $this->modelImage->destroy($id);
            if(!$image) throw new Exception("Image not found");
            return $this->responseSuccess(200, 'Success delete Image.', null);
        } catch (\Exception $e) {
            return $this->responseFailed($e->getMessage());
        }
    }

}
