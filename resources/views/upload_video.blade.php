@extends('layouts.master')

@section('title', trans('app.upload_video'))
@section('description', trans('app.upload_video'))

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
            <div id="uploadContentForm" class="col-md-9 col-sm-12 col-xs-12">
                <h1 class="heading clearfix upload-title-container">
                    <span class="pull-left">{{ trans('video.upload') }}</span>
                    @if (is_rtl())
                        @include('partials.upload_content_menu-right')
                    @else
                        @include('partials.upload_content_menu')                    
                    @endif
                </h1>
                @if (is_rtl())
                    @include('partials.upload_content_form-right')
                @else
                    @include('partials.upload_content_form')
                @endif
            </div>
        </div>
    </div>
@stop