<?php

namespace App\Helpers;

use Image;
use File;
use Exception;
use Storage;
/**
 * Image Helper
 */
trait ImageHelper
{

    protected $source, $destination, $name, $width, $height, $mime_images;

    public function __construct()
    {
        // $this->mime_images =
    }

    public function setSource($data)
    {
        $this->source = $data;
    }

    public function setDestination($data)
    {
        $this->destination = $data;
    }

    public function setName($data)
    {
        $this->name = $data;
    }

    public function setHeight($data)
    {
        $this->height = $data;
    }

    public function setWidth($data)
    {
        $this->width = $data;
    }

    /**
     * Upload File
     *
     * @param Path    $pathFile        Path File
     * @param String  $destinationPath Destination File
     * @param String  $fileName        FileName
     * @param Integer $width           Width
     * @param Integer $height          Height
     *
     * @return mixed
     */
    public function uploadFile($pathFile, $destinationPath, $fileName = null, $width = 700, $height = 700)
    {
        $fileName = $fileName == null ? time() . '' . random_int(10000, 99999) . '.' . $pathFile->getClientOriginalExtension() : $fileName;
        $this->setSource($pathFile);
        $this->setDestination($destinationPath);
        $this->setName($fileName);
        $this->setWidth($width);
        $this->setHeight($height);
        $contentType = $pathFile->getMimeType();
        $mimes = ['image/jpeg', 'image/gif', 'image/png', 'image/bmp', 'image/svg+xml'];
        if (in_array($contentType, $mimes)) {
            return $this->resizeImage();
        }

        try {
            Storage::disk('public')
                ->putFileAs($this->destination, $this->source, $this->name);
            return [
                'original' => 'storage/' . $this->destination  .'/'. $this->name,
                'thumbnail' => 'storage/' . $this->destination .'/'. $this->name
            ];
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Resize Image
     *
     * @return Array
     */
    public function resizeImage()
    {

        Storage::disk('public')
            ->putFileAs($this->destination.'/original', $this->source, $this->name);

        $img = Image::make(Storage::disk('public')->get($this->destination.'/original/' . $this->name))
            ->resize(
                $this->width,
                $this->height,
                function ($constraint) {
                    $constraint->aspectRatio();
                }
            );
        $img->stream();

        Storage::disk('public')->put($this->destination.'/thumbnail/'.$this->name, $img, 'public');

        return [
            'original' => 'storage/' . $this->destination . '/original/' . $this->name,
            'thumbnail' => 'storage/' . $this->destination . '/thumbnail/' . $this->name
        ];
    }

}
