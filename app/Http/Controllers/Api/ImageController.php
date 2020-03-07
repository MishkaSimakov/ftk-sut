<?php

namespace App\Http\Controllers\Api;

use App\Article;
use App\Schedule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    public function uploadArticleImage(Article $article, Request $request)
    {
        foreach ($request->allFiles() as $photo) {
            /** @var UploadedFile $photo */

            $filename = $photo->getClientOriginalName();
            $name = str_replace("." . $photo->getClientOriginalExtension(), "", $filename);

            $article->addMedia($photo->path())
                ->usingFileName($filename)
                ->usingName($name)
                ->toMediaCollection();
        }
    }

    public function deleteArticleImage(Article $article, Request $request)
    {
        dd($article);
    }
}
