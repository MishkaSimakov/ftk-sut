<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class RatingController extends Controller
{
    public function precheck(Request $request)
    {
        return $request->file('rating')->getClientOriginalName();
    }
}
