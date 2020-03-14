<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MarkupController extends Controller
{
    public function show($view)
    {
        return view('markup.' . $view);
    }
}
