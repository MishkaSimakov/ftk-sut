<?php

namespace App\Imports;

use App\Point;
use Maatwebsite\Excel\Concerns\ToModel;
use mysql_xdevapi\Collection;
use PhpParser\ErrorHandler\Collecting;

class RatingsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Point([
            'user_id' => $row[0],

            'points_lessons' => $row[2],
            'points_games' => $row[3],
            'points_press' => $row[4],
            'points_travels' => $row[5],
            'points_local_competition' => $row[6],
            'points_global_competition' => $row[7],
        ]);
    }
}
