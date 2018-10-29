<?php

namespace App\Intervention;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class Carousel implements FilterInterface
{
    public function applyFilter(Image $image)
    {
        return $image->resize(null, 500, function ($constraint) {
            $constraint->aspectRatio();
        });
    }
}