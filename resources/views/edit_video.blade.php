@extends('layouts.master')

@section('title', trans('video.edit_video'))
@section('description', trans('video.edit_video'))

@section('underscore')
    @include('underscore/video_player')
    @include('underscore/license_plate_form')
@stop

@section('external_js')
    <script class="reloadable" src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.browser_api_key') }}&libraries=places&callback=mapCallback" async defer></script>    
@stop

@section('content')
    <div class="container">
        <div class="row Upload__Content">
            <div class="col-md-9">
                <h1 class="heading clearfix">
                    <span class="pull-left">{{ trans('video.edit_video') }}</span>
                    <a
                        class="btn btn-danger btn-sm pull-right confirm-action"
                        data-confirm-title="{{ trans('message.are_you_sure') }}"
                        data-confirm-body="{{ trans('video.delete_video_confirmation_message') }}"
                        data-confirm-button-text="{{ trans('message.yes_delete_it') }}"
                        data-ajax-data="{{ json_encode(['id' => $content->id]) }}"
                        data-url="{{ $content->delete_url }}"
                    >{{ trans('video.delete_video') }}</a>
                </h1>
                @include('partials.edit_content_form')
            </div>
        </div>
    </div>
@stop