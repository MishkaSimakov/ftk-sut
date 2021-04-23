<?php

namespace App\Services;

use App\Models\Article;
use Storage;

class ArticleBodyPrepareService
{
    public function getPreparedBody(string $body, Article $article): string
    {
        preg_match_all('/<img.*?src=[\'"](.*?)[\'"].*?>/i', $body, $matches);
        $images = $matches[1];

        foreach ($images as $image) {
            if (preg_match('/^data:image\/(\w+);base64,/', $image)) {
                $body = str_replace($image, asset(
                    'storage/' . save_base64($image, "articles/{$article->id}/", 'public')
                ), $body);
            }
        }

        return $body;
    }

    public function deleteSavedImages(Article $article)
    {
        $images = Storage::disk('public')->allFiles("articles/{$article->id}");

        foreach ($images as $image) {
            Storage::disk('public')->delete($image);
        }
    }
}
