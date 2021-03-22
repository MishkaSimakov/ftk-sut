<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Article\ArticleIndexResource;
use App\Models\Article;


class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::all();

        return response()->json(
            ArticleIndexResource::collection($articles)
        );
    }
}
