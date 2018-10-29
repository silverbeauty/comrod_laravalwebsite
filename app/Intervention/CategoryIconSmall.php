<?php

namespace App\Intervention;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class CategoryIconSmall implements FilterInterface
{
    public function applyFilter(Image $image)
    {
        return $image->resize(30, null, function ($constraint) {
            $constraint->aspectRatio();
        });
    }
}