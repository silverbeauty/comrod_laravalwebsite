<div class="form-group">
    <div class="text-center col-md-8 col-md-offset-2">
        <h4 class="Content__Heading text-center"><span>{{ trans('login.or-login-with') }}</span></h4>
        <div class="Social__Login">
            <a href="{{ route('auth::getSocialLogin', 'facebook') }}"><i class="fa fa-facebook-square facebook"></i></a>
            <a href="{{ route('auth::getSocialLogin', 'twitter') }}"><i class="fa fa-twitter-square twitter"></i></a>
            {{-- <a href="{{ route('auth::getSocialLogin', 'pinterest') }}"><i class="fa fa-pinterest-square pinterest"></i></a>
            <a href="{{ route('auth::getSocialLogin', 'vimeo') }}"><i class="fa fa-vimeo-square vimeo"></i></a> --}}
            <a href="{{ route('auth::getSocialLogin', 'google') }}"><i class="fa fa-google-plus-square google"></i></a>
        </div>
    </div>
</div>