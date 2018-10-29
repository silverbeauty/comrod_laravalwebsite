<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="@yield('description')">
        <meta name="author" content="">
        <meta name="csrf_token" content="{{ csrf_token() }}">
        <link rel="icon" href="{{ asset('images/favicon.ico') }}">
        <title>@yield('title') - Admin</title>        
        <link href="{{ elixir('css/app.css') }}" rel="stylesheet">
        @if (is_rtl())
            {{-- <link href="/css/app_ltr.css" rel="stylesheet"> --}}
        @endif

        @if (config('app.player') == 'jwplayer')
            <script type="text/javascript" src="/jwplayer-7.3.6/jwplayer.js"></script>
        @endif
        
        @if (config('app.player') == 'videojs')
            <script type="text/javascript" src="/js/video.js"></script>
            <script type="text/javascript">
            videojs.options.flash.swf = "{{ asset('video-js.swf') }}";
            </script>
            <script type="text/javascript" src="/js/videojs-resolution-switcher.js"></script>
            <script type="text/javascript" src="/js/videojs-contrib-hls.min.js"></script>
        @endif        

        <script type="text/javascript" async crossorigin="anonymous" src="//player.h-cdn.com/loader.js?customer=comroads"></script>
        <script type="text/javascript" src="{{ elixir('js/jquery.js') }}"></script>
        
        @if (config('app.player') == 'media_element_player')
            <script type="text/javascript" src="/js/mediaelement-and-player.min.js"></script>
        @endif

        @if (config('app.player') == 'flowplayer')
            <script type="text/javascript" src="{{ elixir('js/flowplayer.js') }}"></script>
        @endif  
    </head>
    <body class="Admin @yield('body_class')">
        <div id="wrapper">
            @include('admin.partials.header')
            <div id="page-wrapper">
                <div class="container-fluid">
                    @yield('content')
                    @include('admin.footer')                
                </div>            
            </div>
        </div>
        
        <script type="text/javascript">
            var global_js_vars = {
                cancelButtonText: "{{ trans('app.cancel') }}"
            };
        </script>
        <script src="{{ elixir('js/app.js') }}"></script>
        @yield('external_js')        

        @include('partials.flash')
        @yield('modals')
        @yield('underscore')       
              
    </body>
</html>