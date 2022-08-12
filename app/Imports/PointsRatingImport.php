<?php

namespace App\Imports;

use App\Enums\UserType;
use App\Models\RatingPointCategory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class PointsRatingImport implements ToCollection, WithHeadingRow, WithMultipleSheets
{
    public Carbon $date;

    public function __construct(Carbon $date)
    {
        $this->date = $date;
    }

    public function sheets(): array
    {
        $sheet_name = $this->date->isoFormat('MMMMYYYY');

        return [
            $sheet_name => new PointsRatingImport($this->date)
        ];
    }


    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $categories = RatingPointCategory::all();
        $users = User::all();

        foreach ($collection as $row) {
            if (!$row[0]) {
                break;
            }

            $user = $this->findUser($row[0], $users);

            $user_points = [];

            foreach ($row->except(0, 1) as $category => $amount) {
                if ($category = $categories->where('slug', $category)->first() and $amount) {
                    $user_points[] = [
                        'rating_point_category_id' => $category->id,
                        'user_id' => $user->id,

                        'amount' => $amount,
                        'date' => $this->date,
                    ];
                }
            }

            DB::table('rating_points')->insert($user_points);
        }
    }

    public function headingRow(): int
    {
        return 1;
    }

    public function findUser($name, $users): User
    {
        if ($users->pluck('name')->contains($name)) {
            $user = $users->where('name', $name)->first();
        } else {
            $user = User::create([
                'name' => $name,
                'type' => UserType::Pupil,
            ]);
        }

        return $user;
    }
}
