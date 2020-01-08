<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Schedule;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ScheduleController extends Controller
{
    //

    public function index() {
    	$schedule = Schedule::all();

    	$lastSchedules = Schedule::whereDate('date_start', '>', Carbon::now())->get();
        $oldSchedules = Schedule::whereDate('date_start', '<=', Carbon::now())->get();

    	return view('schedule.index', compact(['oldSchedules', 'lastSchedules']));
    }

    public function create() {
    	return view('schedule.create');
    }

    public function store(Request $request) {
    	$schedule = Schedule::make();

    	$schedule->title = $request->title;

        $schedule->student_count = 0;

    	$schedule->date_start = new Carbon(str_replace('T', ' ', $request->date_start));
        $schedule->date_end = new Carbon(str_replace('T', ' ', $request->date_end));

    	$schedule->save();

    	return redirect(route('schedule.index'));
    }
}
