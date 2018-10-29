@extends('layouts.master')

@section('title', ucfirst($profile->username).'\'s Uploads')
@section('description', ucfirst($profile->username).'\'s Uploads')

@section('external_js')
    @if ($contents->count())
        @include('underscore.map_results')
        <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.browser_api_key') }}&callback=mapCallback" async defer></script>
    @endif
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 Content">
                <div>
                    <h2 class="Content__Heading">
                        <span>{{ ($signed_in && $user->id == $profile->id) ? 'My Recent Uploads ('.$contents->count().')' : ucfirst($profile->username).'\'s Recent Uploads ('.$contents->count().')' }}</span>
                        <div class="dropdown left">
                            <a data-toggle="dropdown"><i class="fa fa-chevron-circle-down fa-lg"></i></a>
                            <ul class="dropdown-menu pull-right">
                                <li>
                                    <a href="{{ $profile->videos_url }}">
                                        <i class="fa fa-video-camera fa-fw"></i>
                                        Videos ({{ $profile->total_videos }})
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ $profile->photos_url }}">
                                        <i class="fa fa-camera fa-fw"></i>
                                        Photos ({{ $profile->total_photos }})
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <span class="pull-right padding-left">
                            <i class="fa fa-arrow-left text-primary"></i>
                            <a href="{{ $profile->url }}" class="text-default">                            
                                Back to My Profile
                            </a>
                        </span>
                    </h2>
                    @if ($contents->count())
                        <div class="Listing gutter-5">
                            @foreach ($contents->chunk(3) as $chunk_contents)
                                <div class="row">
                                    @foreach ($chunk_contents as $content)
                                        @include('partials.content_thumbnail')
                                    @endforeach
                                </div>
                            @endforeach
                        </div>                                                   
                    @else
                        <div class="text-center">No recent uploads available</div>
                    @endif                    
                </div>
                @if ($contents->count())
                    <div class="Map">
                        <h2 class="Content__Heading">
                            <span>Locations of {{ ($signed_in && $user->id == $profile->id) ? 'my' : ucfirst($profile->username).'\'s' }} videos</span>
                        </h2>                  
                        <div id="map"></div>                        
                    </div>
                @endif               
            </div>
            @include('partials.side_bar')
        </div>
    </div>
@stop
