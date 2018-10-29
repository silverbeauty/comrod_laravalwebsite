@extends('layouts.admin')

@section('title', 'User Settings')
@section('description', 'User Settings')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header clearfix">
                <div class="pull-left">{{ $subject->username }} Settings</div>
                <div class="pull-right">
                    <a href="{{ $subject->url }}" class="btn btn-success btn-sm" target="_blank">Preview</a>
                </div>
            </h3>
            <div class="row">
                <div class="col-lg-7">
                    <div class="panel panel-default">
                        <div class="panel-heading"><h4 class="panel-title">Profile</h4></div>
                        <div class="panel-body">
                            <form
                                action="{{ route('admin::postEditUserProfile') }}"
                                method="post"
                                class="form-horizontal gutter-5 form-ajax"
                                data-clear="false"
                            >
                                {{ csrf_field() }}

                                <input type="hidden" name="id" value="{{ $subject->id }}">
                                <input type="hidden" name="birth_day" value="{{ old('birth_day', $subject->birth_day) }}" id="birthDay">

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Username <span class="text-primary asterisk">*</span></label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <input
                                            type="text"
                                            name="username"
                                            value="{{ old('username', $subject->username) }}"
                                            class="form-control"
                                            placeholder=""
                                        >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Email <span class="text-primary asterisk">*</span></label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <input
                                            type="text"
                                            name="email"
                                            value="{{ old('email', $subject->email) }}"
                                            class="form-control"
                                            placeholder=""
                                        >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">First Name</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <input
                                            type="text"
                                            name="first_name"
                                            value="{{ old('first_name', $subject->first_name) }}"
                                            class="form-control"
                                            placeholder=""
                                        >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Last Name</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <input
                                            type="text"
                                            name="last_name"
                                            value="{{ old('last_name', $subject->last_name) }}"
                                            class="form-control"
                                            placeholder=""
                                        >
                                    </div>
                                </div>                    
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Gender</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <select name="gender" class="form-control chosen-select" data-placeholder="Select Gender">
                                            <option></option>
                                            <option
                                                value="Male"
                                                {{ old('gender', $subject->gender) == 'Male' ? 'selected' : '' }}
                                            >Male</option>
                                            <option
                                                value="Female"
                                                {{ old('gender', $subject->gender) == 'Female' ? 'selected' : '' }}
                                            >Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Date Of Birthday</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12 gutter-5">
                                        <div class="row birthday-cont">
                                            <div class="col-md-3 col-sm-3 col-xs-3">
                                                <select
                                                    name="birth_day_temp"
                                                    class="form-control chosen-select date-select"
                                                    data-type="birth-day"
                                                    data-prefix="birth"
                                                    data-hidden-element="birthDay"
                                                    data-placeholder="Day"
                                                >
                                                    <option></option>
                                                    @for ($i = 1; $i <= 31; $i++)
                                                        <option 
                                                            value="{{ sprintf('%02d', $i) }}"
                                                            {{ sprintf('%02d', $i) == old('birth_day_temp', !is_null($subject->birth_day) ? date('d', strtotime($subject->birth_day)) : null) ? 'selected' : '' }}
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
                                                    data-placeholder="Month"
                                                >
                                                    <option></option>
                                                    @foreach (cal_info(0)['months'] as $month_key => $month)
                                                        <option
                                                            value="{{ sprintf('%02d', $month_key) }}"
                                                            {{ old('birth_month_temp', !is_null($subject->birth_day) ? date('m', strtotime($subject->birth_day)) : null) == sprintf('%02d', $month_key) ? 'selected' : '' }}
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
                                                    data-placeholder="Year"
                                                    
                                                >
                                                    <option></option>
                                                    @foreach (years() as $year)
                                                        <option
                                                            value="{{ $year }}"
                                                            {{ $year == old('birth_year_temp', !is_null($subject->birth_day) ? date('Y', strtotime($subject->birth_day)) : null) ? 'selected' : '' }}
                                                        >{{ $year }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Country <span class="text-primary asterisk">*</span></label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <select name="country_code" class="form-control chosen-select" data-placeholder="Select Country">
                                            <option></option>
                                            @foreach (countries() as $country)
                                                <option
                                                    value="{{ $country->code }}"
                                                    {{ $country->code == old('country_code', $subject->country_code) ? 'selected' : '' }}
                                                >{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3 col-sm-offset-3">
                                        <button
                                            type="submit"
                                            class="btn btn-primary"
                                            data-loading-text="{{ button_loading('Saving...') }}"
                                        >Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">Roles</h4>
                        </div>
                        <div class="panel-body">
                            <div class="checkbox no-margin-top">
                                <label>
                                    <input type="checkbox" name="user" value="0" checked disabled>
                                    User
                                </label>
                            </div>
                            @foreach ($roles as $role)
                                <div class="checkbox">
                                    <label>
                                        <input
                                            type="checkbox"
                                            name="user"
                                            value="{{ $role->id }}"
                                            class="checkbox-ajax"
                                            data-ajax-data='{"user_id": {{ $subject->id }}, "role_id": {{ $role->id }}, "remove": true}'
                                            data-url="{{ route('admin::postEditUserRole') }}"
                                            {{ $subject->hasRole($role->name) ? 'checked' : false }}
                                        >
                                        {{ $role->label }} <i class="fa fa-spinner fa-pulse hidden"></i>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">Change Password</h4>
                        </div>
                        <div class="panel-body">
                            <form
                                action="{{ route('admin::postChangeUserPassword') }}"
                                method="post"
                                class="form-horizontal guttter-5 form-ajax"
                            >
                                {{ csrf_field() }}
                                
                                <input type="hidden" name="id" value="{{ $subject->id }}">
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12">New Password</label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <input
                                            type="password"
                                            name="password"
                                            value="{{ old('password') }}"
                                            class="form-control"
                                            placeholder=""
                                        >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-4 col-sm-offset-4">
                                        <button
                                            type="submit"
                                            class="btn btn-primary"
                                            data-loading-text="{{ button_loading('Saving...') }}"
                                        >Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop