<?php

namespace Database\Seeders;

use CyrildeWit\EloquentViewable\View;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class ViewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $views = Http::get('http://ftk-sut.ru/api/imports/views')->json();

        foreach ($views as $view) {
            \DB::table('views')->insert($view);
        }
    }
}
