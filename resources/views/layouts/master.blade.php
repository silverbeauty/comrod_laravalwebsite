<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="@yield('description')">
        <meta name="author" content="comroads.com">
        <meta name="csrf_token" content="{{ csrf_token() }}">

        


        @yield('og')

        <link rel="icon" href="{{ asset_cdn('images/favicon.ico') }}">
        <title>@yield('title') - {{ trans('master.title') }}</title>
        <link href="/css/app.css" rel="stylesheet">

        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="/css/slick.css">
        <link rel="stylesheet" type="text/css" href="/css/slick-theme.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/style.css">
        <link rel="stylesheet" href="/css/menu.css">

        @if (is_rtl())
            <link href="/css/app_ltr.css" rel="stylesheet">
        @endif
        @yield('external_css')

        @if (config('app.player') == 'hola_player')
            <script type="text/javascript" src="/js/video.js"></script>
            <script type="text/javascript">
            videojs.options.flash.swf = "{{ asset('video-js.swf') }}";
            </script>
            <script type="text/javascript" src="/js/videojs.hls.min.js"></script>
            <script type="text/javascript" src="/js/videojs-resolution-switcher.js"></script>
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

{{--        <script type="text/javascript" async crossorigin="anonymous" src="//player.h-cdn.com/loader.js?customer=comroads"></script> --}}
        <script type="text/javascript" src="{{ asset_cdn('js/jquery.js') }}"></script>


        <!--[if lt IE 9]>
         <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
         <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
         <script src="/js/siema.min.js" type="text/javascript"></script>
         <script src="/js/menu.js" type="text/javascript"></script>
         <script src="/js/script.js" type="text/javascript"></script>
         <![endif]-->

        @if (config('app.player') == 'media_element_player')
            <script type="text/javascript" src="/js/mediaelement-and-player.min.js"></script>
        @endif
        @if (config('app.player') == 'flowplayer')
            <script type="text/javascript" src="{{ asset_cdn('js/flowplayer.js') }}"></script>

            {{--@if (browser() != 'Chrome')
                <script type="text/javascript" src="/js/flowplayer.hlsjs.min.js"></script>
            @endif--}}
        @endif
        

        <script type="text/javascript">
            var interval = null;
            var counterInterval = null;
            function refreshIt(element, seconds)
            {
                var timeout = seconds * 1000;

                interval = setInterval(function () { changeSrc(element) }, timeout);
                counterInterval = setInterval(function () {
                    refreshCounter(seconds);
                }, 1000);
            }

            function changeSrc(element)
            {
                var $this = $(element);
                var src = $this.attr('src').split('?')[0] + '?' + new Date().getTime();

                $this.attr('src', src);
                console.log(src);

                clearInterval(interval);
            }

            function refreshCounter(seconds)
            {
                var counter = parseInt($('#refresh-counter').html());

                if (counter == 0) {
                    counter = seconds + 1;
                    clearInterval(counterInterval);
                }

                $('#refresh-counter').html(counter - 1);

            }
        </script>
        {{--<script src="https://use.fontawesome.com/ce2c946636.js"></script> --}}

        
    </head>
    <body class="@yield('body_class')" id="pjax-container">
        @if (!$is_ajax)
            @if (is_rtl())
                @include('partials.header-right')
            @else
                @include('partials.header')
            @endif
        @endif
        @yield('content')

        @if (!$is_ajax)
            @include('partials.footer')
            <script type="text/javascript">
                var global_js_vars = {
                    cancelButtonText: "{{ trans('app.cancel') }}",
                    player: "{{ config('app.player') }}",
                };
            </script>
            @yield('inline_js')
            <div id="appJsContainer">
                <script type="text/javascript" src="{{ asset_cdn('js/app.js', true) }}" class="reloadable"></script>
            </div>
            @yield('external_js')
        @endif

        @if (!$is_ajax && !$signed_in && config('app.recaptcha'))
            <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
            <script type="text/javascript">
            var onloadCallback = function() {
                grecaptcha.render('loginRecaptcha', {
                    'sitekey' : '{{ config('services.google.recaptcha.public_key') }}'
                });
                grecaptcha.render('signupRecaptcha', {
                    'sitekey' : '{{ config('services.google.recaptcha.public_key') }}'
                });
            };
            </script>
        @endif

        @include('partials.flash')
        @yield('modals')
        @yield('underscore')

        @if (!$is_ajax)
            @if (!$signed_in && $route_name != 'auth::getSignup')
                @include('modals.signup')
            @endif

            @if (!$signed_in && $route_name != 'auth::getLogin')
                @include('modals.login')
            @endif

            @if ($signed_in && !$user->verified_email)
                @include('modals.change_email')
            @endif
        @endif


        @if (env('APP_ENV') == 'production' && !$is_ajax)
            @include('partials.analytics')

            @if (session()->has('new_signup'))
                <?php session()->forget('new_signup') ?>
                <script type="text/javascript">
                    / <![CDATA[ /
                    var google_conversion_id = 955347249;
                    var google_conversion_language = "en";
                    var google_conversion_format = "3";
                    var google_conversion_color = "ffffff";
                    var google_conversion_label = "lmUFCMCh8GMQseLFxwM";
                    var google_remarketing_only = false;
                    / ]]> /
                    </script>
                    <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
                    </script>
                    <noscript>
                    <div style="display:inline;">
                        <img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/955347249/?label=lmUFCMCh8GMQseLFxwM&amp;guid=ON&amp;script=0"/>
                    </div>
                </noscript>
            @endif
        @endif

        <script type="text/javascript">
        // <![CDATA[
        var google_conversion_id = 955347249;
        var google_conversion_label = "L68eCKDSjmkQseLFxwM";
        var google_custom_params = window.google_tag_params;
        var google_remarketing_only = true;
        // ]]>
        </script>
        <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
        </script>
        <noscript>
        <div style="display:inline;">
        <img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/955347249/?value=1.00&amp;currency_code=USD&amp;label=L68eCKDSjmkQseLFxwM&amp;guid=ON&amp;script=0"/>
        </div>
        </noscript>

    
    </body>
</html>
