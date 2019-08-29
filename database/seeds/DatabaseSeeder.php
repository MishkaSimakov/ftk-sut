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
        factory(User::class, 1)->create([
            'isAdmin' => true,
            'password' => Hash::make('123456'),
            'email' => 'msimakov661@gmail.com'
        ]);

        factory(Achievement::class, 1)->create([
            'title' => 'Ну это уже много',
            'body' => 'Набрать 10000 очков в ежемесячном рейтинге',
            'code' => '
            if ($point->points > 10000) {
                getAchievement();
            }
            '
        ]);

        factory(Achievement::class, 1)->create([
            'title' => 'В следующий раз повезёт',
            'body' => 'Набрать меньше 250 очков в ежемесячном рейтинге',
            'code' => '
            if ($point->points < 250) {
                getAchievement();
            }
            '
        ]);

        factory(Achievement::class, 1)->create([
            'title' => 'Отважный новичок',
            'body' => 'Попасть в 2 рейтинга',
            'code' => '
            incrementAchievementProgress(1);

            if (GetUserAchievement($point->user, $achievement)->progress >= 2) {
                getAchievement();
            }
            '
        ]);
    }
}
