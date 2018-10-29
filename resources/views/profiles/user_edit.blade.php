@extends('layouts.master')

@section('title', trans('profile.edit_profile'))
@section('description', trans('profile.edit_profile'))

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-sm-12 col-xs-12">
                <h2 class="Content__Heading"><span>{{ trans('profile.edit_profile') }}</span></h2>        
                <form
                    action="{{ route('api::postEditUserProfile') }}"
                    method="post"
                    class="form-horizontal gutter-5 form-ajax"
                    data-clear="false"
                >
                    {{ csrf_field() }}

                    <input type="hidden" name="birth_day" value="{{ old('birth_day', $user->birth_day) }}" id="birthDay">

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">{{ trans('profile.username') }}</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input
                                type="text"
                                name="username"
                                value="{{ old('username', $user->username) }}"
                                class="form-control"
                                placeholder=""
                            >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">{{ trans('profile.first_name') }}</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input
                                type="text"
                                name="first_name"
                                value="{{ old('first_name', $user->first_name) }}"
                                class="form-control"
                                placeholder=""
                            >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">{{ trans('profile.last_name') }}</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input
                                type="text"
                                name="last_name"
                                value="{{ old('last_name', $user->last_name) }}"
                                class="form-control"
                                placeholder=""
                            >
                        </div>
                    </div>                    
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">{{ trans('profile.gender') }}</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <select name="gender" class="form-control chosen-select" data-placeholder="{{ trans('profile.select_gender') }}">
                                <option></option>
                                <option
                                    value="Male"
                                    {{ old('gender', $user->gender) == 'Male' ? 'selected' : '' }}
                                >Male</option>
                                <option
                                    value="Female"
                                    {{ old('gender', $user->gender) == 'Female' ? 'selected' : '' }}
                                >Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">{{ trans('profile.date_of_birth') }}</label>
                        <div class="col-md-8 col-sm-8 col-xs-12 gutter-5">
                            <div class="row birthday-cont">
                                <div class="col-md-3 col-sm-3 col-xs-3">
                                    <select
                                        name="birth_day_temp"
                                        class="form-control chosen-select date-select"
                                        data-type="birth-day"
                                        data-prefix="birth"
                                        data-hidden-element="birthDay"
                                        data-placeholder="{{ trans('app.day') }}"
                                    >
                                        <option></option>
                                        @for ($i = 1; $i <= 31; $i++)
                                            <option 
                                                value="{{ sprintf('%02d', $i) }}"
                                                {{ sprintf('%02d', $i) == old('birth_day_temp', !is_null($user->birth_day) ? date('d', strtotime($user->birth_day)) : null) ? 'selected' : '' }}
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
                                        data-placeholder="{{ trans('app.month') }}"
                                    >
                                        <option></option>
                                        @foreach (cal_info(0)['months'] as $month_key => $month)
                                            <option
                                                value="{{ sprintf('%02d', $month_key) }}"
                                                {{ old('birth_month_temp', !is_null($user->birth_day) ? date('m', strtotime($user->birth_day)) : null) == sprintf('%02d', $month_key) ? 'selected' : '' }}
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
                                        data-placeholder="{{ trans('app.year') }}"
                                        
                                    >
                                        <option></option>
                                        @foreach (years() as $year)
                                            <option
                                                value="{{ $year }}"
                                                {{ $year == old('birth_year_temp', !is_null($user->birth_day) ? date('Y', strtotime($user->birth_day)) : null) ? 'selected' : '' }}
                                            >{{ $year }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">{{ trans('profile.country') }} <span class="text-primary asterisk">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <select name="country_code" class="form-control chosen-select" data-placeholder="{{ trans('app.select_country') }}">
                                <option></option>
                                @foreach (countries() as $country)
                                    <option
                                        value="{{ $country->code }}"
                                        {{ $country->code == old('country_code', $user->country_code) ? 'selected' : '' }}
                                    >{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-3 col-sm-offset-3">
                            <button
                                type="submit"
                                class="btn btn-primary"
                                data-loading-text="{{ button_loading(trans('app.saving')) }}"
                            >{{ trans('app.save') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop