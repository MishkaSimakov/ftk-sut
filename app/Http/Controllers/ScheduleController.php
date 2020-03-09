<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Schedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ScheduleController extends Controller
{
    public function index() {
    	$schedules = Schedule::whereDate('date_start', '>', Carbon::now())->get()->sortBy('date_start');

    	return view('schedule.index', compact('schedules'));
    }

    public function create() {
    	return view('schedule.create');
    }

    public function store(Request $request) {
    	$schedule = Schedule::make();

    	$schedule->title = $request->title;
    	$schedule->subtitle = $request->subtitle;

        $schedule->student_count = 0;

    	$schedule->date_start = new Carbon(str_replace('T', ' ', $request->date_start));
        $schedule->date_end = new Carbon(str_replace('T', ' ', $request->date_end));

    	$schedule->save();


        $image = $request->file;

        $filename = $image->getClientOriginalName();
        $name = str_replace("." . $image->getClientOriginalExtension(), "", $filename);

        $schedule->addMedia($image->path())
            ->usingFileName($filename)
            ->usingName($name)
            ->toMediaCollection();

    	return redirect(route('schedule.index'));
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return redirect(route('schedule.index'));
    }
}
