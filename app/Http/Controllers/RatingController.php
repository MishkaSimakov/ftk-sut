<?php

namespace App\Http\Controllers;

use App\Category;
use App\Imports\RatingsImport;
use App\Point;
use App\Rating;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use function view;

class RatingController extends Controller
{
    public function index(Request $request)
    {
        $ratings = Rating::all();

        return view('rating.index', compact('ratings'));
    }

    public function show(Rating $rating)
    {
        return view('rating.show', compact('rating'));
    }

    public function create()
    {
        return view('rating.create');
    }

    public function store(Request $request)
    {
        $rows = Excel::import(new RatingsImport, request()->file('file'));

        $rating = Rating::make();

        $rating->type = $request->type ? 'monthly' : 'yearly';

        $rating->date = new Carbon($request->date);

        $categories = Category::categories();

        if (Rating::whereDate('date', $rating->date)->exists()) {
            return redirect()->back()->with('date', 'рейтинг с такой датой уже существует!');
        }

        $ratingRows = $rows[0]->slice(1)->filter(function ($row) {
            return !is_null($row[0]);
        });
        dd($ratingRows->first());

        foreach ($ratingRows as $row) {
            $name = $row[0];

            if (!User::where('name', $name)->exists()) {
                $user = User::make();

                $user->name = $name;
                $user->register_code = rand(10000, 99999);

                $user->save();
            } else {
                $user = User::where('name', $name)->first();
            }

            $user->award($rating, $categories->get('lessons'), $row[2]);
            $user->award($rating, $categories->get('games'), $row[3]);
            $user->award($rating, $categories->get('press'), $row[4]);
            $user->award($rating, $categories->get('travels'), $row[5]);
            $user->award($rating, $categories->get('local_competitions'), $row[6]);
            $user->award($rating, $categories->get('global_competitions'), $row[7]);
        }

        return redirect(route('rating.show', $rating));
    }
}
