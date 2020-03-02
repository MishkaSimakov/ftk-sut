<?php

namespace App\Http\Controllers;

use App\Achievements\Events\UserEarnedPoints;
use App\Http\Requests\StoreRating;
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
        $ratings = Rating::all()->sortByDesc('date');

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

    public function store(StoreRating $request)
    {
        $rows = Excel::toCollection(new RatingsImport, request()->file('file'));

        $rating = Rating::make();

        $rating->type = $request->type ? 'monthly' : 'yearly';
        $rating->date = Carbon::parse($request->date);

        $rating->save();


        $categories = PointCategory::categories();

        $ratingRows = $this->resolveRatingPoints($rows);
        $existsStudents = Student::whereIn('name', array_keys($ratingRows))->get()->keyBy('name'); //TODO: переделать логику на уникальные имена

        foreach ($ratingRows as $key => $row) {
            $student = Student::firstOrCreate(['name' => $key]);
//            $student = $existsStudents->get($key);
//
//            if (!$student) {
//                $student = new Student();
//
//            }

            foreach ($row as $category => $point) {
                $student->award($rating, $categories->get($category), $point);
            }

            UserEarnedPoints::dispatch($rating, $student);
        }

        $categories = PointCategory::all();

        return redirect(route('rating.show', compact(['rating', 'categories'])));
//        return '123';
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
