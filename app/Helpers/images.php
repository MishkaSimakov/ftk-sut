<?php

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

function save_base64(string $base64, string $path): string
{
    $extension = explode('/', explode(':', substr($base64, 0, strpos($base64, ';')))[1])[1];

    $replace = substr($base64, 0, strpos($base64, ',') + 1);
    $base64 = str_replace($replace, '', $base64);
    $base64 = str_replace(' ', '+', $base64);

    $image_name = Str::random(10) . '.' . $extension;

//    $path = '\\articles\\' . $image_name . '.' . $extension;

    Image::make(base64_decode($base64))
        ->widen(1024)
        ->save(public_path('storage' . '\\' . $path . '\\' . $path . '.' . $extension));

//    Storage::disk('public')->put($path . $image_name, base64_decode($base64));

    return $path . $image_name;
}
