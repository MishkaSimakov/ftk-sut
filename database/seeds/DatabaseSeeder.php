<?php

use App\Achievement;
use App\Point;
use App\User;
use Illuminate\Database\Seeder;
use App\Student;

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
            'rating' => [
                [
                    'title' => 'Ну это уже много',
                    'body' => 'Набрать 10000 очков в ежемесячном рейтинге',
                    'code' => 'if ($point->points > 10000) { getAchievement(); }'
                ],
                [
                    'title' => 'В следующий раз повезёт',
                    'body' => 'Набрать меньше 250 очков в ежемесячном рейтинге',
                    'code' => 'if ($point->points < 250) { getAchievement(); }'
                ]
            ],
            'period' => [
                [
                    'title' => 'Отважный новичок',
                    'body' => 'Попасть в 2 рейтинга',
                    'code' => 'incrementAchievementProgress(1); if (GetUserAchievement($point->user, $achievement)->progress >= 2) { getAchievement(); }'
                ]
            ]
        ];


        factory(User::class, 1)->create([
            'isAdmin' => true,
            'password' => Hash::make('123456'),
            'email' => 'msimakov661@gmail.com'
        ]);

        foreach ($achievements as $key => $achievement_category) {
            foreach ($achievement_category as $achievement) {
                factory(Achievement::class, 1)->create([
                    'title' => $achievement['title'],
                    'body' => $achievement['body'],
                    'code' => $achievement['code'],
                    'category' => $key
                ]);
            }
        }
    }
}
