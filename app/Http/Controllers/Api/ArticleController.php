<?php

namespace App\Http\Controllers\Api;

use App\Achievements\Events\UserLikeArticle;
use App\Http\Resources\Article\ArticleIndexResource;
use App\Tag;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Article;

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
        $tags = Tag::all()->sortByDesc('articleCount')->map(function($tag) {
            return [
                'id' => $tag->id,
                'name' => $tag->name,
                'article_count' => $tag->articleCount
            ];
        })->values();

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

    public function get(Request $request)
    {
        $articles = $this->prepareArticles($request)
            ->paginate(10, ['*'], null, $request->page);

        return response()->json([
            'data' => ArticleIndexResource::collection($articles->items()),
            'total' => $articles->lastPage()
        ]);
    }

    public function getUserArticles(Request $request, User $user)
    {
        $articles = $this->prepareArticles($request, Article::published()->where('user_id', $user->id))
            ->paginate(10, ['*'], null, $request->page);

        return response()->json([
            'data' => ArticleIndexResource::collection($articles->items()),
            'total' => $articles->lastPage()
        ]);
    }

    public function prepareArticles(Request $request, $articles=null)
    {
        $articles = $articles ?? Article::published();

        if ($request->has('query')) {
            $query = $request->get('query');

            $articles = $articles->where(function($article) use ($query) {
                $article->orWhere('title', 'like', "%" . $query . "%")
                    ->orWhereHas('tags', function ($q) use ($query) {
                        $q->where('name', 'like', "%" . $query . "%");
                    })
                    ->orWhereHas('user', function ($q) use ($query) {
                        $q->where('name', 'like', "%" . $query . "%");
                    });
            });
        }

        if ($request->has('tag')) {
            $tag = $request->tag;

            $articles = $articles->whereHas('tags', function ($q) use ($tag) {
                return $q->where('tags.id', $tag);
            });
        }
        if ($request->has('length')) {
            $length = explode('.', $request->length);

            $length_range = [
                'short' => [0, 100],
                'medium' => [100, 500],
                'long' => [500, 10000000]
            ];

            $articles = $articles->where(function ($q) use ($length, $length_range) {
                foreach ($length as $len) {
                    $q->orWhereBetween('length', $length_range[$len]);
                }

                return $q;
            });
        }
        if ($request->has('sort')) {
            $sort = explode('.', $request->sort);

            if ($sort[0] == 'points') {
                $articles = $articles->orderBy('points', $sort[1]);
            } elseif ($sort[0] == 'views') {
                $articles = $articles->orderByViews($sort[1]);
            } elseif ($sort[0] == 'date') {
                $articles = $articles->orderBy('created_at', $sort[1]);
            }
        } else {
            $articles = $articles->orderBy('created_at', 'desc');
        }

        return $articles;
    }
}
