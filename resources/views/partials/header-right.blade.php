<div class="Header">
    <div class="{{ $layout == 'v2' ? 'container-fluid' : 'container' }}">
        <div class="row">
            <div class="col-md-7 col-sm-12 col-xs-12 logo-cont text-left">
                <a href="{{ route('home') }}">
                    <img src="{{ asset_cdn('images/logo.png') }}">
                    {{-- <img src="/images/under-construction.png" width="150"> --}}
                </a>
            </div>
            <div class="col-md-5 col-sm-12 col-xs-12">
                <ul class="Header__Menu">
                    <li>
                        <div class="dropdown">
                            <a data-toggle="dropdown"><i class="fa fa-chevron-circle-down fa-lg"></i></a>
                            <ul class="dropdown-menu pull-right" aria-labelledby="dropdownMenu1">
                                @foreach ($selectableLanguages as $language)
                                    <li>
                                        <a href="{{ language_url(strtolower($language->locale), strtolower($currentLanguage->locale)) }}">
                                            {{ strtoupper($language->locale) }} <i class="flag-icon flag-icon-{{ $language->country_code }}"></i>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                            <i class="flag-icon flag-icon-{{ strtolower($currentLanguage->country_code) }}"></i>
                            <span>:{{ trans('header.language') }}</span>
                        </div>
                    </li>
                    @if (!$signed_in)
                        @if ($route_name != 'auth::getLogin')
                            <li><a data-toggle="modal" data-target="#loginModal" data-backdrop="static">{{ trans('header.login') }}</a></li>
                        @endif
                        @if ($route_name != 'auth::getSignup')
                            <li><a data-toggle="modal" data-target="#signUpModal" data-backdrop="static">{{ trans('header.sign-up') }}</a></li>
                        @endif
                    @else
                        <li class="dropdown">
                            <a data-toggle="dropdown" class="hide-trigger" data-hidable-target="#headerNotificationCounter">
                                <img src="{{ $user->small_avatar }}" class="img-circle avatar">
                                @if (isset($total_notifications) && $total_notifications)
                                    <span class="counter" id="headerNotificationCounter">{{ $total_notifications }}</span>
                                @endif
                            </a>
                            <ul class="dropdown-menu pull-right" aria-labelledby="dropdownMenu1">
                                <li><a href="{{ $user->url }}">{{ trans('header.my-profile') }} <i class="fa fa-fw fa-user"></i></a></li>
                                <li><a href="{{ $user->edit_profile_url }}">{{ trans('header.edit-profile') }} <i class="fa fa-fw fa-pencil-square-o"></i></a></li>
                                <li><a href="{{ $user->messages_url }}">({{ isset($total_messages)?$total_messages:0 }}) {{ trans('header.messages') }} <i class="fa fa-fw fa-envelope"></i></a></li>
                                <li><a href="{{ $user->discussions_url }}">({{ $user->total_unread_discussions }}) {{ trans('header.comments') }} <i class="fa fa-fw fa-comments"></i></a></li>
                                {{--<li><a href="{{ $user->friends_url }}"><i class="fa fa-fw fa-users"></i> Friends (0)</a></li>--}}
                                <li><a href="{{ route('upload::getVideo') }}">{{ trans('header.upload') }} <i class="fa fa-fw fa-upload"></i></a></li>
                                @can ('login_as_admin')
                                    <li><a href="{{ route('admin::getIndex') }}">{{ trans('header.admin-dashboard') }} <i class="fa fa-fw fa-lock"></i></a></li>
                                @endcan
                                <li><a href="{{ $user->settings_url }}">{{ trans('header.settings') }} <i class="fa fa-fw fa-wrench"></i></a></li>
                                <li><a href="{{ route('auth::getLogout') }}">{{ trans('header.logout') }} <i class="fa fa-fw fa-sign-out"></i></a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>

<nav class="navbar navbar-default navbar-static-top Main__Menu">
    <div class="{{ $layout == 'v2' ? 'container-fluid' : 'container' }}">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-menu" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route('home') }}">Comroads</a>
        </div>
        <div class="collapse navbar-collapse" id="main-menu">
            <ul class="nav navbar-nav">
                <li><a href="{{ route('home') }}">{{ trans('header.menu.home') }}</a></li>
                <li><a href="{{ route('upload::getVideo') }}">{{ trans('header.menu.upload') }}</a></li>
                <li><a href="{{ route('about-us') }}">{{ trans('header.menu.about-us') }}</a></li>
                <li><a href="{{ route('contact-us') }}">{{ trans('header.menu.contact-us') }}</a></li>
                <li><a href="{{ route('faq') }}">{{ trans('header.menu.faq') }}</a></li>
                <li><a href="{{ route('blog') }}">{{ trans('header.menu.blog') }}</a></li>
                <li><a href="{{ route('dashcams') }}">{{ trans('header.menu.dashcams') }}</a></li>
                {{--<li>
                    <a href="{{ route('liveFeeds') }}">
                        {{ trans('app.live_feed') }}
                        <sup style="color:#ff0">{{ trans('app.new') }}</sup>
                    </a>
                </li>--}}
            </ul>
            <ul class="nav navbar-nav navbar-right navbar-social">
                @if ($layout == 'v2')
                    <li>
                        <a class="content-type-switch">
                            <label class="radio-inline">
                                <input
                                    type="radio"
                                    name="content_type"
                                    value="photo"
                                    class="icheck redirect"
                                    data-href="{{ route('photos') }}"
                                    {{ $route_name == 'photos' ? 'checked' : '' }}
                                >
                                {{ trans('home.photo') }}
                            </label>
                        </a>
                    </li>
                    <li>
                        <a class="content-type-switch">
                            <label class="radio-inline no-padding">
                                <input
                                    type="radio"
                                    name="content_type"
                                    value="video"
                                    class="icheck redirect"
                                    data-href="{{ route('videos') }}"
                                    {{ $route_name == 'videos' ? 'checked' : '' }}
                                >
                                {{ trans('home.video') }}
                            </label>
                        </a>
                    </li>
                @endif
                <li><a href="{{ facebook_url($default_country_code) }}" target="_blank"><i class="fa fa-facebook-square"></i></a></li>
                <li><a href="https://twitter.com/Comroads_Global" target="_blank"><i class="fa fa-twitter-square"></i></a></li>
                <li><a href=""><i class="fa fa-vimeo-square"></i></a></li>
            </ul>
        </div>
    </div>
</nav>

@if ($signed_in && !$user->verified_email)
    <div class="Header_Notification bg-info">
        <div class="container">
            <div class="row">
                <div class="col-md-5 col-sm-6 col-xs-12">
                    <a
                        class="btn btn-default btn-ajax"
                        data-loading-text="{!! button_loading('Sending...') !!}"
                        data-url="{{ route('account::postResendConfirmationEmail') }}"
                    >{{ trans('header.resend-confirmation') }}</a>
                    <a
                        class="btn btn-default"
                        data-toggle="modal"
                        data-backdrop="static"
                        data-target="#changeEmailModal"
                    >{{ trans('header.change-email') }}</a>
                </div>
                <div class="col-md-7 col-sm-6 col-xs-12 text-left">{{ trans('header.notification', ['first_name' => $user->first_name, 'email' => $user->email]) }}</div>
            </div>
        </div>
    </div>
@endif
