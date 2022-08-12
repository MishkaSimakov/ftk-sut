<?php

namespace App\Imports;

use App\Enums\TravelType;
use App\Models\Event;
use App\Models\Travel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Str;

class TravelsImport implements ToCollection, WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            0 => new TravelsImport,
        ];
    }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $bikeTravelsStart = $collection[0]->search('Велопоходы');
        $travels = [];

        foreach ($collection[1]->except(0) as $index => $date) {
            if (Str::of($date)->contains('-')) {
                $dateStart = explode('-', $date)[0];
                $dateEnd = explode('-', $date)[1];
            } else {
                $dateStart = $dateEnd = $date;
            }

            if (!is_numeric($dateStart) || !is_numeric($dateEnd)) {
                continue;
            }

            $travel = new Travel([
                'distance' => $collection[2][$index],
                'type' => (string)($index >= $bikeTravelsStart ? TravelType::Bike : TravelType::Hiking),
            ]);

            $carbonDateStart = Carbon::instance(Date::excelToDateTimeObject($dateStart));
            $carbonDateEnd = Carbon::instance(Date::excelToDateTimeObject($dateEnd));

            $travels[$index] = Event::whereHas('travel', function (Builder $query) use ($travel) {
                $query->where('type', $travel->type);
            })
                ->whereDate('date_start', $carbonDateStart)
                ->whereDate('date_end', $carbonDateEnd)
                ->first();

            if (!$travels[$index]) {
                $travels[$index] = Event::create([
                    'name' => ($travel->isHiking() ? 'Пеший' : 'Велосипедный') . ' поход ' . $carbonDateStart->isoFormat('LL'),
                    'date_start' => $carbonDateStart->setHour(8),
                    'date_end' => $carbonDateEnd->setHour(16)
                ]);

                $travels[$index]->travel()->save($travel);
            }
        }

        $users = User::select('id', 'name')->get();

        foreach ($collection->except(0, 1, 2) as $row) {
            if (!$row[0]) {
                break;
            }

            if (!($user = $users->where('name', $row[0])->first())) {
                continue;
            }

            foreach ($travels as $index => $travel) {
                if (!$row[$index]) {
                    continue;
                }

                $travel->users()->syncWithoutDetaching([
                    $user->id => [
                        'distance_traveled' => $row[$index]
                    ]
                ]);
            }
        }
    }
}
