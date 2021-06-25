<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
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
        $users = User::whereHas('availableArticles')->select(['id', 'name'])
            ->withCount(['availableArticles', 'pointsOnArticles'])
            ->with('availableArticles.views:id')->get()->map(function (User $user) {
                $user->views_on_articles_count = $user->articles->sum(function (Article $article) {
                    return (int) $article->views->count() / 10;
                });

                return $user;
            });

        return response()->json([
            'rating' => $users->map(function ($user) {
                $total = $user->articles_count + $user->points_on_articles_count;

                return [
                    'user' => $user->only('id', 'name', 'url'),

                    'points' => $this->getCategories()->map(function ($category) use ($user, $total) {
                        return [
                            'category' => $category['id'],

                            'amount' => $amount = $user->{$category['attribute']},
                            'width' => abs($amount / $total * 100),
                        ];
                    }),
                    'total' => $total
                ];
            }),
            'categories' => $this->getCategories()->toArray(),
            'meta' => [
                'period' => [
                    'start' => '2019-05',
                    'end' => '2019-05',
                ],
            ]
        ]);
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

                'attribute' => 'available_articles_count'
            ],
            [
                'id' => 1,
                'name' => 'Оценки',
                'color' => '#FF3347',
                'order' => 2,
                'disabled' => false,

                'attribute' => 'points_on_articles_count'
            ],
            [
                'id' => 2,
                'name' => 'Просмотры (в десятках)',
                'color' => '#5BC0DE',
                'order' => 3,
                'disabled' => false,

                'attribute' => 'views_on_articles_count'
            ]
        ]);
    }

    protected function articlesForRating(Builder $builder): Builder
    {
        return $builder->published()->checked();
    }
}
