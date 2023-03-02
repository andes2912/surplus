<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use App\Services\ImageService;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    protected $imageService;

    public function __construct()
    {
        $this->imageService =   new ImageService;
    }

    public function index(Request $request)
    {
        return $this->imageService->listImageService($request);
    }

    public function store(ImageRequest $request)
    {
        return $this->imageService->createImageService($request);
    }

    public function show($id)
    {
       return $this->imageService->showImageService($id);
    }

    public function update(Request $request, $id)
    {
        return $this->imageService->updateImageService($request, $id);
    }

    public function destroy($id)
    {
        return $this->imageService->destroyImageService($id);
    }

}
