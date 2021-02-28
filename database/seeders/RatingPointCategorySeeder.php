<?php

namespace Database\Seeders;

use App\Models\RatingPointCategory;
use Illuminate\Database\Seeder;

class RatingPointCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RatingPointCategory::factory()->createMany(config('points.categories'));
    }
}
