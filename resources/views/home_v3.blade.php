@extends('layouts.master')

@section('external_js')
    @include('underscore.no_map_templates')
@endsection

@section('underscore')
@stop

@section('modals')
    @include('modals.home_page_categories')
@stop

@section('title', 'Comroads')
@section('description', 'Comroads')
@section('body_class', 'home v3')

@section('content')
    <div class="container-fluid center-block" style="max-width:1350px;">
        <div class="gutter-5">
            <div class="row">
              <center><a href="/upload/video"><img class="img-fluid" src="/images/{{ trans('home.uploadnow') }}" style="max-width: 85%"/></a></center>
            
            </div>
            <div class="row form-group">
                {{--<div class="col-sm-4 col-md-3 col-lg-3 margin-bottom-10">
                    <p class="checkbox text-left">
                        <label>
                            <input type="checkbox" name="hide_watched" {{ $hide_watched && $signed_in ? 'checked' : '' }}>
                            {{ trans('home.dont-show-already-watched') }}
                        </label>
                    </p>
                </div>--}}
                <div class="col-xs-6">
                    <div class="padding-right-10 margin-top-15">
                        <div class="form-group has-feedback">
                            <input type="text" class="form-control input-sm" placeholder="{{ trans('app.search') }}" id="search-input">
                            <span class="fa fa-search form-control-feedback" aria-hidden="true"></span>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6 text-right">
                    <a href="{{ route('switchLayout', ['version' => 'v2']) }}">
                        <img src="{{ asset_cdn('images/show_map_icon.png') }}" width="72"><br>
                        {{ trans('app.show_map') }}
                    </a>
                </div>
            </div>
            <h2 class="Content__Heading no-line">
                <div class="row">
                    <div class="col-md-6 sorting-menu">
                        <span class="dropdown no-padding">
                            {{ trans('home.sort-by') }}:
                            <a
                                data-toggle="dropdown"
                                class="text-default"
                            >
                                <b
                                    id="sorting-label"
                                    data-key="{{ $sort_key }}"
                                >{{ $filter_menu['sorting'][$sort_key]['label'] }}</b></a>
                                <a data-toggle="dropdown"><i class="fa fa-chevron-circle-down text-primary"></i></a>
                            <ul class="dropdown-menu pull-right">
                                @foreach ($filter_menu['sorting'] as $key => $sort)
                                    <li class="{{ $key == $sort_key ? 'hidden' : '' }}">
                                        <a
                                            class="content-sorting"
                                            data-sorting-type="{{ $sort['alt_key'] }}"
                                            data-target-label="#sorting-label"
                                            data-label="{{ $sort['label'] }}"
                                            data-key="{{ $key }}"
                                        >{{ $sort['label'] }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span class="dropdown no-padding">
                            {{ trans('home.show-from') }}:
                            <a
                                data-toggle="dropdown"
                                class="text-default"
                            >
                                <b
                                    id="show-from-filter-label"
                                    data-key="{{ $show_from_filter_key }}"
                                >{{ $filter_menu['filters'][$show_from_filter_key]['alt_label'] }}</b></a>
                                <a data-toggle="dropdown">
                                    <i class="fa fa-chevron-circle-down text-primary"></i>
                                </a>
                            <ul class="dropdown-menu pull-right">
                                @foreach ($filter_menu['filters'] as $key => $filter)
                                    <li class="{{ $key == $show_from_filter_key ? 'hidden' : '' }}">
                                        <a
                                            href="{{ $filter['url'] }}"
                                            class="show-from-filter"
                                            data-target-label="#show-from-filter-label"
                                            data-label="{{ $filter['alt_label'] }}"
                                            data-filter-type="{{ $key }}"
                                            data-key="{{ $key }}"
                                        >{{ $filter['label'] }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span class="dropdown no-padding">
                            <a
                                class="text-default"
                                data-toggle="modal"
                                data-target="#homePageCategoriesModal"
                            >
                                {{ trans('home.categories') }}</a>
                            <a
                                data-toggle="modal"
                                data-target="#homePageCategoriesModal"
                            >
                                <i class="fa fa-chevron-circle-down text-primary"></i>
                            </a>
                        </span>
                    </div>
                    <div class="col-md-6 clearfix country-menu">
                        <span class="dropdown no-padding padding-left-5 country-dropdown-span">
                            <b>{{ trans('home.jump-to-country') }}:</b>&nbsp;
                            @if ($country_code == 'worldwide')
                                <i class="fa fa-globe fa-lg" id="country-filter-flag-selected"></i>
                            @else
                                <i class="fs14 flag-icon flag-icon-{{ strtolower($country_code) }}" id="country-filter-flag-selected"></i>
                            @endif
                            <a data-toggle="dropdown" class="text-default">
                                <span
                                    class="country-name-span no-padding"
                                    id="country-filter-selected"
                                    data-key="{{ strtolower($country_code) }}"
                                >{{ $country_name }}</span></a>&nbsp;
                            <a data-toggle="dropdown"><i class="fa fa-chevron-circle-down text-primary"></i></a>
                            <ul class="dropdown-menu pull-right">
                                <li class="{{ $country_code == 'worldwide' ? 'hidden' : '' }}">
                                    <a
                                        href="{{ route('home', ['geo' => strtolower('worldwide')]) }}"
                                        class="country-map-trigger"
                                        data-country-name="{{ trans('app.worldwide') }}"
                                        data-country-code="worldwide"
                                        data-target-label="#country-filter-selected"
                                        data-label="{{ trans('app.worldwide') }}"
                                        data-key="{{ strtolower('worldwide') }}"
                                        data-icon-class="fa fa-globe fa-lg"
                                        data-target-flag="#country-filter-flag-selected"
                                    >
                                        @if (is_rtl())
                                            {{ trans('app.worldwide') }}
                                            <i class="fa fa-globe fa-lg"></i>
                                        @else
                                            <i class="fa fa-globe fa-lg"></i>
                                            {{ trans('app.worldwide') }}
                                        @endif
                                    </a>
                                </li>
                                @foreach (countries_with_videos() as $key => $country)
                                    <li class="{{ $country->code == $country_code ? 'hidden' : '' }}">
                                        <a
                                            href="{{ route('home', ['geo' => strtolower($country->code)]) }}"
                                            class="country-map-trigger"
                                            data-country-name="{{ $country->name }}"
                                            data-country-code="{{ $country->code }}"
                                            data-target-label="#country-filter-selected"
                                            data-label="{{ $country->name }}"
                                            data-key="{{ strtolower($country->code) }}"
                                            data-icon-class="fs14 flag-icon flag-icon-{{ strtolower($country->code) }}"
                                            data-target-flag="#country-filter-flag-selected"
                                        >

                                            @if (is_rtl())
                                                {{ $country->name }}
                                                <i class="flag-icon flag-icon-{{ strtolower($country->code) }}"></i>
                                            @else
                                                <i class="flag-icon flag-icon-{{ strtolower($country->code) }}"></i>
                                                {{ $country->name }}
                                            @endif
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </span>
                    </div>
                </div>
            </h2>
        </div>
        @include('partials.carousel_v3', ['contents' => $main_contents])
    </div>
@endsection
