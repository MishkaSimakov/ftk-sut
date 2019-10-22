<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    public function test_it_stores_registration_code_wher_creating()
    {
        $user = factory(User::class)->create([
            'register_code' => null
        ]);

        $this->assertNotNull($user->register_code);

        $user = factory(User::class)->create([
            'register_code' => $value = 'asdf'
        ]);

        $this->assertEquals($value, $user->register_code);
    }
}
