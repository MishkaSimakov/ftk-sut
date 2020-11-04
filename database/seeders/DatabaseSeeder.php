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
             'name' => 'Михаил'
         ]);

         $this->call(NewsSeeder::class);
         $this->call(ClubSeeder::class);
    }
}
