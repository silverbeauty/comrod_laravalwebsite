@extends('layouts.master')

@section('content')
    <div class="container">
        <h1 class="Content__Heading"><span>Reset Password</span></h1>
        <div class="row">
            <div class="col-md-6">                
                <form action="{{ route('auth::postPasswordReset') }}" method="post">                                                
                    @include('partials.errors')
                    
                    {!! csrf_field() !!}
                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="email" value="{{ $email }}">
                    
                    <div class="form-group">
                        <label>{{ trans('auth.new_password') }}</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="">
                    </div>
                    <div class="form-group">
                        <label>{{ trans('auth.confirm_new_password') }}</label>
                        <input type="password" name="password_confirmation" id="passwordConfirmation" class="form-control" placeholder="">
                    </div>                           
                    <button
                        type="submit"
                        class="btn btn-primary"
                    >Reset Password</button>
                </form>
            </div>
        </div>
    </div>
@endsection