<?php

namespace App\Services;

use App\Models\Article;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Storage;

class ArticleBodyPrepareService
{
    public function getPreparedBody(Article $article): string
    {
        $this->deleteSavedArticleImages($article);

        $body = $article->body;

        preg_match_all('/<img.*?src=[\'"](.*?)[\'"].*?>/i', $body, $matches);

        $images = $matches[1];

        $domain = Arr::last(
            explode('://', config('app.url'))
        );

        foreach ($images as $image) {
            if (preg_match("/http[s]?:\/\/{$domain}\/storage\/temp\//", $image)) {
                $path = $this->storeTemporaryArticleImage($image, $article);
            } else {
                $path = $this->storeExternalArticleImage($image, $article);
            }

            $body = str_replace(
                $image, Storage::disk('public')->url($path), $body
            );
        }

        return $body;
    }

    public function deleteSavedArticleImages(Article $article)
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

    protected function storeExternalArticleImage(string $url, Article $article): string
    {
        $image = Image::make($url);

        $name = Str::random(40);
        $extension = Arr::last(explode('/', $image->mime()));
        $path = "/articles/{$article->id}/{$name}.{$extension}";

        if ($image->width() > 1280) {
            $image = $image->widen(1280);
        }

        Storage::disk('public')->put($path, $image->encode());

        return $path;
    }

    protected function getImageStoreDirectoryPath(Article $article): string
    {
        return "articles/{$article->id}/";
    }
}
