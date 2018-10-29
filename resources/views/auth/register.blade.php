@extends('layouts.master')

@section('title', 'Signup')
@section('description', 'Signup')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h2 class="Content__Heading"><span>{{ trans('login.create_free_account') }}</span></h2><br>
                @include('partials.signup_form')
            </div>
        </div>
    </div>
@stop