@extends('layouts.master')

@section('title', $content['title'])
@section('description', $content['title'])

@if (!$is_ajax)
    @section('og')
        <meta property="og:title" content="{{ $content['title'] }}" />
        <meta property="og:description" content="{{ $content['title'] }}" />
        <meta property="og:url" content="{{ $content['url'] }}" />
        <meta property="og:image" content="{{ $content['image_url'] }}" />
    @stop
@endif

@section('body_class', 'Video__Profile')

@if (!$is_ajax)
    @section('external_js')
        @include('underscore.map_results')     
        <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.browser_api_key') }}&callback=mapCallback" async defer></script>        
    @stop
@endif

@section('content')
    <div class="container">
        <div {{ $is_ajax ? 'id=pjaxModalContentContainer' : null }}>
            <div class="Content__Profile__Player">                        
                @if ($content['type'] == 'video')
                    <div
                        class="flow-player functional"
                        data-swf="{{ asset('flowplayer.swf') }}"
                        data-key="$108835620266723"
                    >    
                        <video autoplay preload poster="{{ $content['image_url'] }}">
                            <source type="video/mp4" src="{{ $content['content_url'] }}">                                
                        </video>
                    </div>
                @elseif ($content['type'] == 'stream')
                    <div
                        class="flow-player functional"
                        data-swf="{{ asset('flowplayer.swf') }}"
                        data-key="$108835620266723"
                        data-rtmp="{{ $content['content_url'] }}"
                    >    
                        <video autoplay preload poster="{{ $content['image_url'] }}">                                                            
                        </video>
                    </div>
                @elseif ($content['type'] == 'photo')
                    <div id="photos-carousel" class="carousel slide" data-ride="carousel">
                        @if ($content['refresh_seconds'])
                            <div class="live-feed-counter">
                                {!! trans('app.images_will_refresh_in', ['seconds' => '<span id="refresh-counter">'.$content['refresh_seconds'].'</span>']) !!}
                            </div>
                        @endif
                        <div class="carousel-inner" role="listbox">
                            <div class="item active">
                                <table width="100%" height="500">
                                    <tr>
                                        <td>
                                            <img
                                                src="{{ $content['content_url'] }}"
                                                alt="{{ $content['title'] }}"
                                                class="img-responsive"
                                                @if ($content['refresh_seconds'])
                                                    onload="refreshIt(this, {{ $content['refresh_seconds'] }})"
                                                @endif
                                            >
                                        </td>
                                    </tr>
                                </table>
                            </div>                            
                        </div>
                    </div>
                @elseif ($content['type'] == 'embed')
                    <iframe type="text/html" frameborder="0" width="100%" height="500" src="{{ $content['content_url'] }}"></iframe>
                @endif                      
            </div>
            <div class="row Content__Profile">
                <div class="col-md-9 col-sm-12 col-xs-12 Content">
                    <div>
                        <div class="Content__Profile__Heading">
                            <div class="text-right">
                                <i class="flag-icon flag-icon-{{ $content['country_code'] }}"></i> {{ $content['country_name'] }}         
                            </div>
                            <h1 class="title text-left">{{ $content['title'] }}</h1>
                        </div>
                    </div>
                    @if (! $is_ajax)
                        <div class="Content__Profile__Map Map">
                            <div class="position-relative">
                                <div id="contentProfileMap" style="height:300px;"></div>                                
                                <div class="backdrop"></div>
                                <div class="loader">
                                    <i class="fa fa-spinner fa-pulse"></i> {{ trans('home.loading_map') }}
                                </div>
                            </div>
                        </div><br><br>
                    @endif                    
                </div>
                @include('partials.side_bar')
            </div>            
        </div>
    </div>    
@stop