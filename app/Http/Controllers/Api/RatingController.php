<?php

namespace App\Http\Controllers\Api;

use App\PointCategory;
use App\Rating;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use function MongoDB\BSON\toJSON;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function chart(Request $request)
    {
        $rating = Rating::where('date', $request->date)->first();
        $students = $rating->uniqueStudents();

        $categories = PointCategory::categories();

        $chartData = [];

        foreach ($students as $student) {
            $studentPoints = ['us|' . optional($student->user)->id . '|' . $student->name];

            foreach ($categories as $category) {
                array_push($studentPoints, $student->getAmount($rating, $category), 'stroke-width: 1; stroke-color: black;');
            }

            array_push($studentPoints, array_sum($studentPoints));

            array_push($chartData, $studentPoints);
        }

        $chartData = array_values(Arr::sort($chartData, function ($student) {
            return $student[19];
        }));

        return json_encode($chartData);
    }
}
