<?php

namespace App\Http\Controllers\Api;

use App\Article;
use App\Schedule;
use App\Teacher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\Models\Media;

class ImageController extends Controller
{
    public function uploadArticleImage(Article $article, Request $request)
    {
        foreach ($request->allFiles() as $photo) {
            /** @var UploadedFile $photo */

            $name = Str::slug(str_replace("." . $photo->getClientOriginalExtension(), "", $photo->getClientOriginalName()));
            $filename = $name . '.' . $photo->getClientOriginalExtension();

            $article->addMedia($photo->path())
                ->usingFileName($filename)
                ->usingName($name)
                ->toMediaCollection();
        }
    }

    public function deleteArticleImage(Article $article, Request $request)
    {
        $media = $article->getMedia()->where('file_name', $request->name)->first();

        $article->deleteMedia($media);
    }


    public function uploadScheduleImage(Schedule $schedule, Request $request)
    {
        foreach ($request->allFiles() as $photo) {
            /** @var UploadedFile $photo */

            $name = Str::slug(str_replace("." . $photo->getClientOriginalExtension(), "", $photo->getClientOriginalName()));
            $filename = $name . '.' . $photo->getClientOriginalExtension();

            $schedule->addMedia($photo->path())
                ->usingFileName($filename)
                ->usingName($name)
                ->toMediaCollection();
        }
    }

    public function deleteScheduleImage(Schedule $schedule, Request $request)
    {
        $media = $schedule->getMedia()->where('file_name', $request->name)->first();

        $schedule->deleteMedia($media);
    }

    public function uploadTeacherImage(Teacher $teacher, Request $request)
    {
        foreach ($request->allFiles() as $photo) {
            /** @var UploadedFile $photo */

            $name = Str::slug(str_replace("." . $photo->getClientOriginalExtension(), "", $photo->getClientOriginalName()));
            $filename = $name . '.' . $photo->getClientOriginalExtension();

            $teacher->addMedia($photo->path())
                ->usingFileName($filename)
                ->usingName($name)
                ->toMediaCollection();
        }
    }

    public function deleteTeacherImage(Teacher $teacher, Request $request)
    {
        $media = $teacher->getMedia()->where('file_name', $request->name)->first();

        $teacher->deleteMedia($media);
    }
}
