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
            'email' => 'msimakov661@gmail.com',
        ]);

        $this->call(CategorySeeder::class);
    }
}
