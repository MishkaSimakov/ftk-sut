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
        foreach ($this->categories() as $category => $slug) {
            factory(PointCategory::class)->create(['title' => $category, 'name' => $slug]);
        }
    }

    protected function categories(): array
    {
        return [
            'Робототехника - занятия' => 'robotics_lessons',
            'Электроника - занятия' => 'electronics_lessons',
            'Мастерская творчества - занятия' => 'creation_lessons',
            'Интеллект - занятия' => 'intelligence_lessons',

            'Игры в клубе' => 'games',
            'Газета и группа ВКонтанкте' => 'press',
            'Походы и экскурсии' => 'travels',
            'Городские соревнования' => 'local_competitions',
            'Всероссийские, международные соревнования' => 'global_competitions',
        ];
    }
}
