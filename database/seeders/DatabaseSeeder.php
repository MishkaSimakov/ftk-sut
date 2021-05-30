<?php

namespace Database\Seeders;

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
//         User::factory()->admin()->create([
//             'password' => Hash::make('secret'),
//             'type' => UserType::Pupil(),
//             'email' => 'msimakov661@gmail.com',
//             'name' => 'Симаков Михаил'
//         ]);

        $this->call(NewsSeeder::class);
        $this->call(ArticleSeeder::class);

        $this->call(RatingSeeder::class);

//        $this->call(ViewsSeeder::class);
    }
}
