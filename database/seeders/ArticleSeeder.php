<?php

namespace Database\Seeders;

use App\Enums\ArticleType;
use App\Enums\UserType;
use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

/**
 * Загружает статьи со старой версии сайта на новую.
 */
class ArticleSeeder extends Seeder
{
    public function run()
    {
        $articles = Http::get('http://ftk-sut.ru/api/imports/articles')->json();

        foreach ($articles as $article) {
            $storedArticle = Article::create([
                'title' => $article['title'],
                'body' => $article['body'],
                'author_id' => $this->getUserId($article['user']),
                'type' => ArticleType::Checked(),
                'date' => $article['created_at']
            ]);

            foreach ($article['users'] as $user) {
                $storedArticle->points()->attach(
                    $this->getUserId($user)
                );
            }
        }
    }

    protected function getUserId($user): int
    {
        return User::firstOrCreate([
            'name' => $user['name'],
            'is_admin' => $user['is_admin'],
            'email' => $user['email'],
            'register_code' => $user['register_code'],
            'type' => UserType::Pupil()
        ])->id;
    }
}
