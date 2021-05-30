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
            ->withCount('points')->withViewsCount()
            ->orderBy('date', 'desc')
            ->limit(10)->get();

        return response()->json([
            'articles' => ArticleStatisticsResource::collection($articles),
            'count' => [
                'articles' => $user->articles()->count(),
                'points' => $user->articles()->withCount('points')->get()->sum('points_count'),
                'views' => $user->articles()->withViewsCount()->get()->sum('views_count')
            ]
        ]);
    }
}
