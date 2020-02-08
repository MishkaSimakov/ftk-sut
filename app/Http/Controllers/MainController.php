<?php

namespace App\Http\Controllers;

use App\Advertisement;
use App\Article;
use App\Teacher;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        $teachers = Teacher::all();
        $advantages = config('advantages');

        return view('main', compact('teachers', 'advantages'));
    }
}
