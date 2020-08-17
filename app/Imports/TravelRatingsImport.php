<?php

namespace App\Imports;

use App\Schedule;
use App\Travel;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class TravelRatingsImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        $bike_travels_start = $rows[0]->search(function ($cell) {
            return $cell === 'Велопоходы';
        });

        $users = $rows->slice(3)->map(function ($row) {
            return User::where('name', $row->first())->first();
        });

        $travels = Schedule::travels();

        foreach ($rows[1] as $index => $cell) {
            if (!is_numeric($cell)) {
                return;
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
            }
        }
    }
}
