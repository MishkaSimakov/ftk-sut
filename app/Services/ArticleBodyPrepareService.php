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
        $body = $article->body;

        preg_match_all('/<img.*?src=[\'"](.*?)[\'"].*?>/i', $body, $matches);

        $images = $matches[1];

        $domain = Arr::last(
            explode('://', config('app.url'))
        );

        foreach ($images as $image) {
            if (preg_match("/http[s]?:\/\/{$domain}\/storage\/temp\//", $image)) {
                // изображение сохранено на сайте ФТК СЮТ, но во временной папке
                $path = $this->storeTemporaryArticleImage($image, $article);
            } else if (!preg_match("/http[s]?:\/\/{$domain}/", $image)) {
                // изображение сохранено не на сайте ФТК СЮТ
                $path = $this->storeExternalArticleImage($image, $article);
            } else {
                // изображение уже сохранено на сайте ФТК СЮТ в папке соответствующей статьи
                continue;
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
        return (new ImageUploadService())->setMaxWidth(1280)->setDisk('public')
            ->store($url, $this->getImageStoreDirectoryPath($article));
    }

    protected function getImageStoreDirectoryPath(Article $article): string
    {
        return "articles/{$article->id}/";
    }
}
