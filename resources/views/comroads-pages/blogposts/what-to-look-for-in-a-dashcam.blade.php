@extends('layouts.master')
<link rel="stylesheet" href="/css/blog.css" >

@section('title', trans('pages.what-to-look-for-in-a-dashcam_title'))
@section('description', substr(strip_tags_content(trans('pages.what-to-look-for-in-a-dashcam_body')), 0, 150) . '...')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-left">{!! preg_replace("/(<[a-zA-Z0-9=\"\/\ ]+>)<br\ \/>/", "$1", nl2br(trans('pages.what-to-look-for-in-a-dashcam_body'))) !!}</div>
        </div>
    </div>
@stop