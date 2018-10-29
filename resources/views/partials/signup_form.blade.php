<div class="form-group clearfix">
    <div class="text-center col-md-8 col-md-offset-2">
        <h5 class="text-center">{{ trans('login.quick_signup') }}</h5>
        <div>
            <a href="{{ route('auth::getSocialLogin', 'facebook') }}"><i class="fa fa-facebook-square facebook fa-5x"></i></a>&nbsp;&nbsp;
            <a href="{{ route('auth::getSocialLogin', 'twitter') }}"><i class="fa fa-twitter-square twitter fa-5x"></i></a>&nbsp;&nbsp;
            {{-- <a href="{{ route('auth::getSocialLogin', 'pinterest') }}"><i class="fa fa-pinterest-square pinterest"></i></a>
            <a href="{{ route('auth::getSocialLogin', 'vimeo') }}"><i class="fa fa-vimeo-square vimeo"></i></a> --}}
            <a href="{{ route('auth::getSocialLogin', 'google') }}"><i class="fa fa-google-plus-square google fa-5x"></i></a>
        </div>
    </div>
</div>

<h5 class="text-center"><span>{{ trans('login.or_signup_with_email') }}</span></h5><br/>

<?php
    $countries = countries();
?>

@include('partials.errors')

<form action="{{ route('auth::postSignup') }}" method="post" class="form-horizontal gutter-5 registration-form">
    {{ csrf_field() }}

    {{--<input type="hidden" name="birth_day" value="{{ old('birth_day') }}" id="birthDay">--}}

    {{--<div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">{{ trans('login.firstname') }}</label>
        <div class="col-md-8 col-sm-8 col-xs-12">
            <input type="text" name="first_name" value="{{ old('first_name') }}" class="form-control" placeholder="">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">{{ trans('login.lastname') }}</label>
        <div class="col-md-8 col-sm-8 col-xs-12">
            <input type="text" name="last_name" value="{{ old('last_name') }}" class="form-control" placeholder="">
        </div>
    </div>--}}
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">{{ trans('login.username') }} <span class="text-primary asterisk">*</span></label>
        <div class="col-md-8 col-sm-8 col-xs-12">
            <input type="text" name="username" value="{{ old('username') }}" class="form-control" placeholder="">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">{{ trans('login.email') }} <span class="text-primary asterisk">*</span></label>
        <div class="col-md-8 col-sm-8 col-xs-12">
            <input type="text" name="email" value="{{ old('email') }}" class="form-control" placeholder="">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">{{ trans('login.password') }} <span class="text-primary asterisk">*</span></label>
        <div class="col-md-8 col-sm-8 col-xs-12">
            <input type="password" name="password" value="" class="form-control" placeholder="">
        </div>
    </div>
    {{--<div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">{{ trans('login.repeat_password') }} <span class="text-primary asterisk">*</span></label>
        <div class="col-md-8 col-sm-8 col-xs-12">
            <input type="password" name="password_confirmation" value="" class="form-control" placeholder="">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">{{ trans('login.gender') }}</label>
        <div class="col-md-8 col-sm-8 col-xs-12">
            <select name="gender" class="form-control chosen-select" data-placeholder="{{ trans('login.select_gender') }}">
                <option></option>
                <option
                    value="Male"
                    {{ old('gender') == 'Male' ? 'selected' : '' }}
                >{{ trans('login.male') }}</option>
                <option
                    value="Female"
                    {{ old('gender') == 'Female' ? 'selected' : '' }}
                >{{ trans('login.female') }}</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">{{ trans('login.date_of_birth') }}</label>
        <div class="col-md-8 col-sm-8 col-xs-12 gutter-5">
            <div class="row birthday-cont">
                <div class="col-md-3 col-sm-3 col-xs-3">
                    <select
                        name="birth_day_temp"
                        class="form-control chosen-select date-select"
                        data-type="birth-day"
                        data-prefix="birth"
                        data-hidden-element="birthDay"
                        data-placeholder="{{ trans('login.day') }}"
                    >
                        <option></option>
                        @for ($i = 1; $i <= 31; $i++)
                            <option 
                                value="{{ sprintf('%02d', $i) }}"
                                {{ sprintf('%02d', $i) == old('birth_day_temp') ? 'selected' : '' }}
                            >{{ sprintf('%02d', $i) }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-5 col-sm-5 col-xs-5">
                    <select
                        name="birth_month_temp"
                        class="form-control chosen-select date-select"
                        data-type="birth-month"
                        data-prefix="birth"
                        data-hidden-element="birthDay"
                        data-placeholder="{{ trans('login.month') }}"
                    >
                        <option></option>
                        @foreach (cal_info(0)['months'] as $month_key => $month)
                            <option
                                value="{{ sprintf('%02d', $month_key) }}"
                                {{ old('birth_month_temp') == sprintf('%02d', $month_key) ? 'selected' : '' }}
                            >{{ $month }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-4">
                    <select
                        name="birth_year_temp"
                        class="form-control chosen-select date-select"
                        data-type="birth-year"
                        data-prefix="birth"
                        data-hidden-element="birthDay"
                        data-placeholder="{{ trans('login.year') }}"
                        
                    >
                        <option></option>
                        @foreach (years() as $year)
                            <option
                                value="{{ $year }}"
                                {{ $year == old('birth_year_temp') ? 'selected' : '' }}
                            >{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>--}}
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">{{ trans('login.country') }} <span class="text-primary asterisk">*</span></label>
        <div class="col-md-8 col-sm-8 col-xs-12">
            <select name="country_code" class="form-control chosen-select" data-placeholder="{{ trans('login.select_country') }}">
                <option></option>
                @foreach ($countries as $country)
                    <option
                        value="{{ $country->code }}"
                        {{ $country->code == old('country_code', $default_country_code) ? 'selected' : '' }}
                    >{{ $country->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- <div class="form-group">
        <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-3 col-sm-offset-3">
            <div class="checkbox no-padding">
                <label>
                    <input
                        type="checkbox"
                        name="register_for_alerts"
                        data-hidden-element=".register-alerts-hidden-element"
                        {{ old('register_for_alerts') ? 'checked' : '' }}
                    >
                    Register for Alerts
                </label>
            </div>
        </div>
    </div>
    <div class="form-group register-alerts-hidden-element {{ old('register_for_alerts') ? '' : 'hidden' }}">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">License Plate <span class="text-primary asterisk">*</span></label>
        <div class="col-md-8 col-sm-8 col-xs-12">
            <input type="text" name="license_plate" value="{{ old('license_plate') }}" class="form-control" placeholder="">
        </div>
    </div>
    <div class="form-group register-alerts-hidden-element {{ old('register_for_alerts') ? '' : 'hidden' }}">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Country <span class="text-primary asterisk">*</span></label>
        <div class="col-md-8 col-sm-8 col-xs-12">
            <select name="license_plate_country_code" class="form-control chosen-select" data-placeholder="Select country">
                <option></option>
                @foreach ($countries as $country)
                    <option
                        value="{{ $country->code }}"
                        {{ $country->code == old('license_plate_country_code', $default_country_code) ? 'selected' : '' }}
                    >{{ $country->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group register-alerts-hidden-element {{ old('register_for_alerts') ? '' : 'hidden' }}">
        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3 col-sm-offset-3">
            <div class="checkbox-inline no-padding-top">
                <label>
                    <input
                        type="checkbox"
                        name="friendly_alerts"
                        {{ old('friendly_alerts') ? 'checked' : '' }}
                    >
                    Sign up for Friendly Alerts
                </label>
            </div>
            <div class="checkbox-inline no-padding-top">
                <label>
                    <input
                        type="checkbox"
                        name="parental_alerts"
                        {{ old('parental_alerts') ? 'checked' : '' }}
                    >
                    Sign up for Parental Alerts
                </label>
            </div>
        </div>
    </div> --}}
    @if (config('app.recaptcha'))   
        <div class="form-group">
            <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-3 col-sm-offset-3">
                <div id="signupRecaptcha" class="g-recaptcha"></div>
            </div>
        </div>
    @endif
    <div class="form-group">
        <div class="text-center">
            <button type="submit" class="btn btn-primary btn-rounded">{{ trans('login.complete_registration') }}</button>
        </div>
    </div>
    <div class="form-group">
        <div class="text-center col-md-8 col-md-offset-2">
            <p>{{ trans('login.have_account') }}</p>
            <a href="{{ route('auth::getLogin') }}" class="btn btn-primary btn-rounded">&nbsp;&nbsp;{{ trans('login.login') }}&nbsp;&nbsp;</a>
        </div>
    </div>
</form>