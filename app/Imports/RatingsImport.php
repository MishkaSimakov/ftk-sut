<?php

namespace App\Imports;

use App\Point;
use App\User;
use Maatwebsite\Excel\Concerns\ToModel;

class RatingsImport implements ToModel
{
    public function model(array $row)
    {
        return new Point([
            'user_name' => $row[0],

            'points_lessons' => $row[2],
            'points_games' => $row[3],
            'points_press' => $row[4],
            'points_travels' => $row[5],
            'points_local_competition' => $row[6],
            'points_global_competition' => $row[7],
        ]);
    }
}
