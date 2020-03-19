<?php

namespace App\Http\Controllers\Admin;

use App\Student;
use App\Teacher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use function view;
use App\Schedule;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        $schedules = Schedule::whereDate('date_start', '>', Carbon::now())->get()->sortByDesc('date_start');
        $students = Student::with('user')->get();
        $teachers = Teacher::with('user')->get();

        return view('admin.index', compact(['schedules', 'students', 'teachers']));
    }

    public function studentSettings(Request $request, Student $student)
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

    public function teacherEdit(Teacher $teacher)
    {
        return view('teacher.edit', compact('teacher'));
    }

    public function teacherSettings(Request $request, Teacher $teacher)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|max:50|string',
            'middle_name' => 'required|max:50|string',
            'last_name' => 'required|max:50|string',
            'club_id' => 'required|integer',
        ]);

        $teacher->update($validatedData);

        return redirect(route('admin.index'));
    }
}
