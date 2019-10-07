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
        Achievement::where('id', $request->achievement_id)->first()->users()->attach($request->teacher_id);
    }
}
