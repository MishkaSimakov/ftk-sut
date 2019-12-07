<?php

namespace App\Http\Controllers;

use App\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function show(Teacher $teacher)
    {
        return view('teacher.show', compact('teacher'));
    }
}
