<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Rating;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use function MongoDB\BSON\toJSON;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function chart(Request $request)
    {
        $rating = Rating::where('date', $request->date)->first();
        $students = $rating->uniqueStudents();

        $categories = Category::categories();

        $chartData = [];

        foreach ($students as $student) {
            $studentPoints = ['us|' . optional($student->user)->id . '|' . $student->name];

            foreach ($categories as $category) {
                array_push($studentPoints, $student->getAmount($rating, $category), 'stroke-width: 1; stroke-color: black;');
            }

            array_push($studentPoints, array_sum($studentPoints));

            array_push($chartData, $studentPoints);
        }

        return json_encode($chartData);
    }
}
