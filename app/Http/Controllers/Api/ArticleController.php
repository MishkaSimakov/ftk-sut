<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Article;
use App\UserLike;

class ArticleController extends Controller
{
    //

    public function points(Request $request) {
    	$article = Article::where('id', $request->article_id)->first();

    	if ($request->type == 'unlike' && UserLike::where([['user_id', $request->user_id], ['article_id', $request->article_id]])->exists()) {
    		$article->decrement('points');

            UserLike::where([['user_id', $request->user_id], ['article_id', $request->article_id]])->each(function ($user_like) {
                    $user_like->delete();
            });
    	} elseif (!UserLike::where([['user_id', $request->user_id], ['article_id', $request->article_id]])->exists()) {
    		$article->increment('points');

            UserLike::where([['user_id', $request->user_id], ['article_id', $request->article_id]])->each(function ($user_like) {
                $user_like->delete();
            });

            $user_like = UserLike::make();

            $user_like->user_id = $request->user_id;
            $user_like->article_id = $request->article_id;

            $user_like->save();
    	}

    	return $article->points;
    }
}
