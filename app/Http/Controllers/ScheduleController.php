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

    public function archive()
    {
        $schedules = Schedule::whereDate('date_start', '<', Carbon::now())->get()->sortBy('date_start');

        return view('schedule.archive', compact('schedules'));
    }

    public function create() {
    	return view('schedule.create');
    }

    public function store(Request $request) {
        $request->date_start = new Carbon(str_replace('T', ' ', $request->date_start));
        $request->date_end = new Carbon(str_replace('T', ' ', $request->date_end));

        $validatedData = $request->validate([
            'title' => 'required|max:100|string',
            'subtitle' => 'required|max:100|string',
            'date_start' => 'required|date|after:now',
            'date_end' => 'required|date|after:date_start',
        ]);

    	$schedule = Schedule::make($validatedData);

//    	$schedule->title = $request->title;
//    	$schedule->subtitle = $request->subtitle;
//
        $schedule->user_count = 0;
//
//    	$schedule->date_start = new Carbon(str_replace('T', ' ', $request->date_start));
//        $schedule->date_end = new Carbon(str_replace('T', ' ', $request->date_end));

    	$schedule->save();

//        add image
        $image = $request->file;

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
