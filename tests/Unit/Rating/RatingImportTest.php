<?php

namespace Tests\Unit\Rating;

use App\Imports\RatingImport;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

class RatingImportTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_it_create_students()
    {
        $this->seed();

        $this->importRating();

        $this->assertCount(121, User::all());
    }

    public function importRating()
    {
        $rating = storage_path('app/rating_one_list.xls');

        Excel::import(new RatingImport(Carbon::parse('2020-10'), true), $rating);
    }
}
