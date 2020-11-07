<?php

namespace Tests\Unit\Rating;

use App\Imports\RatingImport;
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

        $count = 0;
        DB::listen(function ($query) use (&$count) {
            $count++;
        });

        $this->importRating();

        dd($count);
    }

    public function importRating()
    {
        $rating = storage_path('app/rating_one_list.xls');

        Excel::import(new RatingImport, $rating);
    }
}
