@extends('layouts.master')

@section('title', trans('app.upload_photo'))
@section('description', trans('app.upload_photo'))

@section('underscore')    
    @include('underscore/license_plate_form')
@stop

@section('modals')
    @include('modals/upload_content_google_map')
@stop

@section('external_js')
    <script class="reloadable" src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.browser_api_key') }}&libraries=places&callback=mapCallback" async defer></script>    
@stop

@section('content')
    <div class="container">
        <div class="row Upload__Content">
            <div id="uploadContentForm" class="col-md-9 col-sm-12 col-xs-12">
                <h1 class="heading clearfix upload-title-container">
                    <span>{{ trans('video.upload') }}</span>
                    @include('partials.upload_content_menu')                    
                </h1>                
                @include('partials.upload_content_form')
            </div>
        </div>
    </div>
@stop