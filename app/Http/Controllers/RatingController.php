<?php

namespace App\Http\Controllers;

use App\Services\Rating\Rating;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')->except('index');
    }

    public function index()
    {
        return view('ratings.index');
    }

    public function create()
    {
        return view('ratings.create');
    }

    public function store(Request $request)
    {
        (new Rating())->store(
            Carbon::parse($request->get('date')),
            $request->file('rating')
        );

        return redirect()->route('rating.index');
    }
}
