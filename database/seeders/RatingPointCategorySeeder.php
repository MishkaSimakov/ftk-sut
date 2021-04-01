<?php

namespace Database\Seeders;

use App\Models\RatingPointCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class RatingPointCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        RatingPointCategory::factory()->createMany(config('points.categories'));

        $categories = Http::get('http://ftk-sut.ru/api/imports/category')->json();

        foreach ($categories as $category) {
            RatingPointCategory::factory()->create([
                'name' => $category['name'],
                'import_name' => Str::slug($category['name']),
                'slug' => Str::slug($category['name']),
            ]);
        }
    }
}
