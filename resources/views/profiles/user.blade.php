@extends('layouts.master')

@section('title', trans('profile.user_profile', ['user' => ucfirst($profile->username)]))
@section('description', trans('profile.user_profile', ['user' => ucfirst($profile->username)]))

@section('external_js')
    @if ($total_contents)
        @include('underscore.map_results')
        <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.browser_api_key') }}&callback=mapCallback" async defer></script>
    @endif
@stop

@section('modals')
    @include('modals.send_message', ['recipient' => $profile])
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-sm-12 col-xs-12 Content {{ is_rtl() ? 'rtl' : '' }}">
                <h2 class="Content__Heading">
                    <span>{{ ($signed_in && $user->id == $profile->id) ? trans('profile.my_profile') : trans('profile.user_profile', ['user' => ucfirst($profile->username)]) }}</span>
                </h2>
                <div class="row User__Profile__Info">
                    <div class="col-xs-9">
                        <table width="100%" class="info">
                            <tr>
                                <td>
                                    <img
                                        src="{{ $profile->medium_avatar }}"
                                        class="img-responsive dropzone-hidable avatar"                                        
                                    >
                                    @if ($signed_in && $user->id == $profile->id)
                                        <div class="dropzone-avatar">
                                            <div id="dz-avatar-preview-template" class="hidden">
                                                <div class="dz-preview dz-file-preview">
                                                    <div class="progress no-margin">
                                                        <span class="progress-bar" data-dz-uploadprogress></span>
                                                    </div>                                              
                                                </div>
                                            </div>
                                            <div
                                                class="dropzone-avatar-preview hidden"                                                
                                            ></div>
                                        </div>
                                        <p class="help-block">
                                            <a class="btn btn-default btn-block btn-sm dz-avatar-trigger dropzone-hidable">
                                                <i class="fa fa-camera"></i> {{ trans('profile.update_avatar') }}
                                            </a>
                                        </p>
                                    @endif
                                </td>
                                <td class="v-top">
                                    <table width="100%">
                                        <tr>
                                            <td>{{ trans('profile.username') }}:</td>
                                            <td>{{ $profile->username }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('profile.gender') }}:</td>
                                            <td>{{ $profile->gender }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('profile.age') }}:</td>
                                            <td>{{ $profile->age }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('profile.country') }}:</td>
                                            <td>
                                                {{ $profile->country_name }}
                                                {!! flag_icon($profile->country_code) !!}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('profile.joined') }}:</td>
                                            <td>{{ $profile->date_joined }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('profile.last_login') }}:</td>
                                            <td>{{ $profile->formatted_last_login }}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                    @if ($signed_in && $user->id == $profile->id)                   
                        <div class="col-xs-3 text-right">
                            <div>
                                <i class="fa fa-pencil-square-o text-primary"></i> 
                                <a href="{{ $user->edit_profile_url }}" class="text-default">{{ trans('profile.edit_profile') }}</a>
                            </div>
                            <!-- <div><a href="">Register for Alerts</a></div> -->
                        </div>
                    @else
                        <div class="col-xs-3 text-right">
                            <a
                                class="btn btn-primary btn-sm {{ !$signed_in ? 'login-modal' : '' }}"
                                @if ($signed_in)
                                    data-toggle="modal"
                                    data-target="#sendMessageModal"
                                    data-backdrop="static"
                                @else
                                    data-info-message="{{ trans('login.need_login_message') }}"
                                @endif
                            >
                                <i class="fa fa-envelope"></i> {{ trans('profile.send_message') }}
                            </a>
                        </div>
                    @endif
                </div>
                @if ($signed_in && $user->id == $profile->id)
                    <ul class="User__Profile__Menu">
                        <li>
                            <i class="fa fa-envelope text-primary"></i> 
                            <a href="{{ $user->messages_url }}">{{ trans('profile.messages') }} ({{ $total_messages }})</a>
                        </li>
                        <li>
                            <i class="fa fa-comments text-primary"></i> 
                            <a href="{{ $user->discussions_url }}">{{ trans('profile.comments') }} ({{ $profile->total_unread_discussions }})</a>
                        </li>
                        {{--<li><i class="fa fa-users text-primary"></i> <a href="">Friends</a></li>--}}
                    </ul>
                @endif
                <div>
                    <h2 class="Content__Heading">
                        <span>{{ ($signed_in && $user->id == $profile->id) ? trans('profile.my_recent_uploads') . ' ('.$total_contents.')' : trans('profile.user_recent_uploads', ['user' => ucfirst($profile->username)]) . ' ('.$total_contents.')' }}</span>
                        <div class="dropdown left">
                            <a data-toggle="dropdown"><i class="fa fa-chevron-circle-down fa-lg"></i></a>
                            <ul class="dropdown-menu pull-right">
                                <li>
                                    <a href="{{ $profile->videos_url }}">
                                        <i class="fa fa-video-camera fa-fw"></i>
                                        {{ trans('profile.videos') }} ({{ $total_videos }})
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ $profile->photos_url }}">
                                        <i class="fa fa-camera fa-fw"></i>
                                        {{ trans('profile.photos') }} ({{ $total_photos }})
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </h2>
                    @if ($total_contents)
                        <div class="Listing gutter-5">
                            @foreach ($contents->chunk(3) as $chunk_contents)
                                <div class="row">
                                    @foreach ($chunk_contents as $content)
                                        @include('partials.content_thumbnail')
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                        @if ($total_contents > 6)
                            <h2 class="Content__Heading text-right bottom">
                                <a href="{{ $profile->uploads_url }}">
                                    <span>{{ trans('profile.show_all') }}</span>
                                    <i class="fa fa-chevron-circle-down fa-lg"></i>
                                </a>             
                            </h2>
                        @endif                           
                    @else
                        <div class="text-center">{{ trans('profile.no_videos_available') }}</div>
                    @endif                    
                </div>
                @if ($total_contents)
                    <div class="Map">
                        <h2 class="Content__Heading">
                            <span>{{ ($signed_in && $user->id == $profile->id) ? trans('profile.locations_of_my_videos') : trans('profile.locations_of_user_videos', ['user' => ucfirst($profile->username)]) }}</span>
                        </h2>                  
                        <div id="map"></div>
                        <div class="backdrop map-loading hidden"></div>
                        <div class="loader map-loading hidden">
                            <i class="fa fa-spinner fa-pulse"></i> {{ trans('home.loading_map') }}
                        </div>
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
