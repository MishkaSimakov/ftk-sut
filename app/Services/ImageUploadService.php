<?php


namespace App\Services;


use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ImageUploadService
{
    protected int $max_width;
    protected string $disk;

    public function setMaxWidth(int $width): self
    {
        $this->max_width = $width;

        return $this;
    }

    public function setDisk(string $disk): self
    {
        $this->disk = $disk;

        return $this;
    }

    public function store($file, string $directory)
    {
        $image = Image::make($file);

        $name = Str::random(40);
        $extension = Arr::last(explode('/', $image->mime()));

        $path = "{$directory}/{$name}.";

        if ($extension === 'gif') {
            $path .= 'gif';

            Storage::disk($this->disk)->put($path, file_get_contents($file));
        } else {
            $path .= 'png';

            if (isset($this->max_width) and $image->width() > $this->max_width) {
                $image = $image->widen($this->max_width);
            }

            if (!Storage::disk($this->disk)->put($path, $image->encode('png'))) {
                return false;
            }
        }

        return $path;
    }
}
