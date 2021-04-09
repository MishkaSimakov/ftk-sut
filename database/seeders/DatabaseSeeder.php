<?php

namespace Database\Seeders;
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
         $this->call(ArticleTagSeeder::class);
         $this->call(ClubSeeder::class);
         $this->call(RatingPointCategorySeeder::class);
         $this->call(ArticleSeeder::class);



//         $this->call(RatingPointSeeder::class);
    }
}
