<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Article\ArticleIndexResource;
use App\Http\Resources\Article\ArticleSearchResource;
use App\Http\Resources\Article\ArticleTagIndexResource;
use App\Http\Resources\Tag\TagSearchResource;
use App\Http\Resources\User\UserSearchResource;
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
        $articles = Article::all()->sortByDesc('relevance')->take(3);

        return response()->json(
            ArticleIndexResource::collection(
                $articles
            )
        );
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

        $tags = ArticleTagIndexResource::collection(
            ArticleTag::search($query)->select(['id', 'name'])->get()
        );
        $authors = UserSearchResource::collection(
            User::search($query)->select(['id', 'name'])->get()
        );
        $articles = ArticleSearchResource::collection(
            Article::search($query)->select(['id', 'title'])->get()
        );

        return response()->json(
            $tags->concat($authors)->concat($articles)
        );
    }

    public function togglePoint(Request $request, Article $article)
    {
        dd($request->get('user'));
    }
}
