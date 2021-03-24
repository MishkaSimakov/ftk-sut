<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Article\ArticleIndexResource;
use App\Models\Article;
use Illuminate\Http\Request;


class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $articles = Article::paginate(50)->items();

        return response()->json(
            ArticleIndexResource::collection(
                $articles
            )
        );
    }
}
