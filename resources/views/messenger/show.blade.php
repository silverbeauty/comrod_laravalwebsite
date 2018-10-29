@extends('layouts.master')

@section('title', 'New Message')
@section('description', 'New Message')

@section('underscore')
    @include('underscore.message_reply')
@stop

@section('content')
    <div class="container main-container">
        <div class="row messenger">
            @include('partials.messenger_sidebar')
            @include('partials.message_replies')
        </div>
    </div>
@stop
