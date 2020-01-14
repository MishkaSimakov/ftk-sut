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
        $admin = factory(User::class)->create([
            'is_admin' => true,
            'login' => 'admin',
            'name' => 'Симаков Михаил'
        ]);

        $admin = factory(User::class)->create([
            'is_admin' => true,
            'login' => 'super_admin',
        ]);

        $this->call(AchievementSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(TeacherSeeder::class);
//        $this->call(ArticleSeeder::class);
//        $this->call(ScheduleSeeder::class);
    }
}
