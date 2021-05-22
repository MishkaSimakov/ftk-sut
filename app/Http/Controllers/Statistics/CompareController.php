<?php

namespace App\Http\Controllers\Statistics;

use App\Http\Controllers\Controller;
use App\Models\RatingPoint;
use App\Models\User;

class CompareController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('index');
    }

    public function index(User $user)
    {
        return view('statistics.compare', [
            'first' => $user,
            'second' => auth()->user()
        ]);
    }

    public function getCompareData(User $first, User $second)
    {
        $points = RatingPoint::whereIn('user_id', [$first->id, $second->id])
            ->selectRaw('sum(amount) as amount, date, user_id')
            ->groupBy('user_id', 'date')->orderBy('date')->get()->groupBy('user_id')->values();

        return response()->json([
            'points' => $points,
            'names' => [
                $first->name,
                $second->name
            ]
        ]);
    }
}
