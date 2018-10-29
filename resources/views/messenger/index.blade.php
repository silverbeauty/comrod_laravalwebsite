@extends('layouts.master')

@section('title', trans('message.messages'))
@section('description', trans('message.messages'))

@section('underscore')
    @include('underscore.message_reply')
@stop

@section('content')
    <div class="container main-container messenger-container">
        <div class="row messenger">            
            @include('partials.messenger_sidebar')
            @include('partials.message_replies', ['thread' => $latest_thread])
        </div>
    </div>
@stop
