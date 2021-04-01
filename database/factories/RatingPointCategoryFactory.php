<?php

namespace Database\Factories;

use App\Models\RatingPointCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RatingPointCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RatingPointCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $name = $this->faker->word,
            'import_name' => $name,
            'slug' => $name,
            'color' => $this->faker->hexColor,
        ];
    }
}
