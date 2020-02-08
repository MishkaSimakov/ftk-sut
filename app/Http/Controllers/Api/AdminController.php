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
    public function code(Request $request)
    {
        $code = optional(User::where('name', $request->name)->first())->register_code;

        return json_encode($code);
    }
}
