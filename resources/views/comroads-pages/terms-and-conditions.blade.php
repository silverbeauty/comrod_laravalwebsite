@extends('layouts.master')

@section('title', trans('pages.terms_and_conditions_title'))
@section('description', substr(strip_tags_content(trans('pages.terms_and_conditions_body')), 0, 150) . '...')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-left">{!! nl2br(trans('pages.terms_and_conditions_body')) !!}</div>
        </div>
    </div>
@stop