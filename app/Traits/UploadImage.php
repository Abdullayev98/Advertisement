<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

trait  UploadImage
{
    public static function uploadPhoto($photo, $path, $image = null): string
    {
        if ($image) {
            self::deletePhotos($image, $path);
        }
        $fileName = md5($photo->getClientOriginalName()).time().'.'.$photo->getClientOriginalExtension();
        Storage::disk('local')->putFileAs(
            $path,
            $photo,
            $fileName
        );
        Storage::makeDirectory("$path/thumb", 777, true);
        Image::make($photo)
            ->fit(150, 150)
            ->save(storage_path("app/$path/thumb/$fileName"), 80);

        return $fileName;
    }

    public static function deletePhotos($image, $path)
    {
        if(file_exists(storage_path("app/$path/$image"))) {
            unlink(storage_path("app/$path/$image"));
        }
        if (file_exists(storage_path("app/$path/thumb/$image"))) {
            unlink(storage_path("app/$path/thumb/$image"));
        }
    }
}
