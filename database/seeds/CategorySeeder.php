<?php

use App\User;
use App\Category;
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
            factory(Category::class)->create(['title' => $category, 'name' => $slug]);
        }
    }

    protected function categories(): array
    {
        return [
            'Посещение занятий' => 'lessons',
            'Игры в клубе' => 'games',
            'Походы и экскурсии' => 'travels',
            'Газета и группа ВКонтанкте' => 'press',
            'Городские соревнования' => 'local_competitions',
            'Всероссийские, международные соревнования' => 'global_competitions',
        ];
    }
}
