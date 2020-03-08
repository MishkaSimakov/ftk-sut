<?php

namespace App\Http\Controllers\Api;

use App\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\Models\Media;

class ImageController extends Controller
{
    public function uploadArticleImage(Article $article, Request $request)
    {
        foreach ($request->allFiles() as $photo) {
            /** @var UploadedFile $photo */

            $name = Str::slug(str_replace("." . $photo->getClientOriginalExtension(), "", $photo->getClientOriginalName()));
            $filename = $name . '.' . $photo->getClientOriginalExtension();

            $article->addMedia($photo->path())
                ->usingFileName($filename)
                ->usingName($name)
                ->toMediaCollection();
        }
    }

    public function deleteArticleImage(Article $article, Request $request)
    {
        $media = $article->getMedia()->where('file_name', $request->name)->first();

        $article->deleteMedia($media);
    }
}
