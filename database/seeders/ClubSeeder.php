<?php

namespace Database\Seeders;

use App\Models\Club;
use Illuminate\Database\Seeder;

class ClubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clubs = [
            [
                'name' => 'Робототехника',
                'description' => '',
            ],
            [
                'name' => 'Электроника',
                'description' => '',
            ],
            [
                'name' => 'Мастерская творчества',
                'description' => '',
            ],
            [
                'name' => 'Интеллект',
                'description' => '',
            ],
            [
                'name' => 'Архитектура и дизайн',
                'description' => '',
            ],
        ];

        foreach ($clubs as $club) {
            Club::factory()->create($club);
        }
    }
}
