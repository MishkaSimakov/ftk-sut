<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Article\ArticleIndexResource;
use App\Http\Resources\Article\ArticleTagIndexResource;
use App\Models\Article;
use App\Models\ArticleTag;
use App\Models\User;
use Illuminate\Http\Request;


class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $articles = Article::paginate(Article::PAGINATION_LIMIT)->items();

        return response()->json(
            ArticleIndexResource::collection(
                $articles
            )
        );
    }

    public function best()
    {
//        $articles = Article::select('id', 'date')->
    }

    public function tags()
    {
        $tags = ArticleTag::all();

        return response()->json(
            ArticleTagIndexResource::collection($tags)
        );
    }

    public function search(Request $request)
    {
        $query = $request->get('query');

        $tags = ArticleTag::where('name', 'like', "%{$query}%")->select('id', 'name')->get();
        $authors = User::where('name', 'like', "%{$query}%")->select('id', 'name')->get();
        $articles = Article::where('title', 'like', "%{$query}%")->orWhere('body', 'like', "%{$query}%")->select('id', 'title')->get();

        return response()->json([
            'tags' => ArticleTagIndexResource::collection($tags),
            'authors' => $authors,
            'articles' => ArticleIndexResource::collection($articles),
        ]);
    }

    public function togglePoint(Request $request, Article $article)
    {
        dd($request->get('user'));
    }
}
