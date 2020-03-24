<?php

namespace App\Http\Controllers\Api;

use App\PointCategory;
use App\Rating;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use function foo\func;
use function GuzzleHttp\Psr7\str;
use function MongoDB\BSON\toJSON;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function show(Rating $rating)
    {
        $students = $rating->students()->with(['user', 'points'])->get();

        $categories = PointCategory::categories();

        $chartData = [];

        foreach ($students as $student) {
            $studentPoints = ['us|' . optional($student->user)->id];

            foreach ($categories as $category) {
                array_push($studentPoints, $student->getAmount($rating, $category), 'stroke-width: 1; stroke-color: black;');
            }

            array_push($studentPoints, array_sum($studentPoints));

            array_push($studentPoints, [optional($student->user)->id, $student->name, optional($student->user)->url]);

            array_push($chartData, $studentPoints);
        }

        $chartData = array_values(Arr::sort($chartData, function ($student) {
            return $student[19];
        }));

        return json_encode($chartData);
    }

//    public function show(Rating $rating)
//    {
//        $students = $rating->students()->with('user', 'points')->get();
//
//        $categories = PointCategory::categories();
//
//        $data = [];
//
//        foreach ($categories as $category) {
//            $data[$category->title] = [];
//        }
//
//        $labels = $students->map(function ($student) {
//           return $student->user->name;
//        });
//
//        foreach ($students as $student) {
//            foreach ($categories as $category) {
//                array_push($data[$category->title], $student->getAmount($rating, $category));
//            }
//        }
//
////        $chartData = array_values(Arr::sort($chartData, function ($student) {
////            return $student[19];
////        }));
//
//        return response()->json([$labels, $data]);
//    }
}
