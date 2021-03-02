<?php

namespace Database\Factories;

use App\Models\RatingPoint;
use App\Models\RatingPointCategory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class RatingPointFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RatingPoint::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'rating_point_category_id' => RatingPointCategory::all()->random()->id,
            'user_id' => User::all()->random()->id,

            'amount' => $this->faker->randomNumber(),

            'date' => $this->faker->date('Y-m'),
        ];
    }
}
