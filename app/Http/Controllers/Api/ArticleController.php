<?php

namespace App\Http\Controllers\Api;

use App\Achievements\Events\UserLikeArticle;
use App\Comment;
use App\Tag;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Article;
use App\UserLike;

class ArticleController extends Controller
{
    public function points(Request $request, Article $article)
    {
        if ($request->type == 'unlike' && $article->users->contains($request->user_id)) {
            $article->decrement('points');

            $article->users()->detach($request->user_id);
        } elseif ($request->type == 'like' && !$article->users->contains($request->user_id)) {
            $article->increment('points');

            $article->users()->attach($request->user_id);

            UserLikeArticle::dispatch(User::find($request->user_id), $article);
        } else {
            return response()->json('error');
        }

        return response()->json($article->points);
    }

    public function tags()
    {
        $tags = Tag::all()->sortByDesc('articleCount')->pluck('name');

        return response()->json($tags);
    }

    public function writersTop()
    {
        $users_sorted_array = [];

        $users = User::all()->sortByDesc('articleCount')->take(10);

        foreach ($users as $user) {
            array_push($users_sorted_array, [
                'name' => $user->name,
                'articleCount' => $user->articleCount,
                'url' => $user->url,
            ]);
        }

        return response()->json($users_sorted_array);
    }

    public function articlesTop(Request $request)
    {
        $articles_sorted_array = [];

        $articles = Article::published();

        if ($request->tag) {
            $articles = $articles->whereHas('tags', function ($q) use ($request) {
                $q->where('name', $request->tag);
            });
        }

        $articles = $articles->get()->sortByDesc('points')->take(10);

        foreach ($articles as $article) {
            array_push($articles_sorted_array, [
                'title' => $article->title,
                'points' => $article->points,
                'views' => views($article)->count(),
                'url' => $article->url,
            ]);
        }

        return response()->json($articles_sorted_array);
    }

    public function commentsTop()
    {
        $articles_sorted_array = [];

        $articles = Article::published()->get()
            ->sortByDesc->recentCommentCount->take(10)->filter(function ($article) {
                return $article->recentCommentCount;
            });

        foreach ($articles as $article) {
            array_push($articles_sorted_array, [
                'url' => $article->url,
                'title' => $article->title,
                'comments' => $article->recentCommentCount
            ]);
        }

        return response()->json($articles_sorted_array);
    }

//    public function articles(Request $request)
//    {
//        $articles = Article::paginate(1, ['*'], null, $request->page);
//
//        return response()->json($articles);
//    }
}
