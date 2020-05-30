<?php

use App\User;
use App\PointCategory;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(PointCategory::class)->create(['title' => 'Робототехника - занятия', 'slug' => 'robotics_lessons', 'color' => '#ff0000']);
        factory(PointCategory::class)->create(['title' => 'Электроника - занятия', 'slug' => 'electronics_lessons', 'color' => '#ffff00']);
        factory(PointCategory::class)->create(['title' => 'Мастерская творчества - занятия', 'slug' => 'creation_lessons', 'color' => '#000080']);
        factory(PointCategory::class)->create(['title' => 'Интеллект - занятия', 'slug' => 'intelligence_lessons', 'color' => '#ff00ff']);

        factory(PointCategory::class)->create(['title' => 'Игры и конкурсы', 'slug' => 'games', 'color' => '#993366']);
        factory(PointCategory::class)->create(['title' => 'Газета, сайт клуба, группа ВК', 'slug' => 'press', 'color' => '#ffffcc']);
        factory(PointCategory::class)->create(['title' => 'Походы и экскурсии', 'slug' => 'travels', 'color' => '#ccffff']);
        factory(PointCategory::class)->create(['title' => 'Городские соревнования', 'slug' => 'local_competitions', 'color' => '#00ff00']);
        factory(PointCategory::class)->create(['title' => 'Областные, всероссийские, международные соревнования', 'slug' => 'global_competitions', 'color' => '#ff8080']);
    }
}
