@extends('layouts.master')

@section('title', trans('profile.discussions'))
@section('description', trans('profile.discussions'))

@section('external_js')
    <script>
        $(function () {
            $.ajax({
                type: 'post',
                data: {},
                url: '{{ route('api::postDiscussionMarkRead') }}',
                dataType: 'json'
            })
        });
    </script>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-sm-12 col-xs-12 Content">
                <div>
                    <h2 class="Content__Heading">
                        <span>
                            <i class="fa fa-comments text-primary"></i>
                            {{ trans('profile.comments') }}
                        </span>
                        <span class="pull-right padding-left">
                            <i class="fa fa-arrow-left text-primary"></i>
                            <a href="{{ $user->url }}" class="text-default">                            
                                {{ trans('profile.back_to_my_profile') }}
                            </a>
                        </span>
                    </h2><br/>
                    @if ($discussions->count())
                        @foreach ($discussions as $discussion)
                            <?php
                                $owner = $discussion->activitable->owner;
                                if (is_null($owner)) {
                                    //dd($discussion);
                                }
                            ?>
                            @if (!is_null($owner))
                                @include('partials.activities.'.$discussion->sub_type)
                            @endif                        
                        @endforeach
                    @else
                        <div class="text-center">{{ trans('profile.no_comments_available') }}</div>
                    @endif
                </div>
            </div>
            @include('partials.side_bar')
        </div>
    </div>
@stop