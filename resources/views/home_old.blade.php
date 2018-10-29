@extends('layouts.master')

@section('external_js')
    @include('partials.homepage_map_script')
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.browser_api_key') }}&callback=initMap" async defer></script>
@endsection

@section('underscore')
    @include('underscore.content_thumbnail')
    @include('underscore.content_carousel_block')
@stop

@section('title', 'Comroads')
@section('description', 'Comroads')

@section('content')
    <div class="jumbotron">
        <div class="container">
            <nav class="nav Switch">
                <ul class="nav navbar-nav pull-right">
                    <li>
                        <label class="radio-inline">
                            <input type="radio" name="content_type" value="photo" class="icheck">
                            Photo
                        </label>
                    </li>
                    <li>
                        <label class="radio-inline">
                            <input type="radio" name="content_type" value="video" class="icheck" checked="checked">
                            Video
                        </label>
                    </li>
                </ul>
            </nav>
            @if (count($popular))
                <h2 class="Content__Heading text-center"><span>Most popular videos</span></h2>                           
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
                                            @foreach ($chunk_popular_video as $popular_video)
                                                <div class="col-md-4">
                                                    <div>
                                                        <a href="{{ $popular_video->url }}" class="Thumbnail">
                                                            <div class="Thumbnail__Header">
                                                                <div>
                                                                    <span>{{ $popular_video->title }}</span>
                                                                    <i class="flag-icon flag-icon-{{ strtolower($popular_video->country_code) }}"></i>
                                                                </div>
                                                                <div class="backdrop"></div>
                                                            </div>
                                                            <img class="img-responsive" src="{{ $popular_video->thumbnail_url }}">
                                                            <div class="nav Thumbnail__Footer">
                                                                <ul class="nav navbar-nav">
                                                                    <li><i class="fa fa-eye"></i> {{ $popular_video->total_views }}</li>
                                                                    <li><i class="fa fa-comments"></i> {{ $popular_video->total_comments }}</li>
                                                                </ul>
                                                                <ul class="nav navbar-nav navbar-right">
                                                                    <li><i class="fa fa-thumbs-up"></i> {{ $popular_video->total_rating }}</li>
                                                                    {{-- <li><i class="fa fa-thumbs-down"></i> {{ $popular_video->total_dislikes }}</li> --}}
                                                                </ul>
                                                                <div class="backdrop"></div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach                                                                       
                            </div>                        
                        </div>
                    </div>
                    <a class="left carousel-control" href="#carousel-most-popular-videos" role="button" data-slide="prev">
                        <span class="fa fa-chevron-circle-left fa-2x" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#carousel-most-popular-videos" role="button" data-slide="next">
                        <span class="fa fa-chevron-circle-right fa-2x" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            @endif
        </div>
    </div>
    <div class="container">
        <div class="row">{{ isset($settings->sort_type) ? $settings->sort_type : '' }}
            <div class="col-md-9 Content">
                <p class="checkbox">
                    <label>
                        <input type="checkbox" name="hide_watched" {{ $hide_watched && $signed_in ? 'checked' : '' }}>
                        Don't show already watched
                    </label>
                </p>                    
                <h2 class="Content__Heading">
                    <span>
                        <span class="dropdown no-padding">
                            Sort by: 
                            <a
                                data-toggle="dropdown"
                                class="text-default"
                            >
                                <b
                                    id="sorting-label"
                                    data-key="{{ $filter_menu['sorting'][$sort_key]['alt_key'] }}"
                                >{{ $filter_menu['sorting'][$sort_key]['label'] }}</b></a> 
                                <a data-toggle="dropdown"><i class="fa fa-chevron-circle-down text-primary"></i></a>
                            <ul class="dropdown-menu pull-right">
                                @foreach ($filter_menu['sorting'] as $key => $sort)                                        
                                    <li class="{{ $key == $sort_key ? 'hidden' : '' }}">
                                        <a
                                            class="content-sorting"
                                            data-sorting-type="{{ $sort['alt_key'] }}"
                                            data-target-label="#sorting-label"
                                            data-label="{{ $sort['label'] }}"
                                            data-key="{{ $key }}"
                                        >{{ $sort['label'] }}</a>
                                    </li>
                                @endforeach                             
                            </ul>
                        </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span class="dropdown no-padding">
                            Show from: 
                            <a
                                data-toggle="dropdown"
                                class="text-default"
                            >
                                <b
                                    id="show-from-filter-label"
                                    data-key="{{ $show_from_filter_key }}"
                                >{{ $filter_menu['filters'][$show_from_filter_key]['alt_label'] }}</b></a> 
                                <a data-toggle="dropdown">
                                    <i class="fa fa-chevron-circle-down text-primary"></i>
                                </a>
                            <ul class="dropdown-menu pull-right">
                                @foreach ($filter_menu['filters'] as $key => $filter)                                        
                                    <li class="{{ $key == $show_from_filter_key ? 'hidden' : '' }}">
                                        <a
                                            href="{{ $filter['url'] }}"
                                            class="show-from-filter"
                                            data-target-label="#show-from-filter-label"
                                            data-label="{{ $filter['alt_label'] }}"
                                            data-filter-type="{{ $key }}"
                                            data-key="{{ $key }}"
                                        >{{ $filter['label'] }}</a>
                                    </li>                                        
                                @endforeach                             
                            </ul>
                        </span>
                    </span>                        
                </h2>
                <div id="main-content-carousel" class="Main__Content__Carousel position-relative">
                    <div class="loader-backdrop">
                        <div class="backdrop"></div>
                        <div class="indicator">
                            <span><i class="fa fa-spinner fa-pulse"></i> Loading...</span>                                
                        </div>
                    </div>
                    <input type="hidden" name="total_main_content_carousel_items" value="">
                    <a
                        id="slide-left-control"
                        class="left carousel-control hidden"
                        role="button"
                        data-slide="left"
                        data-current-item-id="0"
                        style="display:none;"
                    >
                        <span class="fa fa-chevron-circle-left fa-2x" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a
                        id="slide-right-control"
                        class="right carousel-control hidden"
                        role="button"
                        data-slide="right"
                        data-current-item-id="0"                            
                        style="display:none;"                            
                    >
                        <span class="fa fa-chevron-circle-right fa-2x" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                    <div id="carousel-item-0" class="Listing gutter-5 sortable-content">                            
                        <?php $key = 0; ?>
                        @foreach ($main_contents->chunk(3) as $chunked_content)
                            <div class="row">
                                @foreach ($chunked_content as $content)
                                    <div class="col-md-4">
                                        <div id="content-thumbnail-{{ $key }}" data-id="{{ $content->id }}" class="content-thumbnail">
                                            <div class="original">
                                                <a href="{{ $content->url }}" id="thumbnail-{{ $content->id }}" class="Thumbnail hoverable" data-marker-id="{{ $content->id }}">
                                                    <div class="Thumbnail__Header">
                                                        <div>
                                                            <span>{{ $content->title }}</span>
                                                            <i class="flag-icon flag-icon-{{ strtolower($content->country_code) }}"></i>
                                                        </div>
                                                        <div class="backdrop"></div>
                                                    </div>
                                                    <img class="img-responsive" src="{{ $content->thumbnail_url }}">
                                                    <div class="nav Thumbnail__Footer">
                                                        <ul class="nav navbar-nav">
                                                            <li><i class="fa fa-eye"></i> {{ $content->total_views }}</li>
                                                            <li><i class="fa fa-comments"></i> {{ $content->total_comments }}</li>
                                                        </ul>
                                                        <ul class="nav navbar-nav navbar-right">
                                                            <li><i class="fa fa-thumbs-up"></i> {{ $content->total_rating }}</li>
                                                            {{-- <li><i class="fa fa-thumbs-down"></i> {{ $content->total_dislikes }}</li> --}}
                                                        </ul>
                                                        <div class="backdrop"></div>
                                                    </div>
                                                </a>
                                            </div>                                            
                                        </div>
                                    </div>
                                    <?php $key++; ?>
                                @endforeach
                            </div>                            
                        @endforeach                            
                    </div>
                </div>                
                <div class="Map">
                    <h2 class="Content__Heading">
                        <span>See videos near your location</span>                       
                    </h2>
                    <div id="map"></div>
                    <h2 class="Content__Heading text-right bottom">
                        <span>
                            <a class="text-default show-all-categories-on-map">Show all categories on map</a>
                            <i class="fa fa-chevron-circle-down fa-lg text-primary"></i>
                        </span>                                              
                    </h2>
                </div>
            </div>
            @include('partials.side_bar')
        </div>
    </div>
@endsection