<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Article;
use App\UserLike;

class ArticleController extends Controller
{
    public function points(Request $request)
    {
        $article = Article::where('id', $request->article_id)->first();

        if ($request->type == 'unlike' && UserLike::where([['user_id', $request->user_id], ['article_id', $request->article_id]])->exists()) {
            $article->decrement('points');

            $article->users()->detach($request->user_id);
        } elseif (!UserLike::where([['user_id', $request->user_id], ['article_id', $request->article_id]])->exists()) {
            $article->increment('points');

            $article->users()->attach($request->user_id);
        }

        return $article->points;
    }
}
