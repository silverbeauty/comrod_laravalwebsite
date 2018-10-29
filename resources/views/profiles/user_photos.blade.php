@extends('layouts.master')

@section('title', ucfirst($profile->username).'\'s Uploads')
@section('description', ucfirst($profile->username).'\'s Uploads')

@section('external_js')
    @if ($photos->count())
        @include('underscore.map_results')
        <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.browser_api_key') }}&callback=mapCallback" async defer></script>
    @endif
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-sm-12 col-xs-12 Content">
                <div>
                    <h2 class="Content__Heading user-content-heading">
                        <span>{{ ($signed_in && $user->id == $profile->id) ? 'My Photos ('.$photos->count().')' : ucfirst($profile->username).'\'s Photos ('.$photos->count().')' }}</span>
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
                    @if ($photos->count())
                        <div class="Listing gutter-5">
                            @foreach ($photos->chunk(3) as $chunk_contents)
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
                @if ($photos->count())
                    <div class="Map">
                        <h2 class="Content__Heading">
                            <span>Locations of {{ ($signed_in && $user->id == $profile->id) ? 'my' : ucfirst($profile->username).'\'s' }} photos</span>
                        </h2>                  
                        <div id="map"></div>
                        {{--<h2 class="Content__Heading text-right bottom">
                            <span class="with-dropdown">Show all categories on map</span>
                            <div class="dropdown right">
                                <a data-toggle="dropdown"><i class="fa fa-chevron-circle-down fa-lg"></i></a>
                                <ul class="dropdown-menu pull-right">
                                    <li><a href="#"><i class="flag-icon flag-icon-gb"></i> EN</a></li>
                                    <li><a href="#"><i class="flag-icon flag-icon-il"></i> IL</a></li>
                                    <li><a href="#"><i class="flag-icon flag-icon-ro"></i> RO</a></li>
                                    <li><a href="#"><i class="flag-icon flag-icon-ru"></i> RU</a></li>                             
                                </ul>
                            </div>                      
                        </h2>--}}
                    </div>
                @endif               
            </div>
            @include('partials.side_bar')
        </div>
    </div>
@stop
