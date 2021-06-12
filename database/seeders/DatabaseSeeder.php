<?php

namespace Database\Seeders;

use App\Enums\UserType;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         User::factory()->admin()->create([
             'password' => Hash::make('secret'),
             'type' => UserType::Pupil(),
             'email' => 'msimakov661@gmail.com',
             'name' => 'Симаков Михаил'
         ]);

        $this->call(UserSeeder::class);

        $this->call(NewsSeeder::class);
        $this->call(ArticleSeeder::class);
        $this->call(EventSeeder::class);
        $this->call(RatingSeeder::class);
    }
}
