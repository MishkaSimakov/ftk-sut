<?php

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

function save_base64(string $base64, string $path, string $disk = 'public'): string
{
    $extension = explode('/', explode(':', substr($base64, 0, strpos($base64, ';')))[1])[1];

    $replace = substr($base64, 0, strpos($base64, ',') + 1);
    $base64 = str_replace($replace, '', $base64);
    $base64 = str_replace(' ', '+', $base64);

    $imageName = Str::random(10) . '.' . $extension;

    Storage::disk('public')->put($path . $imageName, base64_decode($base64));

    return $path . $imageName;
}
