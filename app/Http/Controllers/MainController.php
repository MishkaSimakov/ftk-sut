<?php

namespace App\Http\Controllers;

use App\Teacher;

class MainController extends Controller
{
    public function index()
    {
        $teachers = Teacher::all();
        $advantages = config('advantages');

        return view('main', compact('teachers', 'advantages'));
    }
}
