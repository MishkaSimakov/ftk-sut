<?php

use App\User;
use Illuminate\Database\Seeder;

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
            'is_admin' => true,
            'password' => \Illuminate\Support\Facades\Hash::make('123456'),
            'email' => 'msimakov661@gmail.com'
        ]);

        factory(\App\Category::class)->create(['name' => 'lessons', 'title' => 'посещение занятий']);
        factory(\App\Category::class)->create(['name' => 'games', 'title' => 'игры в клубе']);
        factory(\App\Category::class)->create(['name' => 'travels', 'title' => 'походы и экскурсии']);
        factory(\App\Category::class)->create(['name' => 'press', 'title' => 'газета и группа ВКонтанкте']);
        factory(\App\Category::class)->create(['name' => 'local_competitions', 'title' => 'Городские соревнования']);
        factory(\App\Category::class)->create(['name' => 'global_competitions', 'title' => 'Всероссийские, международные соревнования']);
    }
}
