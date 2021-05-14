<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = Http::get('http://ftk-sut.ru/webapi/articles?page=1')->json()['data'];

        foreach ($tags as $tag) {
            Article::factory()->create([
                'title' => $tag['title'],
                'body' => $tag['body'],
            ]);
        }
    }
}
