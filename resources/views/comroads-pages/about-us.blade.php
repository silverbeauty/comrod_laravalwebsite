@extends('layouts.master')

@section('title', trans('pages.about_us_title'))
<link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
<link href="/css/pages_ltr.css" rel="stylesheet">
@section('description', substr(strip_tags_content(trans('pages.about_us_body')), 0, 150) . '...')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-left">{!! nl2br(trans('pages.about_us_body', ['uploading-rules-url' => route('uploading-rules')])) !!}</div>
        </div>
    </div>
@stop