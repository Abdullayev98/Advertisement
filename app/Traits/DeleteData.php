<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

trait   DeleteData
{
    public static function deletedData($object)
    {
        $object->deleted = false;
        $object->save();
        return $object;
    }
}
