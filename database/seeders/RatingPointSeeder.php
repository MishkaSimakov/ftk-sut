<?php

namespace Database\Seeders;

use App\Models\RatingPoint;
use Illuminate\Database\Seeder;

class RatingPointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RatingPoint::factory(100)->create();
    }
}
