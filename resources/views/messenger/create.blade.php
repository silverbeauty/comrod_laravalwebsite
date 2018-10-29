@extends('layouts.master')

@section('title', trans('message.new_message'))
@section('description', trans('message.new_message'))

@section('content')
    <div class="container main-container">
        <div class="row messenger">
            @include('partials.messenger_sidebar')
            <div class="col-md-8 col-sm-12 col-xs-12">
                <div class="panel panel-default messages" id="messages-pjax-container">
                    <div class="panel-heading">
                        <h4 class="panel-title">{{ trans('message.new_message') }}</h4>
                    </div>
                    <form
                        action="{{ route('messages::store') }}"
                        method="post"
                        class="form-ajax"
                    >
                        {{ csrf_field() }}
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td class="v-middle text-right no-border" width="50">To:</td>
                                    <td class="no-border">
                                        <div class="Autocomplete">
                                            <i class="fa fa-spinner fa-pulse loader hidden"></i>
                                            <input
                                                type="text"
                                                name="recipients"
                                                value="{{ old('recipients') }}"
                                                class="form-control"                                
                                                data='{}'
                                                data-url="{{ route('api::getAutocompleteUsers') }}"
                                                data-custom-response="user_search"
                                                data-multiple="true"
                                                placeholder="{{ trans('message.name') }}"
                                            >
                                            <div class="autocomplete-results"></div>                                
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="v-middle text-right" width="50">{{ trans('message.subject') }}:</td>
                                    <td>
                                        <input
                                            type="text"
                                            name="subject"
                                            value="{{ old('subject') }}"
                                            class="form-control"                                
                                            placeholder=""
                                        >                                        
                                    </td>
                                </tr>
                            </tbody>
                        </table>                        
                        <div class="panel-footer">                        
                            <div class="form-group">
                                <textarea name="body" class="form-control" rows="3" placeholder="{{ trans('message.write_message') }}"></textarea>
                            </div>
                            <div class="form-group clearfix">
                                <button
                                    type="submit"
                                    class="btn btn-primary pull-right"
                                    data-loading-text="{!! button_loading(trans('message.sending')) !!}"
                                >{{ trans('message.send') }}</button>
                            </div>                        
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
