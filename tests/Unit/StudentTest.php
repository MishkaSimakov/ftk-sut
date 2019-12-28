<?php

namespace Tests\Unit;

use App\Student;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StudentTest extends TestCase
{
    /**
     * @test
     */
    public function creates_student()
    {
        $student = factory(Student::class)->create([
            'name' => 'Петров Иван',
            'last_name' => 'Петров',
            'first_name' => 'Иван',
            'user_id' => factory(User::class),
            'admissioned_at' => now(),
            'birthday' => now(),
        ]);

        $this->assertInstanceOf(Student::class, $student);
        $this->assertInstanceOf(User::class, $student->user);
        $this->assertInstanceOf(Student::class, $student->user->student);
    }
}
