@extends('layouts.master')

@section('external_js')
    @include('underscore.map_results')
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.browser_api_key') }}&callback=mapCallback" async defer></script>
@endsection

@section('underscore')       
@stop

@section('modals')
    @include('modals.home_page_categories')    
@stop

@section('title', 'Comroads')
@section('description', 'Comroads')
@section('body_class', 'home v2')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @if (agent()->isDesktop())
                @include('partials.home_v2_left')
                @include('partials.home_v2_right')
            @else
                @include('partials.home_v2_right')
                @include('partials.home_v2_left')                
            @endif
        </div>        
    </div>
@endsection