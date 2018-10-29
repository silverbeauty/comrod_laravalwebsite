<div class="desktop">
<footer>
        <div class="footer-item">
            <div class="logo-footer"></div>
            <a href="#" class="google-button google-play-button"></a>
            <a href="#" class="google-button google-play-get-expert-recommendations-button"></a>
        </div>
        <div class="footer-item">
            <ul class="footer-navigation">
                
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
            <div class="copyright">© 2018 Comroads.com. All rights reserved</div>
            <div class="follow-us-set">
                <a href="" class="footer-icon vimeo-icon"></a>
                <a class="footer-icon twitter-icon" href="https://twitter.com/Comroads_Global" target="_blank"></a>
                <a  class="footer-icon facebook-icon" href="{{ facebook_url($default_country_code) }}" target="_blank"></a>
            </div>
        </div>
    </footer>
</div>
<div class="mobile">
<div class="footer animation">
            <img src="img/logofooter.png" style="margin-top:15vw;margin-bottom:10vw">
            <div class="getinon"><img src="img/google.png"> <img src="img/get.png"></div>
            <div class="buttonFooter"><a href="http://34.219.112.2/v4">Home</a></div>
            <div class="buttonFooter"><a href="{{ route('home') }}">Gallery</a></div>
            <div class="buttonFooter"><a href="{{ route('upload::getVideo') }}">Upload</a></div>
            <div class="buttonFooter"><a href="{{ route('about-us') }}">About us</a></div>
            <div class="buttonFooter"><a href="{{ route('contact-us') }}">Contact us</a></div>
            <div class="buttonFooter"><a href="{{ route('faq') }}">FAQ</a></div>
            <p>© 2018 Comroads.com.<br>
            All rights reserved</p>
            <div class="social">
                <a href=""><img src="img/vimeo.png"></a> <a href="https://twitter.com/Comroads_Global"><img src="img/twitter.png"></a> <a href="{{ facebook_url($default_country_code) }}"><img src="img/facebook.png"></a>
            </div>
        </div>
</div>