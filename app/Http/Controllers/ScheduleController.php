<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSchedule;
use App\Schedule;
use App\Travel;
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
        $schedules = Schedule::future()->get()->sortBy('date_start');

        return view('schedule.index', compact('schedules'));
    }

    public function create() {
        return view('schedule.create');
    }

    public function store(StoreSchedule $request) {
        $schedule = Schedule::make(Arr::except($request->all(), ['file', 'is_travel', 'distance', 'travel_type']));
        $schedule->save();

        if ($request->is_travel === 'on') {
            Travel::make([
                'schedule_id' => $schedule->id,
                'distance' => $request->distance,
                'is_bike' => $request->travel_type === 'bike',
            ])->save();
        }

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

            'is_travel' => 'in:on,off|nullable',
            'distance' => 'required_if:is_travel,on|numeric',
            'travel_type' => 'required_if:is_travel,on|in:bike,hiking',
        ]);

        $schedule->update(Arr::except($validatedData, ['is_travel', 'distance', 'travel_type']));

        if ($schedule->travel && !key_exists('is_travel', $validatedData)) {
            $schedule->travel()->delete();
        } elseif (!$schedule->travel && key_exists('is_travel', $validatedData)) {
            Travel::make([
                'schedule_id' => $schedule->id,
                'distance' => $validatedData['distance'],
                'is_bike' => $validatedData['travel_type'] === 'bike',
            ])->save();
        } else {
            $schedule->travel()->update([
                'is_bike' => $validatedData['travel_type'] === 'bike',
                'distance' => $validatedData['distance'],
            ]);
        }

        return redirect(route('schedule.index'));
    }
}
