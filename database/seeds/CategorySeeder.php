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
        foreach ($this->categores() as $category) {
            factory(Category::class)->create($category);
        }
    }

    protected function categores(): array
    {
        return [
            [
                'name' => 'lessons',
                'title' => 'посещение занятий'
            ],
            [
                'name' => 'games',
                'title' => 'игры в клубе'
            ],
            [
                'name' => 'travels',
                'title' => 'походы и экскурсии'
            ],
            [
                'name' => 'press',
                'title' => 'газета и группа ВКонтанкте'
            ],
            [
                'name' => 'local_competitions',
                'title' => 'Городские соревнования'
            ],
            [
                'name' => 'global_competitions',
                'title' => 'Всероссийские, международные соревнования'
            ],
        ];
    }
}
