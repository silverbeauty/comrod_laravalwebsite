@extends('layouts.master')

@section('title', $content->title)
@section('description', $content->description)

@section('body_class', 'Video__Profile')

<?php
    $address = $content->address;
?>

@section('external_js')    
    <script>
        var map;
        function initMap()
        {
            @if (!$content->latitude && !$content->longitude)
                map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 14
                });

                var geocoder = new google.maps.Geocoder();
                geocodeAddress(geocoder, map);
            @else
                var lat_lng = {lat: {{ $content->latitude }}, lng: {{ $content->longitude }}}

                map = new google.maps.Map(document.getElementById('map'), {
                    center: lat_lng,
                    zoom: 14
                });

                var marker = new google.maps.Marker({
                    position: lat_lng,
                    map: map,
                    icon: '{{ $content->first_category_icon_url }}'
                });
            @endif
        }

        function geocodeAddress(geocoder, resultsMap)
        {
            var address = "{{ $address }}";
            geocoder.geocode({'address': address}, function(results, status) {
                if (status === google.maps.GeocoderStatus.OK) {
                    resultsMap.setCenter(results[0].geometry.location);
                    var marker = new google.maps.Marker({
                        map: resultsMap,
                        position: results[0].geometry.location,
                        icon: '{{ $content->first_category_icon_url }}'
                    });
                } else {
                    alert('Geocode was not successful for the following reason: ' + status);
                }
            });
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.browser_api_key') }}&callback=initMap" async defer></script>
@stop

@section('underscore')
    @include('underscore.comment')
@stop

@section ('modals')
    @include('modals.suggest_location')
    @include('modals.report_content')
@stop

@section('content')
    <div class="container">
        <div class="row Content__Profile">
            <div class="col-md-9 Content">
                <div>
                    <div class="Content__Profile__Heading">
                        <h1 class="title">{{ $content->title }}</h1>
                        <div class="text-right">
                            <i class="flag-icon flag-icon-{{ strtolower($content->country_code) }}"></i>
                            {{ $address }}<br/>
                            {{ $content->offence_date_time }}
                        </div>
                    </div>
                    <div class="Content__Profile__Player">                        
                        <div class="embed-responsive embed-responsive-16by9">                            
                            @if ($content->type == 'video')
                                @if ($content->embed_id)
                                    <iframe                                    
                                        src="https://www.youtube.com/embed/{{ $content->embed_id }}?{{ $content->start_in_seconds ? 'start='.$content->start_in_seconds.'&' : '' }}autoplay=1&rel=0&modestbranding=1"
                                        frameborder="0"
                                        allowfullscreen
                                    ></iframe>
                                @else
                                    @if (empty($content->embed))
                                        <div class="flowplayer" data-swf="{{ asset('flowplayer.swf') }}" data-key="$108835620266723">
                                            <video autoplay poster="{{ $content->video_poster_url }}">
                                                <source type="video/mp4" src="{{ $content->video_default_url }}">                                
                                            </video>
                                       </div>
                                   @else
                                        {!! $content->embed !!}
                                   @endif
                               @endif
                            @else
                                <img src="{{ $content->photo_url }}" alt="{{ $content->title }}" class="img-responsive">
                            @endif
                        </div>
                    </div>
                    <div class="Content__Profile__Footer">
                        <div>
                            <div class="date-added">Added: {{ $content->created_at }}</div>
                            <div class="navbar">
                                <ul class="nav navbar-nav">
                                    <li>
                                        <a href="{{ $content->owner->url }}">
                                            <img src="{{ $content->owner->small_avatar }}" class="img-circle">
                                            <b>{{ $content->owner->username }}</b>
                                        </a>
                                    </li>
                                    <li>
                                        <a data-toggle="collapse" data-target="#shareCollapse">
                                            <i class="fa fa-share-alt"></i> Share Video
                                        </a>                                        
                                    </li>
                                    <li>
                                        <a
                                            data-toggle="modal"
                                            data-target="#reportContentModal"
                                            data-backdrop="static"
                                        >
                                            <i class="fa fa-exclamation-triangle"></i> Report Content
                                        </a>
                                    </li>
                                </ul>
                            </div>                            
                        </div>
                        <div class="text-right">
                            Views: <b>{{ $content->total_views }}</b><br/>
                            <a
                                title="Like"
                                class="btn-ajax"
                                data-url="{{ $content->like_url }}"
                                data-ajax-data='{"id": {{ $content->id }}}'
                                data-likes-counter="#contentLikesCounter"
                                data-dislikes-counter="#contentDislikesCounter"
                                data-loading-text="{!! button_loading() !!}"
                                data-callback="likeDislike"
                            ><i class="fa fa-thumbs-up"></i></a>
                            <span id="contentLikesCounter">{{ $content->total_likes }}</span> &nbsp;&nbsp;
                            <a
                                title="Dislike"
                                class="btn-ajax"
                                data-url="{{ $content->dislike_url }}"
                                data-ajax-data='{"id": {{ $content->id }}}'
                                data-likes-counter="#contentLikesCounter"
                                data-dislikes-counter="#contentDislikesCounter"
                                data-loading-text="{!! button_loading() !!}"
                                data-callback="likeDislike"
                            ><i class="fa fa-thumbs-down"></i></a> 
                            <span id="contentDislikesCounter">{{ $content->total_dislikes }}</span>
                        </div>
                    </div>
                    <div class="collapse Share__Collapse" id="shareCollapse">
                        <ul class="nav nav-tabs" role="tablist">
                            <li
                                role="presentation"
                                class="active"
                            >
                                <a
                                    id="shareTabTrigger"
                                    role="tab"
                                    data-toggle="tab"
                                    data-target="#shareTab"
                                    aria-controls="shareTab"
                                    aria-expanded="false"
                                >Share</a>
                            </li>
                            <li
                                role="presentation"                                        
                            >
                                <a
                                    class="focus-trigger"
                                    role="tab"
                                    id="embedTabTrigger"
                                    data-target-focus="#contentEmbedCode"
                                    data-toggle="tab"
                                    data-target="#embedTab"
                                    aria-controls="embedTab"
                                    aria-expanded="true"
                                >Embed</a>
                            </li>                                    
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade active in" id="shareTab" aria-labelledby="shareTabTrigger">
                                <ul class="navbar-social">
                                    <li>
                                        <a
                                            class="popup"
                                            data-url="{{ $content->facebook_share_url }}"
                                        >
                                            <i class="fa fa-facebook-square"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a
                                            class="popup"
                                            data-url="{{ $content->twitter_share_url }}"
                                        >
                                            <i class="fa fa-twitter-square"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a
                                            class="popup"
                                            data-url="{{ $content->tumblr_share_url }}"
                                        >
                                            <i class="fa fa-tumblr-square"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a
                                            class="popup"
                                            data-url="{{ $content->google_plus_share_url }}"
                                        >
                                            <i class="fa fa-google-plus-square"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="embedTab" aria-labelledby="embedTabTrigger">
                                <textarea id="contentEmbedCode" class="form-control select-all" rows="3"><iframe src="{{ route('getEmbed', $content->id) }}" frameborder="0" height="400" width="600"></iframe><br><strong>{{ $content->title }}</strong> - powered by <a href="{{ route('home') }}">{{ trans('app.domain_name') }}</a></textarea>
                            </div>                                
                        </div>                                
                    </div>
                    @if (count($content->categories))
                        <div class="Content__Profile__Categories">
                            Category: 
                            @foreach ($content->categories->load('category') as $category)
                                <a href="{{ route('home', ['cat' => $category->niche_id]) }}">{{ $category->category->name }}</a>&nbsp;
                            @endforeach
                        </div>
                    @endif
                    <div class="Content__Profile__Description">
                        <h4 class="header-title">Description</h4>
                        <p class="body">{{ $content->description }}</p>
                    </div>
                </div>
                @if (!$content->disable_map)
                    <div class="Content__Profile__Map Map">
                        <h4 class="Content__Heading"><span>See the {{ $content->type }} location</span></h4>
                        <div class="position-relative">
                            <div id="map"></div>
                            <a
                                class="suggest-location-trigger"
                                data-toggle="modal"
                                data-target="#suggestLocationModal"
                                data-backdrop="static"
                            >
                                <i class="fa fa-info-circle"></i> Wrong Location? Report!
                            </a>
                        </div>
                    </div>
                @endif
                @if (!$content->disable_comments)
                    <div id="comments" class="Content__Profile__Comments">
                        @include('partials.comments')
                    </div>
                @endif
                <div class="Related__Videos">
                    <h4 class="Content__Heading"><span>See Related Videos</span></h4>
                    <div class="Listing gutter-5">
                        <div class="row">
                            <div class="col-md-4">
                                <div>
                                    <a href="" class="Thumbnail">
                                        <div class="Thumbnail__Header">
                                            <div>
                                                Kids on electric bikes running a red light
                                                <i class="flag-icon flag-icon-gb"></i>
                                            </div>
                                            <div class="backdrop"></div>
                                        </div>
                                        <img class="img-responsive" src="http://cdn.thumbs.roadshamer.com/1/2/2/5/5/1225576dbdc2e316.mp4/1225576dbdc2e316.mp4-3.jpg">
                                        <div class="nav Thumbnail__Footer">
                                            <ul class="nav navbar-nav navbar-padding-li">
                                                <li><i class="fa fa-eye"></i> 322</li>
                                                <li><i class="fa fa-comments"></i> 24</li>
                                            </ul>
                                            <ul class="nav navbar-nav navbar-right navbar-padding-li">
                                                <li><i class="fa fa-thumbs-up"></i> 323</li>
                                                <li><i class="fa fa-thumbs-down"></i> 40</li>
                                            </ul>
                                            <div class="backdrop"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div>
                                    <a href="" class="Thumbnail">
                                        <div class="Thumbnail__Header">
                                            <div>
                                                Kids on electric bikes running a red light
                                                <i class="flag-icon flag-icon-gb"></i>
                                            </div>
                                            <div class="backdrop"></div>
                                        </div>
                                        <img class="img-responsive" src="http://cdn.thumbs.roadshamer.com/1/2/2/5/5/1225576dbdc2e316.mp4/1225576dbdc2e316.mp4-3.jpg">
                                        <div class="nav Thumbnail__Footer">
                                            <ul class="nav navbar-nav navbar-padding-li">
                                                <li><i class="fa fa-eye"></i> 322</li>
                                                <li><i class="fa fa-comments"></i> 24</li>
                                            </ul>
                                            <ul class="nav navbar-nav navbar-right navbar-padding-li">
                                                <li><i class="fa fa-thumbs-up"></i> 323</li>
                                                <li><i class="fa fa-thumbs-down"></i> 40</li>
                                            </ul>
                                            <div class="backdrop"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div>
                                    <a href="" class="Thumbnail">
                                        <div class="Thumbnail__Header">
                                            <div>
                                                Kids on electric bikes running a red light
                                                <i class="flag-icon flag-icon-gb"></i>
                                            </div>
                                            <div class="backdrop"></div>
                                        </div>
                                        <img class="img-responsive" src="http://cdn.thumbs.roadshamer.com/1/2/2/5/5/1225576dbdc2e316.mp4/1225576dbdc2e316.mp4-3.jpg">
                                        <div class="nav Thumbnail__Footer">
                                            <ul class="nav navbar-nav navbar-padding-li">
                                                <li><i class="fa fa-eye"></i> 322</li>
                                                <li><i class="fa fa-comments"></i> 24</li>
                                            </ul>
                                            <ul class="nav navbar-nav navbar-right navbar-padding-li">
                                                <li><i class="fa fa-thumbs-up"></i> 323</li>
                                                <li><i class="fa fa-thumbs-down"></i> 40</li>
                                            </ul>
                                            <div class="backdrop"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h4 class="Content__Heading text-right bottom"><span><a href="">See more similar videos</a></span></h4>
                </div>
            </div>
            @include('partials.side_bar')
        </div>
    </div>
@stop