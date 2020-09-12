<?php

namespace App\Http\Controllers;

use App\Achievements\Events\UserGoToTravel;
use App\Imports\TravelRatingsImport;
use App\Schedule;
use App\Travel;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class TravelController extends Controller
{
    public function import(Request $request)
    {
        $rows = Excel::toCollection(
            new TravelRatingsImport(),
            $request->file
        )[0];

        $bike_travels_start = $rows[0]->search(function ($cell) {
            return $cell === 'Велопоходы';
        });

        $users = $rows->slice(3)->map(function ($row) {
            return User::where('name', $row->first())->first();
        });

        $travels = Schedule::travels();

        foreach ($rows[1] as $index => $cell) {
            if (!is_numeric($cell)) {
                continue;
            }

            $date = Carbon::parse(Date::excelToDateTimeObject($cell));
            $schedule = $travels->where('date_start', $date)->first();

            $travel = Travel::make();

            $travel->is_bike = $index >= $bike_travels_start;
            $travel->distance = $rows[2][$index];

            if (!$schedule) {
                $schedule = Schedule::make();

                $schedule->title = ($travel->is_bike ? 'Велопоход ' : 'Поход ') . $date->locale('ru')->isoFormat('Do MMMM YYYY');
                $schedule->date_start = $date;
                $schedule->date_end = $date;

                $schedule->save();
            }

            $travel->schedule_id = $schedule->id;

            $travel->save();

            foreach ($users as $user_index => $user) {
                if (!$user or !$rows[$user_index][$index]) {
                    continue;
                }

                $travel->users()->save(
                    $user,
                    [
                        'distance' => $rows[$user_index][$index]
                    ]
                );

                UserGoToTravel::dispatch($user);
            }
        }

        return redirect()->back();
    }

    public function rating($year)
    {
        $users = User::whereHas('travels', function (Builder $query) use ($year) {
            $query->academicYear(explode('-', $year));
        })->get();

        $categories = collect([
            [
                'id' => 0,
                'color' => '#F07167',
                'title' => 'Походы - осень'
            ],
            [
                'id' => 1,
                'color' => '#00ABE7',
                'title' => 'Походы - зима'
            ],
            [
                'id' => 2,
                'color' => '#D1D646',
                'title' => 'Походы - весна'
            ],
            [
                'id' => 3,
                'color' => '#847979',
                'title' => 'Велопоходы'
            ],
        ]);

        $data = $users->map(function ($user) use ($categories, $year) {
            $travels = $user->travels()->academicYear(explode('-', $year));

            return [
                'user' => $user,
                'total' => $user->travels()->academicYear(explode('-', $year))->sum('travel_users.distance'),
                'points' => $categories->map(function ($category) use ($user, $year) {
                    return [
                        'id' => $category['id'],
                        'amount' => $category['id'] === 3 ?
                            $user->travels()->academicYear(explode('-', $year))->bike()->sum('travel_users.distance') :
                            $user->travels()->academicYear(explode('-', $year))->season($category['id'])->hiking()->sum('travel_users.distance'),
                        'color' => $category['color'],
                        'title' => $category['title']
                    ];
                })
            ];
        });

        return response()->json([$categories, $data]);
    }

    public function show_rating($year)
    {
        return view('travels.rating', compact('year'));
    }
}
