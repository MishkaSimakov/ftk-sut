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
        factory(User::class)->create([
            'is_admin' => true,
            'name' => 'Симаков Михаил',
            'email' => 'msimakov661@gmail.com'
        ]);

        factory(User::class)->create([
            'is_admin' => true,
            'name' => 'Тестовый тест',
            'email' => 'test@test.com'
        ]);

        $this->call(AchievementSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(TeacherSeeder::class);
        $this->call(ClubSeeder::class);
//        $this->call(ArticleSeeder::class);
//        $this->call(ScheduleSeeder::class);
    }
}
