<?php

use App\Achievement;
use App\Point;
use App\User;
use Illuminate\Database\Seeder;
use App\Article;

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
            'password' => Hash::make('123456'),
            'email' => 'msimakov661@gmail.com'
        ]);
    }
}
