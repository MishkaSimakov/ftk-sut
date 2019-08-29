<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use function MongoDB\BSON\toJSON;

class AdminController extends Controller
{
    //
    public function register_link(Request $request) {
    	$link = User::where('name', $request->name)->first()->registerLink;

    	return json_encode($link);
    }
}
