<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TravelsRatingController extends Controller
{
    public function index()
    {
        return view('ratings.travels');
    }

    public function show(Request $request)
    {
        $seasons = collect([
            [
                'name' => 'Зима',
                'color' => '#4065F6',
                'months' => [1, 2, 12]
            ],
            [
                'name' => 'Весна',
                'color' => '#57B439',
                'months' => [3, 4, 5]
            ],
            [
                'name' => 'Лето',
                'color' => '#52AFCF',
                'months' => [6, 7, 8]
            ],
            [
                'name' => 'Осень',
                'color' => '#ED702D',
                'months' => [9, 10, 11]
            ],
        ]);

        if ($request->has(['start', 'end'])) {
            $start = Carbon::parse($request->get('start'))->startOfMonth();
            $end = Carbon::parse($request->get('end'))->endOfMonth();
        } else {
            $start = (today()->month >= 9 ? today() : today()->subYear())->setMonth(9)->startOfMonth();
            $end = now();
        }

        $users = User::with(['events' => function ($builder) use ($start, $end) {
            return $builder->fromPeriod(CarbonPeriod::create($start, $end))
                ->withPivot('distance_traveled')->whereHas('travel')
                ->select([DB::raw(
                    "case
                        when MONTH(date_start) in (1, 2, 12) then 0
                        when MONTH(date_start) in (3, 4, 5) then 1
                        when MONTH(date_start) in (6, 7, 8) then 2
                        else                                     3
                    end as season"
                ), DB::raw('SUM(distance_traveled) as distance_traveled'), 'user_id'])
                ->groupBy('season', 'user_id');
        }])->whereHas('events', function ($builder) use ($start, $end) {
            return $builder->fromPeriod(CarbonPeriod::create($start, $end))->whereHas('travel');
        })->get();

        return response()->json([
            'rating' => $users->map(function (User $user) use ($seasons) {
                $total = $user->events->sum('distance_traveled');

                return [
                    'user' => $user->only('id', 'name', 'url'),

                    'points' => $user->events->map(function ($travel) use ($total) {
                        return [
                            'category' => $travel->season,

                            'amount' => $amount = $travel->distance_traveled,
                            'width' => $amount / $total * 100,
                        ];
                    }),

                    'total' => $total
                ];
            })->values(),
            'categories' => $seasons->map(function ($season, $index) {
                return [
                    'id' => $index,
                    'name' => $season['name'],
                    'color' => $season['color'],
                    'order' => $index,
                    'disabled' => false,
                ];
            }),
            'meta' => [
                'period' => [
                    'start' => $start->format('Y-m'),
                    'end' => $end->format('Y-m'),
                ],
            ]
        ]);
    }
}
