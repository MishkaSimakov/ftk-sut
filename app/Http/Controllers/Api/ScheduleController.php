<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Schedule;
use App\StudentSchedule;

class ScheduleController extends Controller
{
    public function add_student(Request $request)
    {
        $schedule = Schedule::where('id', $request->schedule_id)->first();

        if (!StudentSchedule::where([['student_id', $request->student_id], ['schedule_id', $request->schedule_id]])->exists()) {
            $schedule->increment('student_count');

            $schedule->students()->attach($request->student_id);
        }

        return $schedule->student_count;
    }
}
