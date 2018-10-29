@extends('layouts.master')

@section('title', trans('pages.contact_us_title'))
@section('description', substr(strip_tags_content(trans('pages.contact_us_body')), 0, 150) . '...')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-left">{!! nl2br(trans('pages.contact_us_body')) !!}</div>
        </div>
    </div>
@stop