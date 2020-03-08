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
            'is_admin' => 'nullable|in:on,off',
            'birthday' => 'nullable|date',
            'admissioned_at' => 'nullable|date'
        ]);

        $student->update([
            'birthday' => $validatedData['birthday'] ? Carbon::parse($validatedData['birthday']) : null,
            'admissioned_at' => $validatedData['admissioned_at'] ? Carbon::parse($validatedData['admissioned_at']) : null,
            'name' => $validatedData['name']
        ]);
        $student->user->update([
           'is_admin' => ($validatedData['is_admin'] ?? null) == 'on' ? true : null,
           'name' => $validatedData['name']
        ]);


        $schedules = Schedule::whereDate('date_start', '>', Carbon::now())->get()->sortByDesc('date_start');
        $students = Student::with('user')->get();

        return redirect(route('admin.index', compact(['schedules', 'students'])));
    }
}
