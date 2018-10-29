<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="@yield('description')">
        <meta name="author" content="comroads.com">
        <meta name="csrf_token" content="{{ csrf_token() }}">
        <link rel="icon" href="{{ asset('images/favicon.ico') }}">
        <link rel="stylesheet" href="//releases.flowplayer.org/6.0.5/skin/functional.css">
        <title>@yield('title') - {{ trans('master.title') }}</title>
        
        <script type="text/javascript" src="{{ asset('js/flowplayer.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/flowplayer.hlsjs.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/flowplayer.quality-selector.min.js') }}"></script>
    </head>
    <body id="pjax-container">
        <div class="container">
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
                                src="{{ $content->vidme_embed_url }}?autoplay=1"
                                frameborder="0"
                                allowfullscreen
                                webkitallowfullscreen
                                mozallowfullscreen
                                scrolling="no"
                            ></iframe>
                        @else
                            @if (empty($content->embed))
                                @if (is_null($content->encoded_date))
                                    <div class="encoding">{{ trans('app.video_is_being_process') }}</div>
                                @else
                                    @if (count($flowplayer_settings['clip']['qualities']))
                                        <div id="{{ $is_ajax ? 'flowplaye-ajax' : 'flowplayer' }}"></div>
                                        <script type="text/javascript">
                                        
                                            var settings = {!! json_encode($flowplayer_settings) !!};
                                            
                                            flowplayer("#{{ $is_ajax ? 'flowplaye-ajax' : 'flowplayer' }}", settings).one("ready", function (e, api, video) {
                                                // http://demos.flowplayer.org/api/starttime.html#t={seconds}
                                                var hash = window.location.hash,
                                                pos = hash.substr(3);;

                                                if (hash.indexOf("#t=") === 0 && !isNaN(pos)) {
                                                    // 1 decimal precision
                                                    pos = Math.round(parseFloat(pos) * 10) / 10;
                                                    if (pos < video.duration) {
                                                        api.seek(pos);
                                                    }
                                                }

                                                if (window.hola_cdn) {
                                                   window.hola_cdn.init();
                                                } else {
                                                   window.hola_cdn_on_load = true;
                                                }
                                            });
                                        
                                        </script>
                                    @else
                                        <div
                                            class="flow-player functional"
                                            data-swf="{{ asset('flowplayer.swf') }}"
                                            data-key="$108835620266723"
                                        >    
                                            <video autoplay preload poster="{{ $content->video_poster_url }}">
                                                <source type="video/mp4" src="{{ $content->video_default_url }}">                                
                                            </video>
                                        </div>
                                    @endif
                                @endif
                            @else
                                {!! $content->embed !!}
                            @endif
                       @endif
                   </div>
                @else
                    @include('partials.content_profile_carousel')
                @endif                        
            </div>
        </div>
    </body>
</html>