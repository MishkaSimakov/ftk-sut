<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Schedule;
use App\UserSchedule;

class ScheduleController extends Controller
{
    public function add_people(Request $request) {
    	$schedule = Schedule::where('id', $request->schedule_id)->first();

    	if (!UserSchedule::where([['user_id', $request->user_id], ['schedule_id', $request->schedule_id]])->exists()) {
    		$schedule->increment('people_count');

            $schedule->users()->attach($request->user_id);
    	}

    	return $schedule->people_count;
    }
}
