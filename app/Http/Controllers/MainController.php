<?php

namespace App\Http\Controllers;

use App\Teacher;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        $teachers = Teacher::all();

        return view('main', compact('teachers'));
    }
}
