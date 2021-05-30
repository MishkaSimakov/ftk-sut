<?php

namespace Database\Seeders;

use App\Models\RatingPointCategory;
use Illuminate\Database\Seeder;


/**
 * Загружает категории для рейтинга из config в базу данных.
 */
class RatingSeeder extends Seeder
{
    public function run()
    {
        foreach (config('points.categories') as $point_category) {
            $category = RatingPointCategory::create([
                'name' => $point_category['name'],
                'order' => $point_category['order'],
                'slug' => $point_category['slug'],
                'color' => $point_category['color'],
            ]);

            foreach ($point_category['import_names'] as $import_name) {
                $category->importNames()->create([
                    'import_name' => $import_name
                ]);
            }
        }
    }
}
