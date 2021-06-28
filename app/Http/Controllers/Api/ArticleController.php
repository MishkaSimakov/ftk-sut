<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ArticleController extends Controller
{
    public function storeImage(Request $request): string
    {
        $path = (new ImageUploadService())->setMaxWidth(1280)->setDisk('temp')
            ->store($request->file('image'), 'articles');

        return Storage::disk('temp')->url($path);
    }
}
