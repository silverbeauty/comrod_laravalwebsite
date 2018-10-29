<form
    action="{{ route('api::postEditContent') }}"
    method="post"
    class="form-horizontal gutter-5 form-ajax"
    data-no-location-confirm-title="{{ trans('video.data-no-location-confirm-title') }}"
    data-no-location-confirm-body="{{ trans('video.data-no-location-confirm-body') }}"
    data-no-location-confirm-button-text="{{ trans('video.data-no-location-confirm-button-text') }}"
    data-no-date-confirm-title="{{ trans('video.data-no-date-confirm-title') }}"
    data-no-date-confirm-body="{{ trans('video.data-no-date-confirm-body') }}"
    data-no-date-confirm-button-text="{{ trans('video.data-no-date-confirm-button-text') }}"
    data-clear="false"
>
    {{ csrf_field() }}

    <input type="hidden" name="id" value="{{ $content->id }}">
    <input type="hidden" name="type" value="{{ $content->type }}">
    <input type="hidden" name="embed_type" value="{{ $content->embed_type }}">
    <div id="dz-photo-preview-template" class="hidden">
        <div class="col-sm-3 dz-preview dz-file-preview">
            <div class="alert alert-danger hidden"><span data-dz-errormessage></span></div>
            <div class="dz-details">
                {{-- <div class="dz-filename"><span data-dz-name></span> (<span data-dz-size></span>)</div> --}}
                <img class="img-responsive" data-dz-thumbnail />
            </div>
            <div class="dz-progress progress">
                <div
                    class="progress-bar"
                    role="progressbar"
                    aria-valuenow="60"
                    aria-valuemin="0"
                    aria-valuemax="100"
                    data-dz-uploadprogress
                >
                    <span class="upload-photo-progress-counter"></span>
                </div>
            </div>
            <div class="dz-success-mark">
                <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                  <!-- Generator: Sketch 3.2.1 (9971) - http://www.bohemiancoding.com/sketch -->
                  <title>Check</title>
                  <desc>Created with Sketch.</desc>
                  <defs></defs>
                  <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                      <path d="M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" stroke-opacity="0.198794158" stroke="#747474" fill-opacity="0.816519475" fill="#FFFFFF" sketch:type="MSShapeGroup"></path>
                  </g>
                </svg>
            </div>
            <div class="dz-error-mark">
                <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                    <!-- Generator: Sketch 3.2.1 (9971) - http://www.bohemiancoding.com/sketch -->
                    <title>error</title>
                    <desc>Created with Sketch.</desc>
                    <defs></defs>
                    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                        <g id="Check-+-Oval-2" sketch:type="MSLayerGroup" stroke="#747474" stroke-opacity="0.198794158" fill="#FFFFFF" fill-opacity="0.816519475">
                            <path d="M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" sketch:type="MSShapeGroup"></path>
                        </g>
                    </g>
                </svg>
              </div>
        </div>
    </div>
    <div class="form-group align-middle">
        <label class="col-md-3">{{ ucfirst($translated_type) }}<span class="text-danger asterisk">*</span></label>
        <div class="col-md-9 col-sm-9 col-xs-12">
            @if ($content->type == 'video')
                <div class="change-video-hidable collapse in">
                    <div class="embed-responsive embed-responsive-16by9">
                        @if ($content->embed_type == 'youtube')
                            <iframe                                    
                                src="https://www.youtube.com/embed/{{ $content->embed_id }}?{{ $content->start_in_seconds ? 'start='.$content->start_in_seconds.'&' : '' }}autoplay=0&rel=0&modestbranding=1"
                                frameborder="0"
                                allowfullscreen
                            ></iframe>
                        @elseif ($content->embed_type == 'vidme')
                            <iframe
                                src="{{ $content->vidme_embed_url }}"
                                frameborder="0"
                                allowfullscreen
                                webkitallowfullscreen
                                mozallowfullscreen
                                scrolling="no"
                            ></iframe>
                        @else
                            @if (empty($content->embed))
                                @if (is_null($content->encoded_date))
                                    <div class="encoding">{{ trans('app.video_is_being_process') }}</div>
                                @else
                                    <div class="flow-player" data-swf="{{ asset('flowplayer.swf') }}" data-key="$108835620266723">
                                        <video poster="{{ $content->video_poster_url }}">
                                            <source type="video/mp4" src="{{ $content->video_default_url }}">                                
                                        </video>
                                   </div>
                               @endif
                           @else
                                {!! $content->embed !!}
                           @endif
                       @endif
                    </div>
                    <p class="help-block text-right">
                        <a
                            class="text-default"
                            data-toggle="collapse"
                            data-target=".change-video-hidable"
                        >{{ trans('app.change_video') }}</a>
                        <i class="fa fa-chevron-circle-down text-primary"></i>
                    </p>
                </div>
                <div class="change-video-hidable collapse">
                    <div id="dz-video-preview-template" class="hidden">
                        <div class="dz-preview dz-file-preview">
                            <div class="alert alert-danger hidden"><span data-dz-errormessage></span></div>
                            <div class="dz-details">
                                <div class="dz-filename"><span data-dz-name></span> (<span data-dz-size></span>)</div>
                            </div>
                            <div class="gutter-5">
                                <div class="row">
                                    <div class="col-xs-11">
                                        <div class="progress">
                                            <span class="progress-bar" data-dz-uploadprogress></span>
                                        </div>
                                    </div>
                                    <div class="col-xs-1 upload-video-progress-counter"></div>
                                </div>
                            </div>
                            {{-- <div class="dz-success-mark"><span>✔</span></div>
                            <div class="dz-error-mark"><span>✘</span></div> --}}                                    
                        </div>
                    </div>
                    <div
                        class="dropzone dropzone-video-preview hidden"
                        data-template-id="#dropzoneUploadVideoTemplate"
                        data-add-type="insert_after"
                        data-add-target=".dropzone-video-preview .dz-details"
                    ></div>
                    <div class="dropzone-hidable">
                        <div class="dropzone dropzone-video dropzone-dropping-area">                                    
                        </div>
                        <div class="help-block no-margin-bottom clearfix">
                            <a
                                class="text-default pull-left collapse-trigger change-value"
                                data-toggle="collapse"
                                data-target=".change-video-hidable"
                                data-collapse-target=".dropzone-hidable"
                                data-target-input="input[name=embed_type]"
                                data-value="{{ $content->embed_type }}"
                            >{{ trans('app.cancel') }}</a>
                            <div class="pull-right">
                                <a
                                    data-toggle="dropdown"
                                    data-target="#"
                                    role="button"
                                    aria-haspopup="true"
                                    aria-expanded="false"
                                    class="text-default"
                                >{{ trans('app.or_embed_video') }}</a>
                                <i class="fa fa-chevron-circle-down text-primary"></i>
                                <ul
                                    class="dropdown-menu"
                                >
                                    <li>
                                        <a
                                            class="text-default collapse-trigger"
                                            data-toggle="collapse"
                                            data-target="#youtube-collapsable"
                                            data-collapse-target="#vidme-collapsable"
                                            data-target-input="input[name=embed_type]"
                                            data-value="youtube"
                                        >{{ trans('app.youtube') }}</a>
                                        <a
                                            class="text-default collapse-trigger"
                                            data-toggle="collapse"
                                            data-target="#vidme-collapsable"
                                            data-collapse-target="#youtube-collapsable"
                                            data-target-input="input[name=embed_type]"
                                            data-value="vidme"
                                        >{{ trans('app.vidme') }}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>                            
                </div>
            @else                
                <div class="gutter-5">
                    <div
                        class="dropzone dropzone-photo-preview row form-group"
                        data-template-id="#dropzoneUploadPhotoTemplate"
                        data-add-type="insert_after"
                        data-add-target=".dropzone-photo-preview .dz-details"
                    ></div>
                    <div class="dropzone dropzone-photo dropzone-dropping-area hidden"></div>
                </div>          
            @endif                            
        </div>
    </div>
    @if ($content->type == 'video')
        <div
            id="youtube-collapsable"
            class="form-group align-middle dropzone-hidable {{ $content->embed_type == 'youtube' ? 'collapse in change-video-hidable' : 'collapse' }}"
        >
            <label class="col-md-3 col-sm-3 col-xs-12">{{ trans('video.youtube-url') }}<span class="text-danger asterisk">*</span></label>
            <div class="col-md-9 col-sm-9 col-xs-12">
                <input type="text" name="youtube_url" value="{{ old('youtube_url', $content->youtube_url) }}" placeholder="" class="form-control">
            </div>
        </div>
        <div
            id="vidme-collapsable"
            class="form-group align-middle dropzone-hidable {{ $content->embed_type == 'vidme' ? 'collapse in change-video-hidable' : 'collapse' }}"
        >
            <label class="col-md-3 col-sm-3 col-xs-12">{{ trans('app.vidme_url') }}<span class="text-danger asterisk">*</span></label>
            <div class="col-md-9 col-sm-9 col-xs-12">
                <input type="text" name="vidme_url" value="{{ old('vidme_url', $content->vidme_url) }}" placeholder="" class="form-control">
            </div>
        </div>
        <div class="form-group align-middle">
            <label class="col-md-3 no-margin">Replace thumbnail image</label>
            <div class="col-md-9">
                <div class="gutter-5">
                    <div
                        class="dropzone dropzone-photo-preview row form-group hidden"
                        data-template-id="#dropzoneUploadPhotoTemplate"
                        data-add-type="insert_after"
                        data-add-target=".dropzone-photo-preview .dz-details"
                    ></div>
                    <div class="dropzone dropzone-video-thumbnail dropzone-dropping-area hidden"></div>
                </div>
            </div>
        </div>
        <div class="form-group align-middle">
            <label class="col-md-3 col-sm-3 col-xs-12 no-margin">{{ trans('video.start-video-playback-at-x-seconds') }}</label>
            <div class="col-md-9 col-sm-9 col-xs-12">
                <input type="text" name="start_in_seconds" value="{{ old('start_in_seconds', $content->start_in_seconds) }}" placeholder="" class="form-control">
            </div>
        </div>
    @endif
    
    <div class="form-group align-middle">
        <label class="col-md-3">{{ trans('video.title') }}<span class="text-danger asterisk">*</span></label>
        <div class="col-md-9">
            <input type="text" name="title" value="{{ old('title', $content->title) }}" placeholder="" class="form-control">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-3">{{ trans('video.description') }}</label>
        <div class="col-md-9">
            <textarea class="form-control" name="description" rows="5">{{ old('description', $content->description) }}</textarea>
        </div>
    </div>
    <h4 class="Content__Heading">
        <span>{{ ucfirst($translated_type) }} {{ trans('video.categories') }}</span>
        <span class="pull-right padding-left">
            <a
                data-toggle="collapse"
                data-target=".collapse.categories"
                data-collapse-text="{{ trans('video.add-categories') }}"
                data-in-text="{{ trans('video.hide-categories') }}"
                data-collapse-icon="fa-chevron-circle-down"
                data-in-icon="fa-chevron-circle-up"
                data-target-icon="#categories-collapse-icon"
                id="categories-collapse-trigger"
            >{{ count($categories) ? trans('video.hide-categories') : trans('video.add-categories') }}</a>
            <i
                id="categories-collapse-icon"
                class="fa {{ count($categories) ? 'fa-chevron-circle-up' : 'fa-chevron-circle-down' }} text-primary"
            ></i>
        </span>
    </h4>
    <div class="form-group collapse categories {{ count($categories) ? 'in' : '' }}" data-trigger="#categories-collapse-trigger">
        @if ($content->type == 'video')
        <div class="col-md-4">
            <h4 class="sub-heading">{{ trans('video.category') }}:</h4>            
            @foreach (categories(['type' => 1], 'category_categories') as $key => $category)                
                <div class="checkbox custom-checkbox">
                    <label
                        class="custom-checkbox {{ in_array_r($category->id, $categories) ? 'active' : '' }}"
                        data-category-id={{ $category->id }}
                    >
                        <table>
                            <tr>
                                <td class="v-top">
                                    <img src="{{ $category->icon_url }}">
                                </td>                                    
                                <td><span>{{ $category->name }}</span></td>
                            </tr>
                        </table>
                        <input
                            type="checkbox"
                            name="categories[]"
                            value="{{ $category->id }}"
                            class="hidden" 
                            {{ in_array_r($category->id, $categories) ? 'checked' : '' }}                           
                        >
                    </label>
                </div>                
            @endforeach
        </div>
        <div class="col-md-4">
            <h4 class="sub-heading">{{ trans('video.dangerous-behavior') }}:</h4>
            <?php
                $dangerous = categories(['type' => 2], 'dangerous_categories');
            ?>
            @foreach ($dangerous as $key => $category)                
                <div class="checkbox custom-checkbox">
                    <label
                        class="custom-checkbox {{ in_array_r($category->id, $categories) ? 'active' : '' }}"
                        data-category-id={{ $category->id }}
                    >
                        <table>
                            <tr>
                                <td class="v-top">
                                    <img src="{{ $category->icon_url }}">
                                </td>                                    
                                <td><span>{{ $category->name }}</span></td>
                            </tr>
                        </table>
                        <input
                            type="checkbox"
                            name="categories[]"
                            value="{{ $category->id }}"
                            class="hidden"
                            {{ in_array_r($category->id, $categories) ? 'checked' : '' }}                            
                        >
                    </label>
                </div>                
            @endforeach
        </div>
        <div class="col-md-4">
            <h4 class="sub-heading">{{ trans('video.traffic-violations') }}:</h4>
            <?php
                $traffic_violations = categories(['type' => 3], 'violation_categories');
            ?>
            @foreach ($traffic_violations as $key => $category)
                <div class="checkbox custom-checkbox">
                    <label
                        class="custom-checkbox {{ in_array_r($category->id, $categories) ? 'active' : '' }}"
                        data-category-id={{ $category->id }}
                    >
                        <table>
                            <tr>
                                <td class="v-top">
                                    <img src="{{ $category->icon_url }}">
                                </td>                                    
                                <td><span>{{ $category->name }}</span></td>
                            </tr>
                        </table>
                        <input
                            type="checkbox"
                            name="categories[]"
                            value="{{ $category->id }}"
                            class="hidden"
                            {{ in_array_r($category->id, $categories) ? 'checked' : '' }}                            
                        >
                    </label>
                </div>                
            @endforeach
        </div>
        @endif
        @if ($content->type == 'photo')
        <div class="col-md-12">
            @foreach (categories(['type' => 4], 'photo_categories') as $key => $category)                
                <label class="checkbox-inline custom-checkbox {{ in_array_r($category->id, $categories) ? 'active' : '' }}">
                    <table>
                        <tr>
                            <td class="v-top">
                                <img src="{{ $category->icon_url }}">
                            </td>                                    
                            <td><span>{{ $category->name }}</span></td>
                        </tr>
                    </table>
                    <input
                        type="checkbox"
                        name="categories[]"
                        value="{{ $category->id }}"
                        class="hidden"
                        {{ in_array_r($category->id, $categories) ? 'checked' : '' }}                           
                    >
                </label>                                
            @endforeach
        </div>
        @endif
    </div>
    {{-- @if ($content->type == 'video')
    <h4 class="Content__Heading text-right">
        <span>
            <a
                data-toggle="collapse"
                data-target=".collapse.categories"
                data-collapse-text="See more"
                data-in-text="See less"
                data-collapse-icon="fa-chevron-circle-down"
                data-in-icon="fa-chevron-circle-up"
                data-target-icon="#categories-collapse-icon"
                id="categories-collapse-trigger"
            >See less</a>
            <i id="categories-collapse-icon" class="fa fa-chevron-circle-up text-primary"></i>
        </span>
    </h4>
    @endif --}}
    <h4 class="Content__Heading"><span>{{ ucfirst($translated_type) }} {{ trans('video.location') }}</span></h4>
    <div class="form-group">
        <input id="pac-input" class="form-control disable-enter-key hidden" type="text" placeholder="{{ trans('video.search_google_maps') }}">
        <div id="map" style="height: 400px;"></div>
        <p class="help-block">{{ trans('video.drag-marker-to-change-location') }}</p>
    </div>
    <div class="form-group align-middle">
        <label class="col-md-3">{{ trans('video.country') }}</label>
        <div class="col-md-9">
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
                @foreach ($countries as $country)
                    <option
                        value="{{ $country->code }}"
                        {{ old('country_code', $content->country_code) == $country->code ? 'selected' : '' }}
                    >{{ $country->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div id="region-parent" class="form-group align-middle {{ !need_region(old('country_code', $content->country_code)) ? 'hidden' : '' }}">
        <label class="col-md-3">{{ trans('video.state') }}</label>
        <div class="col-md-9">
            <select name="region_code" class="chosen-select form-control init-map" data-placeholder="{{ trans('video.select') }}...">
                <option></option>
                @foreach (regions_by_country(old('country_code', $content->country_code)) as $region)
                    <option
                        value="{{ $region->code }}"
                        {{ $region->code == old('region_code', $content->region_code) ? 'selected' : '' }}
                    >{{ $region->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div id="city-parent" class="form-group align-middle">
        <label class="col-md-3">{{ trans('video.city') }}</label>
        <div class="col-md-9">
            <div class="Autocomplete">
                <i class="fa fa-spinner fa-pulse loader hidden"></i>
                <input
                    type="text"
                    name="city_name"
                    value="{{ old('city_name', $content->city_name) }}"
                    class="form-control init-map"                                
                    data='{"country_code": "country_code", "region_code": "region_code"}'
                    data-url="{{ route('api::getSearchCityByCountry') }}"                
                    autocomplete="off"
                >
                <div class="autocomplete-results"></div>                                
            </div>
        </div>
    </div>
    <div class="form-group hidden">
        <label class="col-md-3">{{ trans('video.latitude') }}</label>
        <div class="col-md-9">
            <input type="text" name="latitude" value="{{ old('latitude', $content->latitude) }}" id="latitude" class="form-control init-map">
        </div>
    </div>
    <div class="form-group hidden">
        <label class="col-md-3">{{ trans('video.longitude') }}</label>
        <div class="col-md-9">
            <input type="text" name="longitude" value="{{ old('longitude', $content->longitude) }}" id="longitude" class="form-control init-map">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-3">{{ trans('video.address') }}</label>
        <div class="col-md-9">        
            <input type="text" name="address" value="{{ old('address', $content->address) }}" placeholder="" class="form-control normal" disabled>
            {{-- <p class="help-block text-right">
                <a
                    class="text-default"
                    data-toggle="modal"
                    data-target="#uploadContentExactLocationModal"
                    data-backdrop="static"
                >or Pinpoint Location on Map</a>
                <i class="fa fa-chevron-circle-down text-primary"></i>
            </p> --}}
        </div>
    </div>
    <h4 class="Content__Heading"><span>{{ ucfirst($translated_type) }} {{ trans('video.date') }}</span></h4>
    <div class="form-group">
        <label class="col-md-3">{{ trans('video.date-label') }}</label>
        <div class="col-md-9 gutter-5">
            <div class="row">
                <div class="col-md-6">
                    <input type="text" name="offence_date" value="{{ old('offence_date', $content->offence_date) }}" class="form-control datepicker">
                    {{-- <select
                        name="day"
                        class="form-control chosen-select broken-data"
                        data-type="date"
                        data-placeholder="Day"
                        data-target-name="offence_date"
                        data-dependency-names='{"day": "day", "month": "month", "year": "year"}'
                    >
                        <option></option>
                        @for ($i = 1; $i <= 31; $i++)
                            <option 
                                value="{{ sprintf('%02d', $i) }}"
                                {{ sprintf('%02d', $i) == old('day') ? 'selected' : '' }}
                            >{{ sprintf('%02d', $i) }}</option>
                        @endfor
                    </select> --}}
                </div>
                {{-- <div class="col-md-5">
                    <select
                        name="month"
                        class="form-control chosen-select broken-data"
                        data-type="date"
                        data-placeholder="Month"
                        data-target-name="offence_date"
                        data-dependency-names='{"day": "day", "month": "month", "year": "year"}'
                    >
                        <option></option>
                        @foreach (cal_info(0)['months'] as $month_key => $month)
                            <option
                                value="{{ sprintf('%02d', $month_key) }}"
                                {{ old('month') == sprintf('%02d', $month_key) ? 'selected' : '' }}
                            >{{ $month }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <select
                        name="year"
                        class="form-control chosen-select broken-data"
                        data-type="date"
                        data-placeholder="Year"
                        data-target-name="offence_date"
                        data-dependency-names='{"day": "day", "month": "month", "year": "year"}'                                    
                    >
                        <option></option>
                        @foreach (years(0) as $year)
                            <option
                                value="{{ $year }}"
                                {{ $year == old('year') ? 'selected' : '' }}
                            >{{ $year }}</option>
                        @endforeach
                    </select>
                </div> --}}
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-3">{{ trans('video.time') }}</label>
        <div class="col-md-9 gutter-5">
            <div class="row">
                <div class="col-md-6">
                    <input type="text" name="offence_time" value="{{ old('offence_time', $content->offence_date) }}" class="form-control timepicker">
                    {{-- <select
                        name="hour"
                        class="form-control chosen-select broken-data"
                        data-type="time"
                        data-placeholder="Hour"
                        data-target-name="offence_time"
                        data-dependency-names='{"hour": "hour", "minute": "minute"}'
                    >
                        <option></option>
                        @for ($i = 1; $i <= 23; $i++)
                            <option 
                                value="{{ sprintf('%02d', $i) }}"
                                {{ sprintf('%02d', $i) == old('hour') ? 'selected' : '' }}
                            >{{ sprintf('%02d', $i) }}</option>
                        @endfor
                    </select> --}}
                </div>
                {{-- <div class="col-md-4">
                    <select
                        name="minute"
                        class="form-control chosen-select broken-data"
                        data-type="time"
                        data-placeholder="Minute"
                        data-target-name="offence_time"
                        data-dependency-names='{"hour": "hour", "minute": "minute"}'
                    >
                        <option></option>
                        @for ($i = 0; $i <= 60; $i++)
                            <option 
                                value="{{ sprintf('%02d', $i) }}"
                                {{ sprintf('%02d', $i) == old('minute') ? 'selected' : '' }}
                            >{{ sprintf('%02d', $i) }}</option>
                        @endfor
                    </select>
                </div> --}}                               
            </div>
        </div>
    </div>
    <br/>
    <h4 class="Content__Heading clearfix">
        <span>{{ trans('video.details-of-vehicle-involved-in') }} {{ $translated_type }}</span>
        <span class="pull-right padding-left">
            <a
                data-toggle="collapse"
                data-target=".collapse.License__Plate"
                data-collapse-text="{{ trans('video.add-details') }}"
                data-in-text="{{ trans('video.hide-details') }}"
                data-collapse-icon="fa-chevron-circle-down"
                data-in-icon="fa-chevron-circle-up"
                data-target-icon="#license-plate-collapse-icon"
                id="license-plate-collapse-trigger"
            >{{ count($licenses) ? trans('video.hide-details') : trans('video.add-details') }}</a>
            <i id="license-plate-collapse-icon" class="fa {{ count($licenses) ? 'fa-chevron-circle-up' : 'fa-chevron-circle-down' }} text-primary"></i>
        </span>
    </h4>

    <div class="License__Plate collapse {{ count($licenses) ? 'in' : '' }}" data-trigger="#license-plate-collapse-trigger">
        @foreach ($licenses as $key => $license)
            <div id="license-plate-{{ $key }}" class="gutter-5 removable">                        
                <div class="form-group no-margin padding-bottom-5">
                    <div class="col-md-12 text-right">
                        <i class="fa fa-times-circle text-danger"></i>
                        <a class="text-default remove-element" data-counter="#license-plate-counter">{{ trans('video.remove') }}</a>
                    </div>
                </div>
                <div class="form-group align-middle">
                    <label class="col-md-3">{{ trans('video.license-plate') }}</label>
                    <div class="col-md-9">
                        <div class="Autocomplete">
                            <i class="fa fa-spinner fa-pulse loader hidden"></i>
                            <input
                                type="text"
                                name="licenses[{{ $key }}][name]"
                                value="{{ $license['name'] }}"
                                class="form-control"                                
                                data='{}'
                                data-url="{{ route('api::getSearchLicensePlate') }}"
                            >
                            <div class="autocomplete-results"></div>                                
                        </div>
                    </div>
                </div>
                <div class="form-group align-middle">
                    <label class="col-md-3">{{ trans('video.country') }}</label>
                    <div class="col-md-9">
                        <select
                            class="form-control chosen-select country"
                            name="licenses[{{ $key }}][country_code]"
                            data-placeholder="{{ trans('video.select-country') }}..."
                            data-countries-need-state="{{ json_encode(config('app.countries_need_state')) }}"
                            data-get-regions-by-country-url="{{ route('api::getRegionsByCountry') }}"
                            data-region-parent="#license-region-parent-{{ $key }}"
                            
                        >
                            <option></option>
                            @foreach ($countries as $country)
                                <option
                                    value="{{ $country->code }}"
                                    {{ ($license['country_code'] ?: $content->country_code) == $country->code ? 'selected' : '' }}
                                >{{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div id="license-region-parent-{{ $key }}" class="form-group align-middle {{ !need_region($license['country_code'] ?: $content->country_code) ? 'hidden' : '' }}">
                    <label class="col-md-3">{{ trans('video.state') }}</label>
                    <div class="col-md-9">
                        <select name="licenses[{{ $key }}][region_code]" class="chosen-select" data-placeholder="{{ trans('video.select') }}...">
                            <option></option>
                            @foreach (regions_by_country($content->country_code) as $region)
                                <option
                                    value="{{ $region->code }}"
                                    {{ $region->code == $license['region_code'] ? 'selected' : '' }}
                                >{{ $region->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group align-middle">
                    <label class="col-md-3">{{ trans('video.vehicle-type') }}</label>
                    <div class="col-md-9">
                        <select class="form-control chosen-select" name="licenses[{{ $key }}][type_id]" data-placeholder="{{ trans('video.select-vehicle-type') }}...">
                            <option></option>
                            @foreach ($vehicle_types as $v_type)
                                <option
                                    value="{{ $v_type->id }}"
                                    {{ $v_type->id == $license['type_id'] ? 'selected' : '' }}
                                >{{ $v_type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group align-middle">
                    <label class="col-md-3">{{ trans('video.make') }}</label>
                    <div class="col-md-9">                                
                        <select
                            class="form-control chosen-select"
                            name="licenses[{{ $key }}][make_id]"
                            data-placeholder="{{ trans('video.select-vehicle-make') }}..."
                            data-live-search="true"
                            data-url="{{ route('api::getVehicleMakeModels') }}"
                            data-target="#vehicle-model-{{ $key }}"
                            data-dependency='{"make_id": "#vehicle-make-{{ $key }}"}'
                            data-target-options='{"value": "id", "label": "name"}'
                            id="vehicle-make-{{ $key }}"
                            >
                            <option></option>
                            @foreach ($vehicle_makes as $v_make)
                                <option
                                    value="{{ $v_make->id }}"
                                    {{ $v_make->id == $license['make_id'] ? 'selected' : '' }}
                                >{{ $v_make->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group align-middle">
                    <label class="col-md-3">{{ trans('video.model') }}</label>
                    <div class="col-md-9">
                        <select
                            class="form-control chosen-select"
                            name="licenses[{{ $key }}][model_id]"
                            data-placeholder="{{ trans('video.select-vehicle-model') }}..."
                            id="vehicle-model-{{ $key }}"
                        >
                            <option></option>
                            @foreach (vehicle_models_by_make_id($license['make_id']) as $v_model)
                                <option
                                    value="{{ $v_model->id }}"
                                    {{ $v_model->id == $license['model_id'] ? 'selected' : '' }}
                                >{{ $v_model->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3">{{ trans('video.color') }}</label>
                    <div class="col-md-9">
                        <select class="form-control chosen-select" name="licenses[{{ $key }}][color_id]" data-placeholder="{{ trans('video.select-color') }}...">
                            <option></option>
                            @foreach ($vehicle_colors as $v_color)
                                <option
                                    value="{{ $v_color->id }}"
                                    {{ $v_color->id == $license['color_id'] ? 'selected' : '' }}
                                >{{ $v_color->name }}</option>
                            @endforeach
                        </select>                                
                    </div>
                </div>
            </div>                                          
        @endforeach                    
        <div class="form-group form-group-add-license">
            <div class="col-md-12">
                <p class="help-block text-right">
                    <a
                        class="text-default add-element"
                        data-add-type="insert_before"
                        data-add-target=".form-group-add-license"
                        data-template-id="#addLicenseFormTemplate"
                        data-counter="#license-plate-counter"                   
                    >{{ trans('video.add-more-vehicles') }}</a>
                    <i class="fa fa-chevron-circle-down text-primary"></i>
                    <input type="hidden" name="license_plate_counter" value="{{ count($licenses) - 1 }}" id="license-plate-counter">
                </p>
            </div>
        </div>
    </div>
    <h4 class="Content__Heading"><span>{{ trans('video.other-details') }}</span></h4>
    <div class="form-group align-middle">
        <label class="col-md-3">{{ trans('video.type-of-camera') }}</label>
        <div class="col-md-9">
            <select class="form-control chosen-select" name="camera" data-placeholder="{{ trans('video.select-camera-type') }}...">
                <option></option>
                @foreach ($camera_models as $camera)
                    <option
                        value="{{ $camera->name }}"
                        {{ old('camera', $content->camera) == $camera->name ? 'selected' : '' }}
                    >{{ $camera->name }}</option>
                @endforeach
            </select>                            
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3 col-sm-offset-3">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="disable_comments" {{ $content->disable_comments ? 'checked' : '' }}>
                    {{ trans('video.disable-comments-for-this') }} {{ $translated_type }}
                </label>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="disable_map" {{ $content->disable_map ? 'checked' : '' }}>
                    {{ trans('video.keep-map-location-private', ['upload_type' => $translated_type]) }}
                </label>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="private" {{ $content->private ? 'checked' : '' }}>
                    {{ trans('video.make-content-private', ['upload_type' => $translated_type]) }}
                </label>
            </div>
            {{-- <div class="checkbox">
                <label>
                    <input type="checkbox" name="agreement">
                    I approve that {{ trans('app.site_name') }} can edit and add comments and indicators to this {{ $translated_type }}
                </label>
            </div> --}}                            
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-9">
            <button
                type="submit"
                class="btn btn-primary"
                data-loading-text="{!! button_loading(trans('app.saving').'...') !!}"
            >{{ trans('video.save') }}</button>            
        </div>
    </div>
</form>