@include('partials.errors')

<div class="alert alert-info text-center hidden"></div>

<form action="{{ route('auth::postLogin') }}" method="post" class="form-horizontal gutter-5 login-form">
    {{ csrf_field() }}

    <input type="hidden" name="birth_day" value="{{ old('birth_day') }}" id="birthDay">

    <div class="form-group">
        <label class="control-label col-md-2 col-sm-2 col-xs-12">{{ trans('login.username') }}</label>
        <div class="col-md-8 col-sm-8 col-xs-12">
            <input type="text" name="username" value="{{ old('username') }}" class="form-control" placeholder="">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-2 col-sm-2 col-xs-12">{{ trans('login.password') }}</label>
        <div class="col-md-8 col-sm-8 col-xs-12">
            <input type="password" name="password" value="{{ old('password') }}" class="form-control" placeholder="">
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-2 col-sm-offset-2">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <div class="checkbox no-padding">
                        <label>
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            {{ trans('login.remember-me') }}
                        </label>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                    <a href="{{ route('auth::getPasswordEmail') }}">{{ trans('login.forgot-password') }}?</a>
                </div>
            </div>
        </div>
    </div>
    @if (config('app.recaptcha'))      
        <div class="form-group">
            <div class="text-center col-md-8 col-sm-8 col-xs-12 col-md-offset-2 col-sm-offset-2 overflow">
                <div id="loginRecaptcha" class="g-recaptcha"></div>
            </div>
        </div>
    @endif
    <div class="form-group">
        <div class="text-center col-md-8 col-md-offset-2">
            <button type="submit" class="btn btn-primary btn-rounded">&nbsp;&nbsp;&nbsp;{{ trans('login.login') }}&nbsp;&nbsp;&nbsp;</button>
        </div>
    </div>
    @include('partials.social_login_buttons')
    <div class="form-group">
        <div class="text-center col-md-8 col-md-offset-2">
            <p>{{ trans('login.dont-have-account') }}?</p>
            <a href="{{ route('auth::getSignup') }}" class="btn btn-primary btn-rounded">{{ trans('login.sign-up-for-free') }}</a>
        </div>
    </div>
</form>