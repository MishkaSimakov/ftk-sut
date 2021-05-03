<?php

namespace App\Images\Filters;

use Intervention\Image\Filters\FilterInterface;
use Intervention\Image\Image;

class OptimizeFilter implements FilterInterface
{
    /**
     * Applies filter effects to given image
     *
     * @param Image $image
     * @return Image
     */
    public function applyFilter(Image $image): Image
    {
        $image->widen(750);

        return $image;
    }
}
