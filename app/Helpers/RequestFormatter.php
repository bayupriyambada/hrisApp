<?php

namespace App\Helpers;

class RequestFormatter
{
    protected $request = [];
    public static function requestInput($key, $request)
    {
        foreach ($request as $key => $value) {
            $key = request()->input($value);
        }
        return $key;
    }
}
