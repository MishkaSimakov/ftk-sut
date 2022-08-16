<?php

namespace App\Http\Controllers\Api;

use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DiscordController extends Controller
{
    public function invite(Request $request)
    {
        $user = User::find($request->get('user'));

        return response()->json(
            [
                'name' => $user->name,
                'is_teacher' => $user->type->is(UserType::Teacher),
                'is_admin' => $user->is_admin
            ]
        );
    }
}
