<?php

namespace Tests\Feature\Rating;

use App\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RatingStoreTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     * @test
     */
    public function test_its_redirect_unauthenticated_users()
    {
        $response = $this->post('/rating');
        $response->assertStatus(302);
    }

    public function test_it_redirects_if_user_is_not_admin()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $this->post('/rating')->assertStatus(403);
    }

    public function test_it_upload_rating_if_all_data_ok()
    {
        $user = factory(User::class)->create([
            'is_admin' => true
        ]);
        $this->actingAs($user);

        $this->post('/rating',[
            'type' => 1,
            'file' => new UploadedFile(base_path('tests/Stubs/') . '/rating.xls', 'rating.xls'),
            'month' => 5
        ])->assertStatus(302);

        $this->assertDatabaseHas('ratings', []);
        $this->assertDatabaseHas('points', []);
    }
}
