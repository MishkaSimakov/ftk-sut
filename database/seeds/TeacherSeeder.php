<?php

use App\Teacher;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teachers = collect([
            [
                'last_name' => 'Бильченко',
                'first_name' => 'Александр',
                'middle_name' => 'Константинович',
                'club_id' => 1,
            ],
            [
                'last_name' => 'Бильченко',
                'first_name' => 'Константин',
                'middle_name' => 'Дмитриевич',
                'club_id' => 1,
            ],
            [
                'last_name' => 'Маркин',
                'first_name' => 'Игорь',
                'middle_name' => 'Вячеславович',
                'club_id' => 3,
            ]
        ]);

        $teachers->each(function ($teacher) {
            factory(Teacher::class)->create($teacher);
        });
    }
}
