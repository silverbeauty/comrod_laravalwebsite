@extends('layouts.master')

@section('title', trans('app.thank_you'))
@section('description', trans('app.thank_you'))

@section('content')
    <div class="container rtl">
        <h2 class="Content__Heading text-center"><span>{{ trans('app.thank_you') }}</span></h2><br/>
        @if ($content->type == 'video')
            @if ($content->embed_type)
                {!! linkify(trans('app.video_embed_thank_you_message', ['url' => $content->url]), ['http', 'https'], []) !!}
            @else
                {!! linkify(trans('app.video_upload_thank_you_message', ['url' => $content->url]), ['http', 'https'], []) !!}
            @endif
        @else
            {!! linkify(trans('app.photo_upload_thank_you_message', ['url' => $content->url]), ['http', 'https'], []) !!}
        @endif
    </div>
@endsection