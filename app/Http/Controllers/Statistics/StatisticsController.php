<?php

namespace App\Http\Controllers\Statistics;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function compare(Request $request, User $user)
    {
        $first_user_data = $this->retrieve_user_data(auth()->user());
        $second_user_data = $this->retrieve_user_data($user);
    }

    protected function retrieve_user_data(User $user) {


        return '';
    }
}
