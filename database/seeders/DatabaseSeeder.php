<?php

namespace Database\Seeders;

use App\Models\Article;
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
         \App\Models\User::factory()->admin()->create([
             'password' => Hash::make('secret'),
             'email' => 'msimakov661@gmail.com',
             'name' => 'Симаков Михаил'
         ]);

//         $this->call(UserSeeder::class);

         $this->call(NewsSeeder::class);
         $this->call(ClubSeeder::class);
         $this->call(RatingPointCategorySeeder::class);

         Article::factory(10)->create();

//         $this->call(RatingPointSeeder::class);
    }
}
