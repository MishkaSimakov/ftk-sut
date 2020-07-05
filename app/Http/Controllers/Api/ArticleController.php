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
        $users = User::has('articles')->with('articles')->get();

        $bycount = $users->sortByDesc('articleCount')->take(10)->map(function($user) {
            return [
                'url' => $user->url,
                'name' => $user->name,
                'count' => $user->articleCount
            ];
        })->values();

        $bypoints = $users->sortByDesc('articlesPointSum')->take(10)->map(function($user) {
            return [
                'url' => $user->url,
                'name' => $user->name,
                'count' => $user->articlesPointSum
            ];
        })->values();

        $byviews = $users->sortByDesc('articlesViewSum')->take(10)->map(function($user) {
            return [
                'url' => $user->url,
                'name' => $user->name,
                'count' => $user->articlesViewSum
            ];
        })->values();

        return response()->json([
            'count' => $bycount,
            'points' => $bypoints,
            'views' => $byviews,
        ]);
    }

    public function articlesTop(Request $request)
    {
        $articles = Article::published()
            ->get()
            ->where('rating', '>', 0)
            ->sortByDesc('rating')
            ->take(10)
            ->map(function ($article) {
                return [
                    'total' => $article->rating,
                    'title' => $article->title,
                    'points' => $article->points,
                    'views' => $article->views,
                    'url' => $article->url,
                ];
            })
            ->values();

        return response()->json($articles);
    }

    public function recentActions()
    {
        $articles = Article::published()->where('created_at', '>', now()->subDays(3))->orderBy('created_at', 'desc')->limit(10)->get()->values();
        $comments = Article::published()->get()->where('recentCommentCount', '>', 0)->sortByDesc('recentCommentCount')->take(10)->map(function ($article) {
            return [
                'url' => $article->url,
                'title' => $article->title,
                'comments' => $article->recentCommentCount,
            ];
        })
        ->values();


        return response()->json([
            'articles' => $articles,
            'comments' => $comments
        ]);
    }

//    public function articles(Request $request)
//    {
//        $articles = Article::paginate(1, ['*'], null, $request->page);
//
//        return response()->json($articles);
//    }
}
