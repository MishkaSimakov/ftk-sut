<?php

namespace Tests\Feature;

use App\Http\Controllers\TeacherController;
use App\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewMainPageTest extends TestCase
{
    /** @test */
    public function user_can_view_main_page()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /** @test */
    public function user_can_view_teacher_list()
    {
        $this->seed(\TeacherSeeder::class);

        $response = $this->get('/');

        foreach (Teacher::all() as $teacher) {
            $response->assertSee($teacher->fullName);
            $response->assertSee($teacher->job);
        }
    }
}
