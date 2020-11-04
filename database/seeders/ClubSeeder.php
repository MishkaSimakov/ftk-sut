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
                'color' => 'red'
            ],
            [
                'name' => 'Электроника',
                'description' => '',
                'color' => 'yellow'
            ],
            [
                'name' => 'Мастерская творчества',
                'description' => '',
                'color' => 'blue'
            ],
            [
                'name' => 'Интеллект',
                'description' => '',
                'color' => 'pink'
            ],
            [
                'name' => 'Архитектура и дизайн',
                'description' => '',
                'color' => 'purple'
            ],
        ];

        foreach ($clubs as $club) {
            Club::factory()->create($club);
        }
    }
}
