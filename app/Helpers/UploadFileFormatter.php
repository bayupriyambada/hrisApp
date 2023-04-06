<?php

namespace App\Helpers;

class UploadFileFormatter
{
    public static function uploadFile($file = '')
    {
        if (request()->hasFile($file)) {
            $path = request()->file($file)->store($file);
        }
        if (file_exists($file)) {
            unlink($file);
        }
        return isset($path) ? $path : '';
    }
}
