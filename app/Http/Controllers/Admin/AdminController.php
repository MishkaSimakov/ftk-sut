<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Achievement;
use function view;
use App\Schedule;
use App\StudentSchedule;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        $schedules = Schedule::whereDate('date_start', '>', Carbon::now())->get()->sortByDesc('date_start');

        return view('admin.index', compact('schedules'));
    }
}
