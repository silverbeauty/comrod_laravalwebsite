@extends('layouts.master')

@section('title', trans('pages.uploading_rules_title'))
@section('description', substr(strip_tags_content(trans('pages.uploading_rules_body')), 0, 150) . '...')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-left">{!! nl2br(trans('pages.uploading_rules_body')) !!}</div>
        </div>
    </div>
@stop