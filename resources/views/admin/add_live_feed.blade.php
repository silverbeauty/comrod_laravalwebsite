@extends('layouts.admin')

@section('title', 'Add Live Feed')
@section('description', 'Add Live Feed')

@section('external_js')
    <script class="reloadable" src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.browser_api_key') }}&libraries=places&callback=mapCallback" async defer></script>    
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Add Live Feed</h3>
            @include('partials.live_feed_form')
        </div>
    </div>
@stop