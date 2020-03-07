<?php

namespace App\Http\Controllers\Admin;

use App\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Achievement;
use Illuminate\Support\Arr;
use function view;
use App\Schedule;
use App\StudentSchedule;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        $schedules = Schedule::whereDate('date_start', '>', Carbon::now())->get()->sortByDesc('date_start');
        $students = Student::with('user')->get();

        return view('admin.index', compact(['schedules', 'students']));
    }

    public function settings(Request $request, Student $student)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:50|string',
            'is_admin' => 'boolean|required',
            'birthday' => 'nullable|date',
            'admissioned_at' => 'nullable|date'
        ]);

        $student->update([
            'birthday' => Carbon::parse($validatedData['birthday']),
            'admissioned_at' => Carbon::parse($validatedData['admissioned_at']),
        ]);
//        $student->user->updater


        $schedules = Schedule::whereDate('date_start', '>', Carbon::now())->get()->sortByDesc('date_start');
        $students = Student::with('user')->get();

        return view('admin.index', compact(['schedules', 'students']));
    }
}
