<div class="col-md-8 no-padding">
    <div class="Map">
        <input id="pac-input" class="form-control disable-enter-key hidden" type="text" placeholder="{{ trans('video.search_google_maps') }}">                    
        <div id="map" style="height:810px;"></div>
        <div class="backdrop"></div>
        <div class="loader">
            <i class="fa fa-spinner fa-pulse"></i> {{ trans('home.loading_map') }}
        </div>                    
    </div>
</div>