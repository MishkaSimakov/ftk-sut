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
        $users = $rating->uniqueUsers();

        $categories = Category::categories();

        $chartData = [];

        foreach ($users as $user) {
            $userPoints = ['us|' . $user->id . '|' . $user->name];

            foreach ($categories as $category) {
                array_push($userPoints, $user->getAmount($rating, $category), 'stroke-width: 1; stroke-color: black;');
            }

            array_push($userPoints, array_sum($userPoints));

            array_push($chartData, $userPoints);
        }

        return json_encode($chartData);
    }
}
