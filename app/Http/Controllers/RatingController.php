<?php

namespace App\Http\Controllers;

use App\Services\RatingService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    protected RatingService $ratingService;

    public function __construct(RatingService $ratingService)
    {
        $this->middleware('admin')->except('index');

        $this->ratingService = $ratingService;
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
        $this->ratingService->storeRating(
            Carbon::parse($request->get('date')),
            $request->file('rating')
        );

        return redirect()->route('rating.index');
    }
}
