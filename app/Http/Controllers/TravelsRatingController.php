<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class TravelsRatingController extends Controller
{
    public function index()
    {
        return view('ratings.travels');
    }

    public function show(Request $request)
    {
        if ($request->has(['start', 'end'])) {
            $start = Carbon::parse($request->get('start'))->startOfMonth();
            $end = Carbon::parse($request->get('end'))->endOfMonth();
        } else {
            $start = Event::travels()->oldest('date_start')->first()->date_start;
            $end = now();
        }

        $users = User::with(['events' => function (Builder $builder) use ($start, $end) {
            return $builder->whereHas('travel')
                ->whereBetween('date_start', [$start, $end]);
        }]);



//        return response()->json([
//            'rating' => $users->map(function (Collection $articles) {
//                $total = $this->getCategories()->sum(function ($category) use ($articles) {
//                    return $this->{$category['method']}($articles);
//                });
//
//                return [
//                    'user' => $articles->first()->author->only('id', 'name', 'url'),
//
//                    'points' => $this->getCategories()->map(function ($category) use ($articles, $total) {
//                        return [
//                            'category' => $category['id'],
//
//                            'amount' => $amount = $this->{$category['method']}($articles),
//                            'width' => $amount / $total * 100,
//                        ];
//                    }),
//                    'total' => $total
//                ];
//            })->values(),
//            'categories' => $this->getCategories()->toArray(),
//            'meta' => [
//                'period' => [
//                    'start' => $start->format('Y-m'),
//                    'end' => $end->format('Y-m'),
//                ],
//            ]
//        ]);
    }
}
