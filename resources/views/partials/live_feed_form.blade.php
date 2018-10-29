<div class="col-md-8">
    <form
        action="{{ $action_url }}"
        method="post"
        class="form-horizontal gutter-5 form-ajax Upload__Content"
        data-no-location-confirm-title="{{ trans('video.data-no-location-confirm-title') }}"
        data-no-location-confirm-body="{{ trans('video.data-no-location-confirm-body') }}"
        data-no-location-confirm-button-text="{{ trans('video.data-no-location-confirm-button-text') }}"
        data-clear="false"
    >
        {{ csrf_field() }}
        
        <input type="hidden" name="id" value="{{ old('id', $feed->id) }}">

        <div class="form-group">
            <label class="col-md-3">Title</label>
            <div class="col-md-9">
                <input type="text" name="title" value="{{ old('title', $feed->title) }}" placeholder="" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3">Content URL</label>
            <div class="col-md-9">
                <input type="text" name="content_url" value="{{ old('content_url', $feed->content_url) }}" placeholder="" class="form-control">
                <div class="radio-inline">
                    <label>
                        <input
                            type="radio"
                            name="type"
                            value="video"
                            {{ $feed->type == 'video' ? 'checked' : null }}
                        >
                        Video
                    </label>
                </div>
                <div class="radio-inline">
                    <label>
                        <input
                            type="radio"
                            name="type"
                            value="photo"
                            {{ $feed->type == 'photo' ? 'checked' : null }}
                        >
                        Photo
                    </label>
                </div>
                <div class="radio-inline">
                    <label>
                        <input
                            type="radio"
                            name="type"
                            value="embed"
                            {{ $feed->type == 'embed' ? 'checked' : null }}
                        >
                        Embed
                    </label>
                </div>
                <div class="radio-inline">
                    <label>
                        <input
                            type="radio"
                            name="type"
                            value="stream"
                            {{ $feed->type == 'stream' ? 'checked' : null }}
                        >
                        Stream
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3">Thumb URL</label>
            <div class="col-md-9">
                <input type="text" name="thumb_url" value="{{ old('thumb_url', $feed->thumb_url) }}" placeholder="" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3">Refresh in seconds</label>
            <div class="col-md-9">
                <input type="text" name="refresh_in_seconds" value="{{ old('refresh_in_seconds', $feed->refresh_in_seconds) }}" placeholder="" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <input id="pac-input" class="form-control disable-enter-key hidden" type="text" placeholder="Search Google Maps">
            <div id="map" style="height: 300px;"></div>
            <p class="help-block">Drag marker to change location</p>
        </div>
        <div class="form-group align-middle">
            <label class="col-md-3 col-sm-3 col-xs-12">{{ trans('video.country') }}</label>
            <div class="col-md-9 col-sm-9 col-xs-12">
                <select
                    class="form-control chosen-select country"
                    name="country_code"
                    data-placeholder="{{ trans('video.select-country') }}..."
                    data-countries-need-state="{{ json_encode(config('app.countries_need_state')) }}"
                    data-get-regions-by-country-url="{{ route('api::getRegionsByCountry') }}"
                    data-region-parent="#region-parent"
                    data-city-parent="#city-parent"
                    data-init-map="true"
                >
                    <option></option>
                    @foreach (countries() as $country)
                        <option
                            value="{{ $country->code }}"
                            {{ old('country_code', $feed->country_code) == $country->code ? 'selected' : '' }}
                        >{{ $country->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div id="region-parent" class="form-group align-middle {{ !need_region(old('country_code', $feed->country_code)) ? 'hidden' : '' }}">
            <label class="col-md-3 col-sm-3 col-xs-12">{{ trans('video.state') }}</label>
            <div class="col-md-9 col-sm-9 col-xs-12">
                <select name="region_code" class="chosen-select form-control init-map" data-placeholder="{{ trans('video.select') }}...">
                    <option></option>
                    @foreach (regions_by_country(old('country_code', $feed->country_code)) as $region)
                        <option
                            value="{{ $region->code }}"
                            {{ $region->code == old('region_code', $feed->region_code) ? 'selected' : '' }}
                        >{{ $region->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div id="city-parent" class="form-group align-middle">
            <label class="col-md-3 col-sm-3 col-xs-12">{{ trans('video.city') }}</label>
            <div class="col-md-9 col-sm-9 col-xs-12">
                <div class="Autocomplete">
                    <i class="fa fa-spinner fa-pulse loader hidden"></i>
                    <input
                        type="text"
                        name="city_name"
                        value="{{ old('city_name', $feed->city_name) }}"
                        class="form-control init-map"                                
                        data='{"country_code": "country_code", "region_code": "region_code"}'
                        data-url="{{ route('api::getSearchCityByCountry') }}"                
                        autocomplete="off"
                    >
                    <div class="autocomplete-results"></div>                                
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3">Latitude</label>
            <div class="col-md-9">
                <input type="text" name="latitude" value="{{ old('latitude', $feed->latitude) }}" placeholder="" class="form-control">
            </div>
        </div>                
        <div class="form-group">
            <label class="col-md-3">Longitude</label>
            <div class="col-md-9">
                <input type="text" name="longitude" value="{{ old('longitude', $feed->longitude) }}" placeholder="" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-9 col-md-offset-3">
                <button
                    type="submit"
                    class="btn btn-primary"
                    data-loading-text="{!! button_loading($submit_button_loading_text) !!}"
                >{{ $submit_button_text }}</button>
            </div>
        </div>
    </form>
</div>