<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PhotosController extends Controller
{
    public function show(Request $request)
    {
        return resize_remote_image($request->url, $request->height);
    }
}
