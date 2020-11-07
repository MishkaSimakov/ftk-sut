<?php

namespace Database\Factories;

use App\Models\RatingPointCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
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
            'name' => $name = $this->faker->words,
            'slug' => Str::slug($name),
            'color' => $this->faker->hexColor,
            'order' => $this->faker->unique(),
        ];
    }
}
