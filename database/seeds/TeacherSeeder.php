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
                'job_title' => 'Преподователь по робототехнике',
            ],
            [
                'last_name' => 'Бильченко',
                'first_name' => 'Константин',
                'middle_name' => 'Дмитриевич',
                'job_title' => 'Преподователь по робототехнике',
            ],
        ]);

        $teachers->each(function ($teacher) {
            factory(Teacher::class)->create($teacher);
        });
    }
}
