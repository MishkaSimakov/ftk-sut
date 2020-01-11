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

            'games' => $row[3],
            'press' => $row[4],
            'travels' => $row[5],
            'local_competitions' => $row[6],
            'global_competitions' => $row[7],

            'robotics_lessons' => $row[8],
            'electronics_lessons' => $row[9],
            'creation_lessons' => $row[10],
            'intelligence_lessons' => $row[11],
        ]);
    }
}
