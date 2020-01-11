<?php

namespace App\Http\Controllers;

use App\PointCategory;
use App\Imports\RatingsImport;
use App\Rating;
use App\Student;
use Carbon\Carbon;
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
        $categories = PointCategory::all();

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
            return redirect()->back()->with('date', 'Рейтинг с такой датой уже существует.');
        }

        $rating->save();

        $categories = PointCategory::categories();

        $ratingRows = $this->resolveRatingPoints($rows);

        foreach ($ratingRows as $key => $row) {
            $student = Student::firstOrCreate(['name' => $key]);

            foreach ($row as $category => $point) {
                if (is_null($categories->get($category))) {
                    dd($category);
                }

                $student->award($rating, $categories->get($category), $point);
            }
        }

        $categories = PointCategory::all();

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
                'games' => $row[3],
                'press' => $row[4],
                'travels' => $row[5],
                'local_competitions' => $row[6],
                'global_competitions' => $row[7],

                'robotics_lessons' => $row[8],
                'electronics_lessons' => $row[9],
                'creation_lessons' => $row[10],
                'intelligence_lessons' => $row[11],
            ]));
        }

        return $points;
    }
}
