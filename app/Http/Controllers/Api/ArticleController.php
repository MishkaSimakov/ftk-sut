<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ArticleSearchService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;


class ArticleController extends Controller
{
    public function search(Request $request): JsonResponse
    {
        $query = $request->get('query');

        return response()->json(
            (new ArticleSearchService())->getQueryResults($query)
        );
    }

    public function storeImage(Request $request)
    {
        $file = $request->file('image');

        $name = Str::random(40);
        $extension = $file->extension();
        $path = "/articles/{$name}.{$extension}";

        $image = Image::make($file);
        if ($image->width() > 1280) {
            $image = $image->widen(1280);
        }

        Storage::disk('temp')->put($path, $image->encode());

        return Storage::disk('temp')->url($path);
    }
}
