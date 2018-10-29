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
@section('body_class', 'home')

@section('content')
    <div class="jumbotron">
        <div class="container">

        <div class="row">
            <div class="col-md-9">
                <nav class="nav Switch header-radio">
                    <ul class="nav navbar-nav pull-right">
                        <li>
                            <label class="radio-inline">
                                <input
                                    type="radio"
                                    name="content_type"
                                    value="photo"
                                    class="icheck redirect"
                                    data-href="{{ route('photos') }}"
                                    {{ $route_name == 'photos' ? 'checked' : '' }}
                                >
                                {{ trans('home.photo') }}
                            </label>
                        </li>
                        <li>
                            <label class="radio-inline">
                                <input
                                    type="radio"
                                    name="content_type"
                                    value="video"
                                    class="icheck redirect"
                                    data-href="{{ route('videos') }}"
                                    {{ $route_name == 'videos' ? 'checked' : '' }}
                                >
                                {{ trans('home.video') }}
                            </label>
                        </li>
                    </ul>
                </nav>
            @if (count($popular))
                <h2 class="Content__Heading text-center"><span>{{ trans('home.trending-videos') }}</span></h2>                           
                <div id="carousel-most-popular-videos" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        @foreach ($popular->chunk(3) as $key => $popular_video)
                            <li data-target="#carousel-most-popular-videos" data-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active' : '' }}"></li>
                        @endforeach                 
                    </ol>
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="carousel-inner" role="listbox">
                                @foreach ($popular->chunk(3) as $key => $chunk_popular_video)
                                    <div class="item Listing {{ $key == 0 ? 'active' : '' }} gutter-5">
                                        <div class="row">
                                            <!-- slider-each-cont -->
                                            @foreach ($chunk_popular_video as $content)
                                                @include('partials.content_thumbnail', ['content' => $content->content])
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach                                                                       
                            </div>                        
                        </div>
                    </div>
                    <a class="left carousel-control" href="#carousel-most-popular-videos" role="button" data-slide="prev">
                        <span class="fa fa-chevron-circle-left fa-2x" aria-hidden="true"></span>
                        <span class="sr-only">{{ trans('home.previous') }}</span>
                    </a>
                    <a class="right carousel-control" href="#carousel-most-popular-videos" role="button" data-slide="next">
                        <span class="fa fa-chevron-circle-right fa-2x" aria-hidden="true"></span>
                        <span class="sr-only">{{ trans('home.next') }}</span>
                    </a>
                </div>
            @endif
            </div>
            <div class="col-md-3 adv-cont">
                <div class="Sidebar__Ad header-ad overflow-hidden">
                    @if ($banner_ad)
                        {!! $banner_ad->code !!}
                    @else
                        {{ trans('home.advertise-here') }}
                    @endif
                </div>
            </div>
        </div>
        </div>
    </div>

    <div class="container">
        <div class="row">{{ isset($settings->sort_type) ? $settings->sort_type : '' }}
            @if (agent()->isDesktop())
                @include('partials.home_left')
                @include('partials.home_right')
            @else
                @include('partials.home_right')
                @include('partials.home_left')                
            @endif
        </div>        
    </div>
@endsection