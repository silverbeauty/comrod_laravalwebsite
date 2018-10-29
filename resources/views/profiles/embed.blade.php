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
    <title>@yield('title') - {{ trans('master.title') }}</title>        
    <link href="/css/app.css" rel="stylesheet">   
</head>
<body class="@yield('body_class')" id="pjax-container">
@if ($content->type == 'video')
        @if ($content->embed_type == 'youtube')
            <iframe 
	            width="100%"                                   
                src="{{ $content->youtube_embed_url }}"
                frameborder="0"
                allowfullscreen
            ></iframe>
        @else
            @if (empty($content->embed))
				<div
                    class="flowplayer functional"
                    data-swf="{{ asset('flowplayer.swf') }}"
                    data-key="$108835620266723"
			       >
                        <video  width="100%" autoplay poster="{{ $content->video_poster_url }}">
                            <source type="video/mp4" src="{{ $content->video_default_url }}">                                
                        </video>
               </div>
           @else
                {!! $content->embed !!}
           @endif
       @endif   
        <script src="{{ asset('js/app.js') }}" class="reloadable"></script>
@else
    <img src="{{ $content->photo_url }}" alt="{{ $content->title }}"  width="100%" >
@endif
</body>
</html>