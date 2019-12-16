<?php

use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i <= 10; $i++) {
            factory(\App\Article::class)->create(['is_published' => false]);
            factory(\App\Article::class)->create(['is_published' => true]);
        }
    }
}
