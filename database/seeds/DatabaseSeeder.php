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
            'password' => \Illuminate\Support\Facades\Hash::make('123456'),
            'email' => 'msimakov661@gmail.com'
        ]);

<<<<<<< HEAD
        $this->call(CategorySeeder::class);
=======
        factory(User::class, 1)->create([
            'email' => 'admin@site.com',
            'is_admin' => true,
        ]);


            $this->call(CategorySeeder::class);
>>>>>>> e929a08b9aa981e5c0d3ffe064d3dc78464f974b
    }
}
