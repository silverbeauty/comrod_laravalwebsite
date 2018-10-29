<div class="desktop">
    <div class="header">
    <div class="logo"></div>
    <div class="menu">
        <ul class="navigation">
            
            @if(Request::url() == 'http://34.219.112.2/v4') 
                <li><a href="#">{{ trans('header.menu.home') }}</a></li>
                <li><a href="{{ route('home') }}">Gallery</a></li>
                <li><a href="{{ route('upload::getVideo') }}">{{ trans('header.menu.upload') }}</a></li>
                <li><a href="{{ route('about-us') }}">{{ trans('header.menu.about-us') }}</a></li>
                <li><a href="{{ route('contact-us') }}">{{ trans('header.menu.contact-us') }}</a></li>
                <li class="faq-button"><a href="{{ route('faq') }}">{{ trans('header.menu.faq') }}</a></li>
                @else
                <li><a href="http://34.219.112.2/v4">{{ trans('header.menu.home') }}</a></li>
                <li><a href="{{ route('home') }}">Gallery</a></li>
                <li><a href="{{ route('upload::getVideo') }}">{{ trans('header.menu.upload') }}</a></li>
                <li><a href="{{ route('about-us') }}">{{ trans('header.menu.about-us') }}</a></li>
                <li><a href="{{ route('contact-us') }}">{{ trans('header.menu.contact-us') }}</a></li>
                <li><a href="{{ route('faq') }}">{{ trans('header.menu.faq') }}</a></li>
            @endif
            
        </ul>
        <ul class="user-panel">
            <li><a href="#" data-toggle="modal" data-target="#signUpModal" data-backdrop="static"><span class="icon pen-icon"></span>Sign up</a></li>
            <li><a href="#" data-toggle="modal" data-target="#loginModal" data-backdrop="static"><span class="icon user-icon"></span>Login</a></li>
            <!--<li><a href="#"><span class="icon lang-en-icon"></span>en<span class="icon dropdown-arrow-icon"></span></a></li> -->
            <li>
                <div class="dropdown" style="display: unset">
                    <i class="icon lang-{{ strtolower($currentLanguage->locale) }}-icon"></i>
                    <span>{{ $currentLanguage->locale }}</span>
                    <a data-toggle="dropdown"><span class="icon dropdown-arrow-icon"></a>
                    <ul class="dropdown-menu pull-right" aria-labelledby="dropdownMenu1">
                        @foreach ($selectableLanguages as $language)
                            <li>                                        
                                <a href="{{ language_url(strtolower($language->locale), strtolower($currentLanguage->locale)) }}"><span class="icon lang-{{ $language->locale }}-icon"></span>{{ strtoupper($language->locale) }}</a>
                            </li>
                        @endforeach
                    </ul> 
                </div>
            </li>
        </ul>
    </div>
</div>
</div>
<div class="mobile">
   <div class="navigation " data-sr="">
        <div class="logo"><img src="img/logo.png"></div>
        <div class="navMenu">
            <ul class="menu">
                <li>
                    <a href="#"><img src="img/Navigation.png"></a>
                    <ul class="submenu">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="">Gallery</a></li>
                        <li><a href="{{ route('upload::getVideo') }}">Upload</a></li>
                        <li><a href="{{ route('about-us') }}">About us</a></li>
                        <li><a href="{{ route('contact-us') }}">Contact us</a></li>
                        <li><a href="{{ route('faq') }}">FAQ</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
