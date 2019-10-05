<?php

use App\Achievement;
use App\Point;
use App\User;
use Illuminate\Database\Seeder;
use App\Article;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $achievements = [
            'monthly_rating' => [
                [
                    'title' => 'Ну это уже много',
                    'body' => 'Набрать 10000 очков в ежемесячном рейтинге',
                    'condition' => '>=|10000'
                ],
                [
                    'title' => 'В следующий раз повезёт',
                    'body' => 'Набрать меньше 250 очков в ежемесячном рейтинге',
                    'condition' => '<|250'
                ]
            ],
            'period' => [
                [
                    'title' => 'Отважный новичок',
                    'body' => 'Попасть в 2 рейтинга',
                    'condition' => '>=|2'
                ]
            ]
        ];


        factory(User::class, 1)->create([
            'is_admin' => true,
            'password' => Hash::make('123456'),
            'email' => 'msimakov661@gmail.com'
        ]);

        foreach ($achievements as $key => $achievement_category) {
            foreach ($achievement_category as $achievement) {
                factory(Achievement::class, 1)->create([
                    'title' => $achievement['title'],
                    'body' => $achievement['body'],
                    'condition' => $achievement['condition'],
                    'category' => $key
                ]);
            }
        }

        factory(Article::class, 100)->create();
    }
}
