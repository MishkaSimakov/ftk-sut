<?php

namespace Database\Seeders;

use App\Models\User;
use Arr;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = Http::get('http://ftk-sut.ru/api/imports/users')->json();

        foreach ($users as $user) {
            User::create(
                Arr::only($user, [
                    'id',
                    'is_admin',
                    'name',
                    'email',
                    'register_code'
                ])
            );
        }
    }
}
