<?php

namespace App\Http\Controllers\Statistics;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;

class EventStatisticsController extends Controller
{
    public function getShortEventsStatistics(User $user)
    {
        return response()->json([
            'totalEventsCount' => $user->events()->count(),
            'totalTravelsCount' => $user->events()->whereHas('travel')->count(),
            'totalPassedDistance' => $user->events()
                ->whereHas('travel')
                ->withPivot('distance_traveled')->with('travel')
                ->get()->sum(function (Event $event) {
                    return $event->pivot->distance_traveled ?? $event->travel->distance;
                })
        ]);
    }
}
