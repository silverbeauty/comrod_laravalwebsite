<?php

namespace App\Intervention;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class XLarge implements FilterInterface
{
    public function applyFilter(Image $image)
    {
        return $image->resize(720, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
    }
}