<?php

namespace Database\Seeders;

use App\Enums\ArticleType;
use App\Enums\UserType;
use App\Models\Article;
use App\Models\ArticleTag;
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
            if (!$article['title']) {
                continue;
            }

            $storedArticle = Article::create([
                'id' => $article['id'],
                'title' => $article['title'],
                'body' => str_replace('"../../', '"https://ftk-sut.ru/', $article['body']),
                'author_id' => $this->getUserId($article['user']),
                'type' => ArticleType::Checked(),
                'date' => $article['created_at']
            ]);

            foreach ($article['users'] as $user) {
                $storedArticle->points()->attach(
                    $this->getUserId($user)
                );
            }

            foreach ($article['tags'] as $tag) {
                $storedArticle->tags()->attach(
                    $this->getTagId($tag)
                );
            }

            try {
                $storedArticle->storeImagesFromBody();
            } catch (\Exception $e) {
                var_dump($storedArticle->id, $article['url'], $storedArticle->body);
            }
        }
    }

    protected function getUserId($user): int
    {
        if (!($foundUser = User::where('name', $user['name'])->first())) {
            $foundUser = User::create([
                'id' => $user['id'],
                'name' => $user['name'],
                'is_admin' => $user['is_admin'],
                'email' => $user['email'],
                'register_code' => $user['register_code'],
                'type' => UserType::Pupil()
            ]);
        }

        return $foundUser->id;
    }

    protected function getTagId($tag): int
    {
        if (!($foundTag = ArticleTag::where('name', $tag['name'])->first())) {
            $foundTag = ArticleTag::create([
                'id' => $tag['id'],
                'name' => $tag['name']
            ]);
        }

        return $foundTag->id;
    }
}
