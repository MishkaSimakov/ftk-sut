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
    public function __construct()
    {
        $this->middleware('admin', [
            'except' => ['index', 'show']
        ]);
    }

    public function index()
    {
        $ratings = Rating::all()->sortByDesc('date');

        dd($ratings->first()->year);

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

    public function store(StoreRating $request)
    {
        $rows = Excel::toCollection(new RatingsImport, request()->file('file'));

        $rating = Rating::make();

        $rating->type = $request->type ? 'monthly' : 'yearly';
        $rating->date = Carbon::parse($request->date);

        $rating->save();


        $categories = PointCategory::all()->keyBy('slug');

        $ratingRows = $this->resolveRatingPoints($rows);
        $existsStudents = Student::whereIn('name', array_keys($ratingRows))->get()->keyBy('name');

        foreach ($ratingRows as $key => $row) {
            // get or create students
            $student = $existsStudents->get($key);

            if (!$student) {
                $student = new Student(['name' => $key]);
                $student->save();
            }

            //  award points
            $points = [];

            foreach ($row as $category => $point) {
                $points[$category] = $point;

                $student->award($rating, $categories[$category], $point);
            }

            // dispatch event
            UserEarnedPoints::dispatch($rating, $student, $points);
        }

        return redirect(route('rating.show', compact(['rating', 'categories']))); //TODO: check, maybe 'categories' parameter can be removed?
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
