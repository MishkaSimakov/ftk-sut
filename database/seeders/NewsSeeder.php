<?php

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class NewsSeeder extends Seeder
{
    public function run()
    {
        $news = Http::get('http://ftksut.ru/api/imports/news')->json();

        foreach ($news as $n) {
            News::create([
                'id' => $n['id'],
                'title' => $n['title'],
                'body' => $n['body'],
                'date' => $n['created_at']
            ]);
        }
    }
}
