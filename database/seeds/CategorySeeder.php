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
        foreach ($this->categories() as $category) {
            factory(Category::class)->create($category);
        }
    }

    protected function categories(): array
    {
        return [
            [
                'name' => 'lessons', //TODO: переделать в code|slug  eloquent-sluggable | Str::slug  при сохранении модели
                'title' => 'Посещение занятий'
            ],
            [
                'name' => 'games',
                'title' => 'Игры в клубе'
            ],
            [
                'name' => 'travels',
                'title' => 'Походы и экскурсии'
            ],
            [
                'name' => 'press',
                'title' => 'Газета и группа ВКонтанкте'
            ],
            [
                'name' => 'local_competitions',
                'title' => 'Городские соревнования'
            ],
            [
                'name' => 'global_competitions',
                'title' => 'Всероссийские, международные соревнования',
            ],
        ];
    }
}
