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

    }
}
