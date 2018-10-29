{{--
    <div class="Header">
        <div class="{{ $layout == 'v2' ? 'container-fluid' : 'container' }}">
            <div class="row">
                <div class="col-md-7 col-sm-12 col-xs-12 logo-cont text-left">
                    <a href="{{ route('home') }}">
                        <img src="images/logo.png">
                    </a>
                </div>
                <div class="col-md-5 col-sm-12 col-xs-12">
                    <ul class="Header__Menu">
                        @if (!$signed_in)
                            @if ($route_name != 'auth::getSignup')
                                <li><a data-toggle="modal" data-target="#signUpModal" data-backdrop="static"><button><img src="images/sign-up-icon.png" alt="sign-up-icon">{{ trans('header.sign-up') }}</button></a></li>
                            @endif
                            @if ($route_name != 'auth::getLogin')
                                <li><a data-toggle="modal" data-target="#loginModal" data-backdrop="static">{{ trans('header.login') }}</a></li>
                            @endif
                        @else
                            <li class="dropdown">
                                <a data-toggle="dropdown" class="hide-trigger" data-hidable-target="#headerNotificationCounter">
                                    <img src="{{ $user->small_avatar }}" class="img-circle avatar">
                                    @if ($total_notifications)
                                        <span class="counter" id="headerNotificationCounter">{{ $total_notifications }}</span>
                                    @endif
                                </a>
                                <ul class="dropdown-menu pull-right" aria-labelledby="dropdownMenu1">
                                    <li><a href="{{ $user->url }}"><i class="fa fa-fw fa-user"></i> {{ trans('header.my-profile') }}</a></li>
                                    <li><a href="{{ $user->edit_profile_url }}"><i class="fa fa-fw fa-pencil-square-o"></i> {{ trans('header.edit-profile') }}</a></li>
                                    <li><a href="{{ $user->messages_url }}"><i class="fa fa-fw fa-envelope"></i> {{ trans('header.messages') }} ({{ $total_messages }})</a></li>
                                    <li><a href="{{ $user->discussions_url }}"><i class="fa fa-fw fa-comments"></i> {{ trans('header.comments') }} ({{ $user->total_unread_discussions }})</a></li>
    
                                    <li><a href="{{ route('upload::getVideo') }}"><i class="fa fa-fw fa-upload"></i> {{ trans('header.upload') }}</a></li>
                                    @can ('login_as_admin')
                                        <li><a href="{{ route('admin::getIndex') }}"><i class="fa fa-fw fa-lock"></i> {{ trans('header.admin-dashboard') }}</a></li>
                                    @endcan
                                    <li><a href="{{ $user->settings_url }}"><i class="fa fa-fw fa-wrench"></i> {{ trans('header.settings') }}</a></li>
                                    <li><a href="{{ route('auth::getLogout') }}"><i class="fa fa-fw fa-sign-out"></i> {{ trans('header.logout') }}</a></li>
                                </ul>
                            </li>
                        @endif
                        <li>
                            <span>{{ trans('header.language') }}:</span>
                            <i class="flag-icon flag-icon-{{ strtolower($currentLanguage->country_code) }}"></i>
                            <div class="dropdown">
                                <a data-toggle="dropdown"><i class="fa fa-chevron-circle-down fa-lg"></i></a>
                                <ul class="dropdown-menu pull-right" aria-labelledby="dropdownMenu1">
                                    @foreach ($selectableLanguages as $language)
                                        <li>
                                            <a href="{{ language_url(strtolower($language->locale), strtolower($currentLanguage->locale)) }}">
                                                <i class="flag-icon flag-icon-{{ $language->country_code }}"></i> {{ strtoupper($language->locale) }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
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
                    <div class="col-md-7 col-sm-6 col-xs-12">{{ trans('header.notification', ['first_name' => $user->first_name, 'email' => $user->email]) }}</div>
                    <div class="col-md-5 col-sm-6 col-xs-12 text-right">
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
                </div>
            </div>
        </div>
    @endif
    
    --}}
    
    
        <!-- Header -->
        <header>
    
            <!-- Header top -->
            <div class="header-top">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-3 col-xs-9">
                            <div class="logo">
                                <a  href="{{ route('home') }}"> <img src="/images/logo.png" alt="logo" class="img-responsive"></a>
                            </div>
                        </div>
                        <div class="col-xs-3 hidden-md hidden-lg tar">
                            <a href="{{ route('home') }}" class="mobile-btn">
                                <svg class="svg-inline--fa fa-bars fa-w-14" aria-hidden="true" data-prefix="fa" data-icon="bars" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M16 132h416c8.837 0 16-7.163 16-16V76c0-8.837-7.163-16-16-16H16C7.163 60 0 67.163 0 76v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16z"></path></svg>
                            </a>
                        </div>
                        <div class="col-md-5 col-xs-12 tar">
                            <nav>
                                <ul class="menu">
                                    <li><a href="{{ route('home') }}">Home</a></li>
                                    <li><a href="{{ route('gallery') }}">Gallery</a></li>
                                    <li><a href="{{ route('upload::getVideo') }}">Upload</a></li>
                                    <li><a href="{{ route('about-us') }}">About Us</a></li>
                                    <li><a href="{{ route('contact-us') }}">Contact Us</a></li>
                                    <li><a href="{{ route('faq') }}">FAQ</a></li>
                                </ul>
                            </nav>
                        </div>
                        <div class="col-md-4 col-xs-12 tar">
                            @if (!$signed_in)
                            <div class="menu-bottom-mobile">
                                @if ($route_name != 'auth::getSignup')
                                    <button data-toggle="modal" data-target="#signUpModal" data-backdrop="static"><img src="{{asset_cdn('images/sign-up-icon.png')}}" alt="sign-up-icon">{{ trans('header.sign-up') }}</button>
                                @endif
                                @if ($route_name != 'auth::getLogin')
                                    <button data-toggle="modal" data-target="#loginModal" data-backdrop="static"><img src="{{asset_cdn('images/login-icon.png')}}" alt="login-icon">{{ trans('header.login') }}</button>
                                @endif
                                <div class="language-box">
                                    <img src="{{asset_cdn('images/language-icon.png')}}" alt="language-icon">
                                    <select>
                                        <option value="en">EN</option>
                                        <option value="il">IL</option>
                                    </select>
                                </div>
                                @else
                                     <li class="dropdown">
                                         <a data-toggle="dropdown" class="hide-trigger" data-hidable-target="#headerNotificationCounter">
                                            <img src="{{ $user->small_avatar }}" class="img-circle avatar">
                                            @if ($total_notifications)
                                            <span class="counter" id="headerNotificationCounter">{{ $total_notifications }}</span>
                                            @endif
                                        </a>
                                        <ul class="dropdown-menu pull-right" aria-labelledby="dropdownMenu1">
                                            <li><a href="{{ $user->url }}"><i class="fa fa-fw fa-user"></i> {{ trans('header.my-profile') }}</a></li>
                                            <li><a href="{{ $user->edit_profile_url }}"><i class="fa fa-fw fa-pencil-square-o"></i> {{ trans('header.edit-profile') }}</a></li>
                                            <li><a href="{{ $user->messages_url }}"><i class="fa fa-fw fa-envelope"></i> {{ trans('header.messages') }} ({{ $total_messages }})</a></li>
                                            <li><a href="{{ $user->discussions_url }}"><i class="fa fa-fw fa-comments"></i> {{ trans('header.comments') }} ({{ $user->total_unread_discussions }})</a></li>
                                            {{--<li><a href="{{ $user->friends_url }}"><i class="fa fa-fw fa-users"></i> Friends (0)</a></li>--}}
                                             <li><a href="{{ route('upload::getVideo') }}"><i class="fa fa-fw fa-upload"></i> {{ trans('header.upload') }}</a></li>
                                             @can ('login_as_admin')
                                             <li><a href="{{ route('admin::getIndex') }}"><i class="fa fa-fw fa-lock"></i> {{ trans('header.admin-dashboard') }}</a></li>
                                             @endcan
                                             <li><a href="{{ $user->settings_url }}"><i class="fa fa-fw fa-wrench"></i> {{ trans('header.settings') }}</a></li>
                                             <li><a href="{{ route('auth::getLogout') }}"><i class="fa fa-fw fa-sign-out"></i> {{ trans('header.logout') }}</a></li>
                                         </ul>
                                     </li>
                                 @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Header end -->

     {{--   <nav class="navbar navbar-default navbar-static-top Main__Menu">
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
        </nav>--}}

    
        @if ($signed_in && !$user->verified_email)
            <div class="Header_Notification bg-info">
                <div class="container">
                    <div class="row">
                        <div class="col-md-7 col-sm-6 col-xs-12">{{ trans('header.notification', ['first_name' => $user->first_name, 'email' => $user->email]) }}</div>
                        <div class="col-md-5 col-sm-6 col-xs-12 text-right">
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
                    </div>
                </div>
            </div>
        @endif