<script type="text/template" id="addLicenseFormTemplate">
    <div class="gutter-5 removable">
        <div class="form-group no-margin padding-bottom-5">
            <div class="col-md-12 col-sm-12 col-xs-12 text-right">
                <i class="fa fa-times-circle text-danger"></i>
                <a
                    class="text-default remove-element"
                    data-counter="#license-plate-counter"
                >{{ trans('video.remove') }}</a>
            </div>
        </div>
        <div class="form-group align-middle">
            <label class="col-md-3 col-sm-3 col-xs-12">{{ trans('video.license-plate') }}</label>
            <div class="col-md-9 col-sm-9 col-xs-12">                
                <div class="Autocomplete">
                    <i class="fa fa-spinner fa-pulse loader hidden"></i>
                    <input
                        type="text"
                        name="licenses[<%- rc.id %>][name]"
                        value=""
                        class="form-control"                                
                        data='{}'
                        data-url="{{ route('api::getSearchLicensePlate') }}"
                    >
                    <div class="autocomplete-results"></div>                                
                </div>
            </div>
        </div>
        <div class="form-group align-middle">
            <label class="col-md-3 col-sm-3 col-xs-12">{{ trans('video.country') }}</label>
            <div class="col-md-9 col-sm-9 col-xs-12">
                <select
                    class="form-control chosen-select country"
                    name="licenses[<%- rc.id %>][country_code]"
                    data-placeholder="{{ trans('video.select-country') }}..."
                    data-countries-need-state="{{ json_encode(config('app.countries_need_state')) }}"
                    data-get-regions-by-country-url="{{ route('api::getRegionsByCountry') }}"
                    data-region-parent="#license-region-parent-<%- rc.id %>" 
                >
                    <option></option>
                    @foreach ($countries as $country)
                        <option
                            value="{{ $country->code }}"
                            {{ $default_country_code == $country->code ? 'selected' : '' }}
                        >{{ $country->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div id="license-region-parent-<%- rc.id %>" class="form-group align-middle {{ !need_region($default_country_code) ? 'hidden' : '' }}">
            <label class="col-md-3 col-sm-3 col-xs-12">{{ trans('video.state') }}</label>
            <div class="col-md-9 col-sm-9 col-xs-12">
                <select name="licenses[<%- rc.id %>][region_code]" class="chosen-select" data-placeholder="{{ trans('video.select') }}...">
                    <option></option>
                    @foreach (regions_by_country($default_country_code) as $region)
                        <option
                            value="{{ $region->code }}"                            
                        >{{ $region->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group align-middle">
            <label class="col-md-3 col-sm-3 col-xs-12">{{ trans('video.vehicle-type') }}</label>
            <div class="col-md-9 col-sm-9 col-xs-12">
                <select class="form-control chosen-select" name="licenses[<%- rc.id %>][type_id]" data-placeholder="{{ trans('video.select-vehicle-type') }}...">
                    <option></option>
                    @foreach ($vehicle_types as $v_type)
                        <option
                            value="{{ $v_type->id }}"
                        >{{ $v_type->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group align-middle">
            <label class="col-md-3 col-sm-3 col-xs-12">{{ trans('video.make') }}</label>
            <div class="col-md-9 col-sm-9 col-xs-12">                                
                <select
                    class="form-control chosen-select"
                    name="licenses[<%- rc.id %>][make_id]"
                    data-placeholder="{{ trans('video.select-vehicle-make') }}..."
                    data-live-search="true"
                    data-url="{{ route('api::getVehicleMakeModels') }}"
                    data-target="#vehicle-model-<%- rc.id %>"
                    data-dependency='{"make_id": "#vehicle-make-<%- rc.id %>"}'
                    data-target-options='{"value": "id", "label": "name"}'
                    id="vehicle-make-<%- rc.id %>"
                    >
                    <option></option>
                    @foreach ($vehicle_makes as $v_make)
                        <option
                            value="{{ $v_make->id }}"
                        >{{ $v_make->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group align-middle">
            <label class="col-md-3 col-sm-3 col-xs-12">{{ trans('video.model') }}</label>
            <div class="col-md-9 col-sm-9 col-xs-12">
                <select
                    class="form-control chosen-select"
                    name="licenses[<%- rc.id %>][model_id]"
                    data-placeholder="{{ trans('video.select-vehicle-model') }}..."
                    id="vehicle-model-<%- rc.id %>"
                >
                    <option></option>                    
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 col-sm-3 col-xs-12">{{ trans('video.color') }}</label>
            <div class="col-md-9 col-sm-9 col-xs-12">
                <select class="form-control chosen-select" name="licenses[<%- rc.id %>][color_id]" data-placeholder="{{ trans('video.select-color') }}...">
                    <option></option>
                    @foreach ($vehicle_colors as $v_color)
                        <option
                            value="{{ $v_color->id }}"
                        >{{ $v_color->name }}</option>
                    @endforeach
                </select>                            
            </div>
        </div>
    </div>
</script>