<?php

namespace Database\Seeders;

use App\Models\ArticleTag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class ArticleTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = Http::get('http://ftk-sut.ru/webapi/articles/tags')->json();

        foreach ($tags as $tag) {
            ArticleTag::factory()->create([
                'name' => $tag['name'],
            ]);
        }
    }
}
