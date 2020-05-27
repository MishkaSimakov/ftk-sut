<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSchedule;
use App\Schedule;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin'], [
            'except' => ['index']
        ]);
    }

    public function index() {
        $schedules = Schedule::all()->sortBy('date_start');

        return view('schedule.index', compact('schedules'));
    }

    public function create() {
        return view('schedule.create');
    }

    public function store(StoreSchedule $request) {
        $schedule = Schedule::make(Arr::except($request->all(), 'file'));
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

    public function edit(Schedule $schedule)
    {
        return view('schedule.edit', compact('schedule'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:100|string',
            'subtitle' => 'max:100|string',
            'date_start' => 'required|date|after:now',
            'date_end' => 'required|date|after:date_start',
        ]);

        $schedule->update($validatedData);

        return redirect(route('schedule.index'));
    }
}
