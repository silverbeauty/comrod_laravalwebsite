@extends('layouts.master')

@section('title', 'Signup')
@section('description', 'Signup')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h2 class="Content__Heading"><span>Create a free account</span></h2><br>
                @include('partials.errors')
                <form action="{{ route('auth::postSocialSignup') }}" method="post" class="form-horizontal gutter-5">
                    {{ csrf_field() }}
                    
                    @if (session('social.email'))
                        <input type="hidden" name="email" value="{{ session('social.email') }}">
                    @endif
                    
                    <input type="hidden" name="first_name" value="{{ session('social.first_name') }}">
                    <input type="hidden" name="last_name" value="{{ session('social.last_name') }}">
                    <input type="hidden" name="avatar_social" value="{{ session('social.avatar') }}">

                    <div class="form-group">
                        <label class="control-label col-md-3">Username <span class="asterisk text-primary">*</span></label>
                        <div class="col-md-8">
                            <input
                                type="text"
                                name="username"
                                value="{{ old('username', session('social.username')) }}"
                                class="form-control"
                                placeholder=""
                            >
                            <p class="help-block no-margin-bottom">This is what people will see when you post videos and comment on them.</p>                            
                        </div>
                    </div>
                    @if (!session('social.email'))
                        <div class="form-group">
                            <label class="control-label col-md-3">Email <span class="asterisk text-primary">*</span></label>
                            <div class="col-md-8">
                                <input
                                    type="text"
                                    name="email"
                                    value="{{ old('email') }}"
                                    class="form-control"
                                    placeholder=""
                                >                            
                            </div>
                        </div>
                    @endif
                    {{--<div class="form-group">
                        <div class="col-md-8 col-md-offset-3">
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
                        <label class="control-label col-md-3">License Plate <span class="text-primary asterisk">*</span></label>
                        <div class="col-md-8">
                            <input type="text" name="license_plate" value="{{ old('license_plate') }}" class="form-control" placeholder="">
                        </div>
                    </div>
                    <div class="form-group register-alerts-hidden-element {{ old('register_for_alerts') ? '' : 'hidden' }}">
                        <label class="control-label col-md-3">Country <span class="text-primary asterisk">*</span></label>
                        <div class="col-md-8">
                            <select name="license_plate_country_code" class="form-control chosen-select" data-placeholder="Select country">
                                <option></option>
                                @foreach (countries() as $country)
                                    <option
                                        value="{{ $country->code }}"
                                        {{ $country->code == old('license_plate_country_code', geoip_country_code_by_name('112.210.111.99')) ? 'selected' : '' }}
                                    >{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group register-alerts-hidden-element {{ old('register_for_alerts') ? '' : 'hidden' }}">
                        <div class="col-md-9 col-md-offset-3">
                            <div class="checkbox-inline no-padding-top">
                                <label>
                                    <input
                                        type="checkbox"
                                        name="signup_friendly_alerts"
                                        {{ old('signup_friendly_alerts') ? 'checked' : '' }}
                                    >
                                    Sign up for Friendly Alerts
                                </label>
                            </div>
                            <div class="checkbox-inline no-padding-top">
                                <label>
                                    <input
                                        type="checkbox"
                                        name="signup_parental_alerts"
                                        {{ old('signup_parental_alerts') ? 'checked' : '' }}
                                    >
                                    Sign up for Parental Alerts
                                </label>
                            </div>
                        </div>
                    </div>--}}
                    <div class="form-group">
                        <div class="col-md-9 col-md-offset-3">
                            <button type="submit" class="btn btn-primary">Continue</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop