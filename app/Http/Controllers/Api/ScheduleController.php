<?php

namespace App\Http\Controllers\Api;

use App\UserSchedule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Schedule;

class ScheduleController extends Controller
{
    public function register(Request $request)
    {
        $schedule = Schedule::where('id', $request->schedule_id)->first();

        if (!UserSchedule::where([['user_id', $request->user_id], ['schedule_id', $request->schedule_id]])->exists()) {
            $schedule->increment('user_count');

            $schedule->users()->attach($request->user_id);
        } else {
            return json_encode('error');
        }

        return $schedule->user_count;
    }

    public function unregister(Request $request)
    {
        $schedule = Schedule::where('id', $request->schedule_id)->first();

        if (UserSchedule::where([['user_id', $request->user_id], ['schedule_id', $request->schedule_id]])->exists()) {
            $schedule->decrement('user_count');

            $schedule->users()->detach($request->user_id);
        } else {
            return json_encode('error');
        }

        return $schedule->user_count;
    }
}
