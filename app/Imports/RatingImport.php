<?php

namespace App\Imports;

use App\Models\RatingPointCategory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class RatingImport implements ToCollection, WithHeadingRow, WithMultipleSheets
{
    public $date;
    public $is_monthly;

    public function __construct(Carbon $date)
    {
        $this->date = $date;
    }

    public function sheets(): array
    {
        $sheet_name = $this->date->isoFormat('MMMMYYYY'); // TODO: make normal yearly name

        return [
            $sheet_name => new RatingImport($this->date)
        ];
    }


    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        $categories = RatingPointCategory::all();
        $users = User::all();

        foreach ($rows as $row) {
            $user = $this->findUser($row[0], $users);

            $user_points = [];

            foreach ($row->except(0) as $category => $amount) {
                if ($category = $categories->where('slug', $category)->first() and $amount) {
                    array_push(
                        $user_points,
                        [
                            'rating_point_category_id' => $category->id,
                            'user_id' => $user->id,

                            'amount' => $amount,
                            'date' => $this->date,
                        ]
                    );
                }
            }

            DB::table('rating_points')->insert($user_points);
        }
    }

    public function headingRow(): int
    {
        return 1;
    }

    public function findUser($name, $users)
    {
        if ($users->pluck('name')->contains($name)) {
            $user = $users->where('name', $name)->first();
        } else {
            $user = User::create([
                'name' => $name,
                'is_student' => true,
            ]);
        }

        return $user;
    }
}
