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
        $this->call(AchievementSeeder::class);

        $admin = factory(User::class)->create([
            'is_admin' => true,
            'email' => 'msimakov661@gmail.com',
        ]);

        $admin = factory(User::class)->create([
            'is_admin' => true,
            'email' => 'admin@site.com',
        ]);

        $this->call(CategorySeeder::class);
        $this->call(TeacherSeeder::class);
        $this->call(ArticleSeeder::class);
        $this->call(ScheduleSeeder::class);
    }
}
