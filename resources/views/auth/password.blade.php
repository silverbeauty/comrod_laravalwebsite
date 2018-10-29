@extends('layouts.master')

@section('content')
    <div class="container">
        <h1 class="Content__Heading"><span>Forgotten your password?</span></h1>
        <div class="row">
            <div class="col-md-6">                
                @include('partials.errors')

                <form action="{{ route('auth::postPasswordEmail') }}" method="post" class="form-ajax">
                    {!! csrf_field() !!}

                    <div class="form-group">
                        <label>Enter your email address</label>
                        <input
                            type="text"
                            name="email"
                            id="email"
                            class="form-control"
                            value="{{ old('email') }}"                            
                        >
                        <p class="help-block">Type in the email address you used when you registered with {{ trans('app.site_name') }}. Then we'll email a reset link to this address.</p>
                        
                    </div>                            
                    <button
                        type="submit"
                        class="btn btn-primary"
                        data-loading-text="{!! button_loading('Sending...') !!}"
                        >Send me the reset link</button>
                </form>     
            </div>           
        </div>
    </div>
@endsection