@extends('layouts.master')

@section('external_js')
    @include('underscore.map_results')
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.browser_api_key') }}&callback=mapCallback&libraries=places" async defer></script>
@endsection

@section('title', 'Comroads')
@section('description', 'Comroads')
@section('body_class', 'live-feeds')

@section('content')
    <div class="container-fluid">
        <div class="row">            
            @if (agent()->isDesktop())
                @include('partials.live_feeds_left')
                @include('partials.live_feeds_right')
            @else
                @include('partials.live_feeds_right')
                @include('partials.live_feeds_left')                               
            @endif
        </div>        
    </div>
@endsection