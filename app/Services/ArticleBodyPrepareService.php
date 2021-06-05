<?php

namespace App\Services;

use App\Models\Article;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Storage;

class ArticleBodyPrepareService
{
    public function getPreparedBody(Article $article): string
    {
        $this->deleteSavedImages($article);

        $body = $article->body;

        preg_match_all('/<img.*?src=[\'"](.*?)[\'"].*?>/i', $body, $matches);

        $images = $matches[1];

        $domain = Arr::last(
            explode('://', config('app.url'))
        );

        foreach ($images as $image) {
            if (preg_match("/http[s]?:\/\/{$domain}\//", $image)) {
                $body = str_replace(
                    $image,
                    Storage::disk('public')->path($this->storeTemporaryArticleImage($image, $article)),
                    $body
                );
            }
        }

        return $body;
    }

    public function deleteSavedImages(Article $article)
    {
        $images = Storage::disk('public')->allFiles($this->getImageStoreDirectoryPath($article));

        foreach ($images as $image) {
            Storage::disk('public')->delete($image);
        }
    }

    protected function storeTemporaryArticleImage(string $path, Article $article): string
    {
        Storage::disk('public')->move(
            Str::replaceFirst(config('filesystems.disks.public.url'), '', $path),
            $newPath = $this->getImageStoreDirectoryPath($article) . Arr::last(explode('/', $path))
        );

        return $newPath;
    }

    protected function storeArticleImage(string $base64, Article $article): string
    {
        $extension = explode('/', explode(':', substr($base64, 0, strpos($base64, ';')))[1])[1];

        $replace = substr($base64, 0, strpos($base64, ',') + 1);
        $base64 = str_replace($replace, '', $base64);
        $base64 = str_replace(' ', '+', $base64);

        $imageName = Str::random(10) . '.' . $extension;

        Storage::disk('public')->put(
            $path = $this->getImageStoreDirectoryPath($article) . $imageName,
            base64_decode($base64)
        );

        return $path;
    }

    protected function getImageStoreDirectoryPath(Article $article): string
    {
        return "articles/{$article->id}/";
    }
}
