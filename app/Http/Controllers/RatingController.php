<?php

namespace App\Http\Controllers;

use App\Http\Requests\Ratings\RatingDestroyRequest;
use App\Models\RatingPoint;
use App\Services\Rating\Rating;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(RatingPoint::class, 'rating');
    }

    public function index()
    {
        return view('ratings.index');
    }

    public function create()
    {
        $this->authorize('create', RatingPoint::class);

        return view('ratings.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', RatingPoint::class);

        (new Rating())->store(
            Carbon::parse($request->get('date')),
            $request->file('rating')
        );

        return redirect()->route('rating.index');
    }

    public function showDestroyPage()
    {
        $this->authorize('delete', RatingPoint::class);

        return view('ratings.destroy');
    }

    public function destroy(RatingDestroyRequest $request)
    {
        $this->authorize('delete', RatingPoint::class);

        (new Rating())->setPeriodStartFromString($request->get('date_start'))
            ->setPeriodEndFromString($request->get('date_end'))->destroy();

        return redirect()->route('rating.index');
    }
}
