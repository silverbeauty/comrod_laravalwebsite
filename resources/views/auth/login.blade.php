@extends('layouts.master')

@section('title', 'Login')
@section('description', 'Login')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h2 class="Content__Heading text-center"><span>{{ trans('login.login') }}</span></h2><br>
                @include('partials.login_form')
            </div>
        </div>
    </div>
@stop