<div class="modal fade" id="suggestLocationModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-left">{{ trans('video.correct_location') }}</h4>        
            </div>
            <form
                action="{{ route('api::postSuggestLocation') }}"
                method="post"
                class="form-ajax"
                data-clear="false"
            >
                <input type="hidden" name="content_id" value="{{ $content->id }}">
                <div class="modal-body">
                    <div class="form-group text-left">
                        {{ trans('video.correct_location_sentence') }}
                    </div>
                    <div class="form-group">
                        <div id="wrong-location-map" style="height:300px;"></div>
                        <p class="help-block text-left">{{ trans('video.drag-marker-to-change-location') }}</p>
                    </div>
                    <div class="form-group text-left">
                        <label>{{ trans('video.country') }} <span class="text-primary asterisk">*</span></label>
                        <select
                            name="country_code"
                            class="chosen-select country"
                            data-placeholder="{{ trans('video.select-country') }}"
                            data-countries-need-state="{{ json_encode(config('app.countries_need_state')) }}"
                            data-get-regions-by-country-url="{{ route('api::getRegionsByCountry') }}"
                            data-region-parent="#suggest-location-region-parent"
                            data-city-parent="#suggest-location-city-parent"
                            data-clear-city="false"
                        >
                            <option></option>
                            @foreach (countries() as $country)
                                <option
                                    value="{{ $country->code }}"
                                    {{ $country->code == $content->country_code ? 'selected' : '' }}
                                >{{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div id="suggest-location-region-parent" class="text-left form-group {{ !need_region($content->country_code) ? 'hidden' : '' }}">
                        <label>{{ trans('video.state') }} <span class="text-primary asterisk">*</span></label>
                        <select name="region_code" class="chosen-select" data-placeholder="{{ trans('video.select_state') }}">
                            <option></option>
                            @foreach (regions_by_country($content->country_code) as $region)
                                <option
                                    value="{{ $region->code }}"
                                    {{ $region->code == $content->region_code ? 'selected' : '' }}
                                >{{ $region->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div id="suggest-location-city-parent" class="text-left form-group">
                        <label>{{ trans('video.city') }} <span class="text-primary asterisk">*</span></label>
                        <div class="Autocomplete">
                            <i class="fa fa-spinner fa-pulse loader hidden"></i>
                            <input
                                type="text"
                                name="city_name"
                                value="{{ $content->city_name }}"
                                class="form-control"                                
                                data='{"country_code": "country_code", "region_code": "region_code"}'
                                data-url="{{ route('api::getSearchCityByCountry') }}"
                            >
                            <div class="autocomplete-results"></div>                                
                        </div>
                    </div>
                    <div class="form-group text-left">
                        <label>{{ trans('video.latitude') }}</label>
                        <input type="text" name="latitude" value="{{ $content->latitude }}" placeholder="" class="form-control">
                    </div>
                    <div class="form-group text-left">
                        <label>{{ trans('video.longitude') }}</label>
                        <input type="text" name="longitude" value="{{ $content->longitude }}" placeholder="" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-default"
                        data-dismiss="modal"
                        data-loading-text="{{ trans('app.cancel') }}"
                    >{{ trans('app.cancel') }}</button>
                    <button
                        type="submit"
                        class="btn btn-primary"
                        data-loading-text="{!! button_loading(trans('video.submitting')) !!}"
                    >{{ trans('video.submit') }}</button>
                </div>
            </form>           
        </div>
    </div>
</div>