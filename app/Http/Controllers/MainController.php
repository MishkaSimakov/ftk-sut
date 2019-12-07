<?php

namespace App\Http\Controllers;

use App\Advertisement;
use App\Teacher;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        $teachers = Teacher::all();
        $advertisements = Advertisement::all();

        return view('main', compact('teachers', 'advertisements'));
    }
}
