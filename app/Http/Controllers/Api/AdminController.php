<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\UserAchievement;
use App\Achievement;
use function MongoDB\BSON\toJSON;

class AdminController extends Controller
{
    //
    public function register_link(Request $request) {
    	$link = User::where('name', $request->name)->first()->registerLink;

    	return json_encode($link);
    }

    public function achievements (Request $request) {
        $user_achievement = UserAchievement::make();

        $user_achievement->user_id = $request->teacher_id;
        $user_achievement->achievement_id = $request->achievement_id;
        $user_achievement->completed = true;

        $user_achievement->save();

        User::where('id', $request->teacher_id)->first()->incrementPoints = Achievement::where('id', $request->achievement_id)->first()->points;

        return 'all ok!';
    }
}
