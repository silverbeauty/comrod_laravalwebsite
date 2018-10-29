@extends('layouts.master')

@section('title', $content->title)
@section('description', $content->description)

@if (!$is_ajax && !$is_mobile)
    @section('og')
        <meta property="og:title" content="{{ $content->title }}" />
        <meta property="og:description" content="{{ $content->description }}" />
        <meta property="og:url" content="{{ $content->url }}" />
        <meta property="og:image" content="{{ $content->thumbnail_url }}" />
    @stop
@endif

@section('body_class', 'Video__Profile')

@if (!$is_ajax && !$is_mobile)
    @section('external_js')
        @if (!$content->disable_map)
            @include('underscore.map_results')     
            <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.browser_api_key') }}&callback=mapCallback" async defer></script>
        @endif
        {{-- <script src="//s0.2mdn.net/instream/html5/ima3.js"></script> --}}
    @stop
@endif

@section('underscore')
    @include('underscore.comment')
@stop

@section ('modals')
    @if (!$is_ajax && !$is_mobile)
        @include('modals.suggest_location')    
        @include('modals.home_page_categories')
    @endif
@stop

@section('content')
    <div class="container">
        @if ($content->private)
            <div class="alert alert-info clearfix">
                {{ trans('app.private-content-info', ['type' => trans('video.' . $content->type)]) }}

                <a href="{{ $content->edit_url }}" class="pull-right">{{ trans('video.edit') }}</a>
            </div>
        @endif
        <div {{ $is_ajax ? 'id=pjaxModalContentContainer' : null }}>
            <div class="Content__Profile__Player">                        
                @if ($content->type == 'video')
                    <div class="embed-responsive embed-responsive-16by9">
                        @if ($content->embed_type == 'youtube')
                            <iframe                                    
                                src="{{ $content->youtube_embed_url }}"
                                frameborder="0"
                                allowfullscreen
                            ></iframe>
                        @elseif ($content->embed_type == 'vidme')
                            <iframe
                                src="{{ $content->vidme_embed_url }}"
                                frameborder="0"
                                allowfullscreen
                                webkitallowfullscreen
                                mozallowfullscreen
                                scrolling="no"
                            ></iframe>
                        @elseif (empty($content->embed))                            
                                @if (is_null($content->encoded_date))
                                    <div class="encoding">{{ trans('app.video_is_being_process') }}</div>
                                @else                                    
                                    @include('partials.' . $player)
                                @endif
                        @else
                            {!! $content->embed !!}                            
                        @endif                       
                   </div>
                @else
                    @include('partials.content_profile_carousel')
                @endif                        
            </div>
            <div class="row Content__Profile">
                <div class="col-md-8 col-sm-12 col-xs-12 Content">
                    <div>
                        <div class="Content__Profile__Heading">
                            <div class="text-right">
                                {{ $address }} 
                                <i class="flag-icon flag-icon-{{ strtolower($content->country_code) }}"></i>
                                <br/>
                                {{ $content->offence_date_time }}
                            </div>
                            <h1 class="title text-left">{{ $content->title }}</h1>
                        </div>                    
                        <div class="Content__Profile__Footer Content__Profile__Footer__Video row">
                            <div class="col-md-9">
                                <div class="date-added text-left">{{ $content->created_at }} :{{ trans('video.added') }}</div>
                                <div class="navbar content-info">
                                    <ul class="nav navbar-nav settings-ul">
                                        <li>
                                            <a
                                                data-toggle="modal"
                                                data-target="#reportContentModal"
                                                data-backdrop="static"
                                                data-content="{{ json_encode(['content_id' => $content->id]) }}"
                                            >
                                                {{ trans('video.report-content') }} <i class="fa fa-exclamation-triangle"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a data-toggle="collapse" data-target=".shareCollapse">
                                                {{ trans('video.share') }} {{ ucfirst($type) }} <i class="fa fa-share-alt"></i> 
                                            </a>                                        
                                        </li>
                                        @if ($content->owner)
                                            <li>
                                                <a href="{{ $content->owner->url }}">
                                                    <b>{{ $content->owner->username }}</b>
                                                    <img src="{{ $content->owner->small_avatar }}" class="img-circle">
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>                            
                            </div>
                            <div class="text-right col-md-3">
                                <b>{{ $content->formatted_total_views }}</b> :{{ trans('video.views') }}<br/>
                                <span id="contentDislikesCounter">{{ $content->total_dislikes }}</span> 
                                <a
                                    title="Dislike"
                                    class="btn-ajax @if(Auth::check() && $content->isVoted(Auth::user(), 'dislike')) selected @endif"
                                    data-url="{{ $content->dislike_url }}"
                                    data-ajax-data='{"id": {{ $content->id }}}'
                                    data-likes-counter="#contentLikesCounter"
                                    data-dislikes-counter="#contentDislikesCounter"
                                    data-loading-text="{!! button_loading() !!}"
                                    data-callback="likeDislike"
                                ><i class="fa fa-thumbs-down fa-3x"></i></a>
                                &nbsp;&nbsp;
                                <span id="contentLikesCounter">{{ $content->total_likes }}</span> 
                                <a
                                    title="Like"
                                    class="btn-ajax @if(Auth::check() && $content->isVoted(Auth::user(), 'like')) selected @endif"
                                    data-url="{{ $content->like_url }}"
                                    data-ajax-data='{"id": {{ $content->id }}}'
                                    data-likes-counter="#contentLikesCounter"
                                    data-dislikes-counter="#contentDislikesCounter"
                                    data-loading-text="{!! button_loading() !!}"
                                    data-callback="likeDislike"
                                ><i class="fa fa-thumbs-up fa-3x"></i></a>
                            </div>
                        </div>
                        <div class="collapse Share__Collapse shareCollapse">
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
                                    >{{ trans('video.share') }}</a>
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
                                    >{{ trans('video.embed') }}</a>
                                </li>                                    
                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade active in" id="shareTab" aria-labelledby="shareTabTrigger">
                                    <ul class="navbar-social text-left">
                                        <li>
                                            <a
                                                class="popup"
                                                data-url="{{ $content->google_plus_share_url }}"
                                            >
                                                <i class="fa fa-google-plus-square"></i>
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
                                                data-url="{{ $content->twitter_share_url }}"
                                            >
                                                <i class="fa fa-twitter-square"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a
                                                class="popup"
                                                data-url="{{ $content->facebook_share_url }}"
                                            >
                                                <i class="fa fa-facebook-square"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="embedTab" aria-labelledby="embedTabTrigger">
                                    <textarea id="contentEmbedCode" class="form-control select-all" rows="3"><iframe src="{{ route('getEmbed', $content->id) }}" frameborder="0" height="400" width="600"></iframe><br><strong>{{ $content->title }}</strong> - {{ trans('video.powered-by') }} <a href="{{ route('home') }}">{{ trans('app.domain_name') }}</a></textarea>
                                </div>                                
                            </div>                                
                        </div>
                        @if (count($content->categories))
                            <div class="Content__Profile__Categories text-left">
                                @foreach ($content->categories->load('category') as $category)
                                    <?php $niche = $category->category; ?>
                                    @if ($niche)
                                        <a href="{{ route('home', ['cat' => $category->niche_id]) }}">{{ $niche->name }}</a>&nbsp;
                                    @endif
                                @endforeach
                                :{{ trans('video.category') }}
                            </div>
                        @endif
                        @if ($content->description)
                            <div class="Content__Profile__Description text-left">
                                <h4 class="header-title">{{ trans('video.description') }}</h4>
                                <p class="body">{!! linkify(nl2br($content->description)) !!}</p>
                            </div>
                        @endif
                    </div>
                    @if (!$content->disable_map && !$is_ajax && !$is_mobile)
                        <div class="Content__Profile__Map Map">
                            @include('partials.map_header-right')
                            <div class="position-relative">
                                <div id="contentProfileMap" style="height:300px;"></div>
                                <a
                                    class="suggest-location-trigger init-map"
                                    data-toggle="modal"
                                    data-target="#suggestLocationModal"
                                    data-backdrop="static"
                                    data-attribute="{{ json_encode([
                                        'map_element_id' => 'wrong-location-map',
                                        'map_icon' => $category_icon_url,
                                        'map_marker_draggable' => true,
                                        'map_marker_title' => 'Drag me to change location!',
                                        'map_marker_events' => ['dragend'],
                                        'latitude' => $content->latitude,
                                        'longitude' => $content->longitude,
                                        'address' => $address,
                                        'zoom' => 14,
                                        'default_marker' => true,
                                    ]) }}"
                                >
                                    {{ trans('video.wrong-location-report') }} <i class="fa fa-info-circle"></i>
                                </a>
                                <div class="backdrop map-loading hidden"></div>
                                <div class="loader map-loading hidden">
                                    <i class="fa fa-spinner fa-pulse"></i> {{ trans('home.loading_map') }}
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    @if (!$is_ajax && !$is_mobile && count($related))
                        <h4 class="Content__Heading text-left"><span>{{ trans('video.other_type_in_this_area', ['type' => $type.'s']) }}</span></h4>
                        @include('partials.carousel', ['contents' => $related])
                    @endif

                    @if (!$content->disable_comments)
                        <div id="comments" class="Content__Profile__Comments">
                            @include('partials.comments-right')
                        </div>
                    @else
                        <div class="text-left">{{ trans('video.comments_disabled_text', ['type' => $type.'s']) }}</div>
                    @endif                
                </div>
                @include('partials.side_bar')
            </div>
        </div>
    </div>    
@stop