@extends('layouts.master')

@section('title', 'Settings')
@section('description', 'Settings')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h2 class="Content__Heading"><span>Change Password</span></h2>
                <form
                    action="{{ route('account::postChangePassword') }}"
                    class="form-horizontal gutter-5 form-ajax"
                >
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="control-label col-md-4">Current Password</label>
                        <div class="col-md-7">
                            <input type="password" name="current_password" value="{{ old('current_password') }}" class="form-control" placeholder="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">New Password</label>
                        <div class="col-md-7">
                            <input type="password" name="new_password" value="{{ old('new_password') }}" class="form-control" placeholder="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Confirm New Password</label>
                        <div class="col-md-7">
                            <input type="password" name="new_password_confirmation" value="{{ old('new_password_confirmation') }}" class="form-control" placeholder="">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-7 col-md-offset-4">
                            <button
                                type="submit"
                                class="btn btn-primary"
                                data-loading-text="{!! button_loading('Saving...') !!}"
                            >Change Password</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop