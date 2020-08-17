<?php

namespace Tests\Unit\Rating;

use App\Imports\TravelRatingsImport;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Tests\TestCase;

class TravelRatingParseTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_it_parse_travel_rating()
    {
        factory(User::class)->create([
            'name' => 'Симаков Михаил'
        ]);

        $response = $this->post(route('travels.import'), [
            'file' => new UploadedFile(base_path('tests/Stubs/') . '/travel_rating.xls', 'travel_rating.xls')
        ]);

        $response->assertStatus(200);
    }
}
