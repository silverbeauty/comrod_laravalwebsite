@extends('layouts.master')

@section('title', trans('pages.explainer_video_title'))
@section('description', substr(strip_tags_content(trans('pages.explainer_video_body')), 0, 150) . '...')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-left">{!! nl2br(trans('pages.explainer_video_body')) !!}</div>
        </div>
    </div>
@stop