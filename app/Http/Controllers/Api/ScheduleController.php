<?php

namespace App\Http\Controllers\Api;

use App\UserSchedule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Schedule;

class ScheduleController extends Controller
{
    public function sign(Schedule $schedule, Request $request)
    {
        if ($request->state) {
            $schedule->users()->syncWithoutDetaching(auth()->user()->id);
        } else {
            $schedule->users()->detach(auth()->user()->id);
        }

        return response()->json($schedule->load('users'));
    }
}
