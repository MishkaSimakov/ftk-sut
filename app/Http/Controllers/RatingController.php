<?php

namespace App\Http\Controllers;

use App\Category;
use App\Imports\RatingsImport;
use App\Point;
use App\Rating;
use App\User;
use Carbon\Carbon;
use DebugBar\DebugBar;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
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
        $categories = Category::all();

        return view('rating.show', compact(['rating', 'categories']));
    }

    public function create()
    {
        return view('rating.create');
    }

    public function store(Request $request)
    {
        $rows = Excel::toCollection(new RatingsImport, request()->file('file'));

        $rating = Rating::make();

        $rating->type = $request->type ? 'monthly' : 'yearly';

        $rating->date = new Carbon($request->date);

        if (Rating::whereDate('date', $rating->date)->exists()) {
            return redirect()->back()->with('date', 'рейтинг с такой датой уже существует!');
        }

        $rating->save();

        $categories = Category::categories();

        $ratingRows = $this->resolveRatingPoints($rows);

        foreach ($ratingRows as $key => $row) {
            $user = User::firstOrNew(['name' => $key]);

            if (!$user->exists) {
                $user->register_code = rand(10000, 99999);

                $user->save();
            }

            foreach ($row as $category => $point) {
                $user->award($rating, $categories->get($category), $point);
            }
        }

        $categories = Category::all();

        return redirect(route('rating.show', compact(['rating', 'categories'])));
    }

    protected function resolveRatingPoints($rows): array
    {
        $points = [];

        $ratingRows = $rows[0]->slice(1)->filter(function ($row) {
            return !is_null($row[0]);
        });

        foreach ($ratingRows as $row) {
            $points = Arr::add($points, $row[0], array_filter([
                    'lessons' => $row[2],
                    'games' => $row[3],
                    'press' => $row[4],
                    'travels' => $row[5],
                    'local_competitions' => $row[6],
                    'global_competitions' => $row[7]
            ]));
        }

        return $points;
    }
}
