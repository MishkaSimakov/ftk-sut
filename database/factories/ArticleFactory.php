<?php

namespace Database\Factories;

use App\Enums\ArticleType;
use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Article::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'body' => $this->faker->text,
            'author_id' => User::factory()->create()->id,

            'type' => ArticleType::Checked(),
            'date' => $this->faker->date,
        ];
    }
}
