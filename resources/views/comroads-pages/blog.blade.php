@extends('layouts.master')

@section('title', trans('pages.blog_title'))
@section('description', substr(strip_tags_content(trans('pages.blog_body')), 0, 150) . '...')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-left">{!! preg_replace("/(<[a-zA-Z0-9=\"\/\ ]+>)<br\ \/>/", "$1", nl2br(trans('pages.blog_body'))) !!}</div>
        </div>
    </div>
@stop