@extends('layouts.admin')

@section('title', 'Edit Live Feed')
@section('description', 'Edit Live Feed')

@section('external_js')
    <script class="reloadable" src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.browser_api_key') }}&libraries=places&callback=mapCallback" async defer></script>    
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header clearfix">
                <div class="pull-left">{{ $feed->title }}</div>
                <div class="pull-right">
                    <a
                        class="btn btn-danger btn-sm confirm-action"
                        data-confirm-title="Are you sure?"
                        data-confirm-body="You are about to delete this content"
                        data-confirm-button-text="Yes, delete it!"
                        data-ajax-data='{"id": {{ $feed->id }}}'
                        data-url="{{ route('admin::postDeleteLiveFeed') }}"
                        data-reload="true"
                    >Delete</a>                        
                    
                    <a href="{{ $feed->url }}" target="_blank" class="btn btn-primary btn-sm">Preview</a>
                </div>
            </h3>
            @include('partials.live_feed_form')
        </div>
    </div>
@stop