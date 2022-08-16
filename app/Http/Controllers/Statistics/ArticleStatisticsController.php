<?php

namespace App\Http\Controllers\Statistics;

use App\Http\Controllers\Controller;
use App\Http\Resources\Article\ArticleStatisticsResource;
use App\Models\Article;
use App\Models\User;

class ArticleStatisticsController extends Controller
{
    public function getShortArticlesStatistics(User $user)
    {
        $articles = Article::where('author_id', $user->id)
            ->checked()->published()
            ->withCount('points')->withViewsCount()
            ->latest('date')
            ->get();

        return response()->json([
            'articles' => ArticleStatisticsResource::collection($articles->take(10)),
            'count' => [
                'articles' => $articles->count(),
                'points' => $articles->sum('points_count'),
                'views' => $articles->sum('views_count')
            ]
        ]);
    }
}
