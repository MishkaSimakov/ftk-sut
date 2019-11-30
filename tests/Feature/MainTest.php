<?php

namespace Tests\Feature;

use App\Teacher;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MainTest extends TestCase
{
    public function testBasicTest()
    {
        $teachers = factory(Teacher::class, 5)->create();

        $response = $this->get('/');

        $teachers->each(function ($teacher) use ($response) {
            $response->assertSee($teacher->full_name);
            $response->assertSee($teacher->job_title);
            $response->assertSee($teacher->avatar);
        });
    }
}
