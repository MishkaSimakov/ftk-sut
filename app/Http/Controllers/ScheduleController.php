<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSchedule;
use App\Schedule;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ScheduleController extends Controller
{
    public function index() {
    	$schedules = Schedule::whereDate('date_start', '>', Carbon::now())->get()->sortBy('date_start');

    	return view('schedule.index', compact('schedules'));
    }

    public function archive()
    {
        $schedules = Schedule::whereDate('date_start', '<', Carbon::now())->get()->sortBy('date_start');

        return view('schedule.archive', compact('schedules'));
    }

    public function create() {
    	return view('schedule.create');
    }

    public function store(StoreSchedule $request) {
    	$schedule = Schedule::make(Arr::except($request->all(), 'file'));

    	$schedule->user_count = 0;

    	$schedule->save();

//      add image
        $image = Arr::first($request->allFiles());

        $name = Str::slug(str_replace("." . $image->getClientOriginalExtension(), "", $image->getClientOriginalName()));
        $filename = $name . '.' . $image->getClientOriginalExtension();

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
