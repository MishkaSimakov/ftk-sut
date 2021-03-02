<?php

namespace App\Http\Controllers;

use App\Http\Resources\Rating\RatingPointsIndexResource;
use App\Imports\RatingImport;
use App\Models\RatingPoint;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class RatingController extends Controller
{
    public function __construct()
    {
//        $this->middleware('admin')->except('index');
    }

    public function index($period = null)
    {
        if ($period) {
            $period = preg_split('/(\.|\-)/', $period);

            $points = RatingPoint::fromTime(
                Carbon::create($period[0], $period[1]),
                Carbon::create($period[2], $period[3])
            );
        } else {
            $points = RatingPoint::lastPoints();
        }

        $points = new RatingPointsIndexResource($points->get()->groupBy('user_id'));

        dd($points);

        return view('ratings.index', compact($points));
    }

    public function create()
    {
        return view('ratings.create');
    }

    public function store(Request $request)
    {
        Excel::import(new RatingImport(Carbon::parse($request->date)), $request->file('rating'));

        return redirect(route('ratings.index'));
    }
}
