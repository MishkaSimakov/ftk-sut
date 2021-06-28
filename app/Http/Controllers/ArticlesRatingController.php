<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ArticlesRatingController extends Controller
{
    public function index()
    {
        return view('ratings.articles');
    }

    public function show(Request $request): JsonResponse
    {
        if ($request->has(['start', 'end'])) {
            $start = Carbon::parse($request->get('start'))->startOfMonth();
            $end = Carbon::parse($request->get('end'))->endOfMonth();
        } else {
            $start = Article::oldest('date')->first()->date;
            $end = now();
        }

        $users = Article::published()->checked()
            ->whereBetween('date', [$start, $end])
            ->select(['id', 'author_id'])
            ->withViewsCount()->withCount('points')->with('author')
            ->get()
            ->groupBy('author_id');

        return response()->json([
            'rating' => $users->map(function (Collection $articles) {
                $total = $this->getCategories()->sum(function ($category) use ($articles) {
                    return $this->{$category['method']}($articles);
                });

                return [
                    'user' => $articles->first()->author->only('id', 'name', 'url'),

                    'points' => $this->getCategories()->map(function ($category) use ($articles, $total) {
                        return [
                            'category' => $category['id'],

                            'amount' => $amount = $this->{$category['method']}($articles),
                            'width' => $amount / $total * 100,
                        ];
                    }),
                    'total' => $total
                ];
            })->values(),
            'categories' => $this->getCategories()->toArray(),
            'meta' => [
                'period' => [
                    'start' => $start->format('Y-m'),
                    'end' => $end->format('Y-m'),
                ],
            ]
        ]);
    }

    protected function getTotalArticlesCount(Collection $articles): int
    {
        return $articles->count();
    }

    protected function getTotalPointsCount(Collection $articles): int
    {
        return $articles->sum('points_count');
    }

    protected function getTotalViewsCount(Collection $articles): int
    {
        return (int)$articles->sum('views_count') / 10;
    }

    protected function getCategories(): Collection
    {
        return collect([
            [
                'id' => 0,
                'name' => 'Статьи',
                'color' => '#FBB13C',
                'order' => 1,
                'disabled' => false,

                'method' => 'getTotalArticlesCount'
            ],
            [
                'id' => 1,
                'name' => 'Оценки',
                'color' => '#FF3347',
                'order' => 2,
                'disabled' => false,

                'method' => 'getTotalPointsCount',
            ],
            [
                'id' => 2,
                'name' => 'Просмотры (в десятках)',
                'color' => '#5BC0DE',
                'order' => 3,
                'disabled' => false,

                'method' => 'getTotalViewsCount',
            ]
        ]);
    }
}
