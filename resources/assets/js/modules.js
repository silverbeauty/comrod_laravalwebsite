var exports = module.exports = {};
var map;
var bounds;
var contents = [];
var filtered_contents;
var queryString;
var marker;
var markers = [];
var marker_clusterer;
var new_markers;
var new_sortable = [];
var geocoder;
var isGoogleMapApiLoaded = false;
var initMap = false;
var initMapTimer;
var info_window;
var total_categories = 0;
var total_slots;
var disable_zoom_changed_listener = false;
var slide_left = false;
var slide_right = false;
var first_load = true;
var settings = typeof Cookies.get('settings') !== 'undefined' ? JSON.parse(Cookies.get('settings')) : {};
var watched = {};
var timeout = null;
var content_id = null;
var map_first_load = true;
var total_loaded_images = 0;
var total_loadable_images = 0;
var loadable_images = null;
var main_carousel_chunked = null;
var total_main_carousel_chunks = 0;
var total_main_carousel_appended = 1;
var prev_total_main_carousel_appended = 1;
var set_timeout_delay = 300;
var dom_complete = false;
var next_page_url = '/api/contents?page=2';
var current_map_zoom = 0;

exports.ajaxStartStop = function (startCallback, stopCallback) {
    $(document).ajaxStart(startCallback).ajaxStop(stopCallback);
}

exports.loadingButton = function (elem) {
    exports.ajaxStartStop(function () {
        elem.button('loading');
    }, function () {
        elem.button('reset');
        $(this).unbind('ajaxStart');
    });
}

exports.swalError = function (data) {
    var message = 'Looks like something went wrong. Please try again later.';

    if (typeof data.responseJSON !== 'undefined') {
        var errors = data.responseJSON;
        var messages = '';
        for (var key in errors) {
            if (errors.hasOwnProperty(key)) {
                messages += errors[key]+'\n';
            }
        }
        message = messages;
    }

    swal('Whoops!!!', message, 'error');
}

exports.swalSuccess = function (title, body, redirect) {
    swal({
        title: title,
        text: body,
        type: 'success',
        //timer: 3000,
        showConfirmButton: true
    }, function () {
        if (typeof redirect !== 'undefined') {
            if (redirect.search('http') != -1) {
                return location.href = redirect;
            }

            return location.reload();
        }
    });
}

exports.swalConfirm = function (title, body, buttonText, callback, loader, close) {
    var loader = typeof loader !== 'undefined' && loader != false ? true : false;
    var close = typeof close !== 'undefined' ? close : true;
    var closeOnConfirm = loader ? false : close;   

    swal({
        title: title,
        text: body,
        type: 'warning',
        showCancelButton: true,
        cancelButtonText: global_js_vars.cancelButtonText,
        confirmButtonColor: '#FF592E',
        confirmButtonText: buttonText,
        closeOnConfirm: closeOnConfirm,
        showLoaderOnConfirm: loader
    }, callback);
}

exports.actionConfirm = function (elem) {
    var close = elem.data('close-on-confirm');    

    close = typeof close !== 'undefined' ? close : false;

    var loader = close ? false : true;

    exports.swalConfirm(
        elem.attr('data-confirm-title'),
        elem.attr('data-confirm-body'),
        elem.attr('data-confirm-button-text'),
        function () {
            exports.ajax(elem.data('ajax-data'), elem);
        },
        loader
    );
}

exports.ajax = function (data, elem, callback) {
    var url = elem.attr('data-url');
    url = typeof url !== 'undefined' ? url : elem.attr('action');

    var request = $.ajax({
        type: 'post',
        data: data,
        url: url,
        dataType: 'json'
    });

    request.done(function (response) {
        if (typeof callback === 'undefined' || callback == null) {
            var redirect = typeof response.redirect !== 'undefined' ? response.redirect : elem.attr('data-reload');
            var success_title = typeof response.success_title !== 'undefined' ? response.success_title : elem.attr('data-success-title');
            var success_body = typeof response.success_body !== 'undefined' ? response.success_body : elem.attr('data-success-body');
            var modal = elem.closest('.modal');
            var close_modal = elem.data('close-modal');
            var removable_elem = elem.data('remove-target');            

            if (typeof response.immediate_redirect !== 'undefined') {
                return location.href = redirect;
            }

            close_modal = typeof close_modal !== 'undefined' ? close_modal : true;
            if (typeof modal !== 'undefined' && close_modal) {
                modal.modal('hide');
            }

            if (elem.prop('nodeName') == 'FORM' && typeof elem.attr('data-clear') === 'undefined') {
                elem.find('input[type="text"], input[type="password"], textarea').val('');
                elem.find('select option').prop('selected', false).trigger('chosen:updated');
            }

            if (typeof elem.attr('data-no-swal-success') === 'undefined') {
                exports.swalSuccess(success_title, success_body, redirect);
            } else {
                swal.close();
            }

            if (typeof elem.attr('data-add-element') !== 'undefined') {
                exports.addElement(elem, response);
            }

            if (typeof removable_elem !== 'undefined') {
                $(removable_elem).fadeOut('slow', function () {
                    $(removable_elem).remove();
                });
            }

        } else {
            callback(elem, response);
        }
    });

    request.fail(function (response) {
        if (response.status == 401) {
            return $('#loginModal').modal({backdrop: 'static', info_message: 'You need to be logged in to perform this action.'});
        }

        exports.swalError(response);
    });
}

exports.addElement = function (elem, data) {
    var template = _.template($('script'+elem.attr('data-template-id')).html());
    var insert_type = elem.attr('data-add-type');
    var hidable = elem.attr('data-hidable');
    var showable = elem.attr('data-showable');
    var update_value = elem.attr('data-update-value');
    var callbacks = [];
    callbacks['append'] = exports.append;
    callbacks['insert_after'] = exports.insertAfter;
    callbacks['insert_before'] = exports.insertBefore;

    if (typeof hidable !== 'undefined') {
        $(hidable).addClass('hidden');
    }

    if (typeof showable !== 'undefined') {
        $(showable).removeClass('hidden');
    }

    if (typeof update_value !== 'undefined') {
        update_value = JSON.parse(update_value);

        for (var key in update_value) {
            if (update_value.hasOwnProperty(key)) {
                $(key).html(data[update_value[key]]);
            }
        }
    }

    callbacks[insert_type](elem, data, template);

    exports.chosenSelect();
}

exports.append = function (elem, data, template) {

}

exports.insertAfter = function (elem, data, template) {
    $(template(data)).hide().insertAfter(elem.attr('data-add-target')).fadeIn('slow');
}

exports.insertBefore = function (elem, data, template) {
    $(template(data)).hide().insertBefore(elem.attr('data-add-target')).fadeIn('slow').parent().removeClass('hidable-element');
}

exports.likeDislikeCallback = function (elem, response) {
    var parent = elem.parent();
    if (elem.hasClass('selected')) {
        elem.removeClass('selected');
    } else {
        parent.find('.selected').removeClass('selected');
        elem.addClass('selected');
    }
    $(elem.attr('data-likes-counter')).html(response.total_likes);
    $(elem.attr('data-dislikes-counter')).html(response.total_dislikes);
}

exports.chosenSelect = function () {
    var config = {
        '.chosen-select'           : {},
        '.chosen-select-deselect'  : {allow_single_deselect:true},
        '.chosen-select-no-single' : {disable_search_threshold:10},
        '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
        '.chosen-select-width'     : {width:"95%"}
    }

    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }
}

exports.ajaxChosen = function () {
    $('.ajax-chosen').ajaxChosen({
        type: 'get',
        url: '/api/search',
        dataType: 'json'
    }, function (data) {
        var results = [];

        $.each(data, function (i, val) {
            results.push({value: val.value, text: val.text});
        });
    });
}

exports.hasMap = function (id) {
    return !! document.getElementById(id).firstChild;
}

exports.autocompleteSearchUsers = function (ul, item) {
    return $( "<li></li>" )
                .data( "item.autocomplete", item )
                .append( item.label )
                .appendTo( ul );
}

exports.split = function (val) {
    return val.split(/,\s*/);
}

exports.extractLast = function (term) {
    return exports.split(term).pop();
}

exports.scroll = function () {
    var scroll_down_elem = $('.scroll-down');
    scroll_down_elem.animate({scrollTop: scroll_down_elem.children(':first-child').height()}, 800);
}

exports.loadMap = function () {
    isGoogleMapApiLoaded = true;
}

exports.initMap = function (attributes) {
    exports.loadImages($('img.lazy'));
    map_first_load = false;
    dom_complete = true;

    if (attributes.init_settings) {
        exports.initSettings(attributes);
    }

    //console.log(attributes);

    content_id = attributes.content_id;
    watched = attributes.watched;
    current_map_zoom = attributes.zoom;  
    info_window = new google.maps.InfoWindow({maxWidth: 252});
    bounds = new google.maps.LatLngBounds();
    geocoder = new google.maps.Geocoder();
    map = new google.maps.Map(document.getElementById(attributes.map_element_id), {
        zoom: attributes.zoom,
        minZoom: 4,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    if (attributes.traffic_layer) {
        var trafficLayer = new google.maps.TrafficLayer();
        trafficLayer.setMap(map);
    }
    
    if ((!attributes.lat && !attributes.lng) || (attributes.use_country_name && settings.country_name)) {
        if (settings.prev_map && attributes.use_prev_map) {
            map.setCenter(settings.prev_map.position);
            map.setZoom(settings.prev_map.zoom);
            current_map_zoom = settings.prev_map.zoom;
        } else {
            exports.geocodeAddress(attributes);
        }
    } else {
        attributes.position = {lat: attributes.lat, lng: attributes.lng};         
        
        map.setCenter(attributes.position);

        if (attributes.default_marker) {        
            exports.mapMarker(attributes);
        }
    }    

    if (attributes.multiple_markers) {
        
        map.addListener('idle', (function () {
            var timer;
            return function() {
                clearTimeout(timer);
                timer = setTimeout(function() {
                    if (next_page_url || current_map_zoom > map.getZoom() ) {
                        exports.mapFilter(map);
                    }

                    current_map_zoom = map.getZoom();
                }, 1500);
            }
        }()));

        map.addListener('dragend', (function () {
            var timer;
            return function() {
                clearTimeout(timer);
                timer = setTimeout(function() {                   
                    exports.mapFilter(map);                    
                }, 1500);
            }
        }()));

        if (attributes.has_json_file) {
            //exports.loadMapJson(attributes);
        } else {
            //exports.ajaxMapContents(attributes);
            contents = attributes.map_contents;
            filtered_contents = contents;        
            exports.markers();

            if (attributes.map_loading) {
                var container = $('.Map');
                container.find('.backdrop').addClass('hidden');
                container.find('.loader').addClass('hidden');
            }
        }       
    }

    if (attributes.fit_bounds) {
        map.fitBounds(bounds);
    }    

    if (attributes.map_search) {
        exports.mapSearch(attributes);
    }
}

exports.mapFilter = function (map) {
    settings.ne_lat = map.getBounds().getNorthEast().lat();
    settings.ne_lng = map.getBounds().getNorthEast().lng();
    settings.sw_lat = map.getBounds().getSouthWest().lat();
    settings.sw_lng = map.getBounds().getSouthWest().lng();
    exports.saveSettings();
    //console.log(settings);
    var loading = $('.map-loading');

    loading.removeClass('hidden')
    exports.setMapOnAll(null);
    markers = [];
    if (marker_clusterer) {
        marker_clusterer.clearMarkers();
    }  

    $.getJSON('/api/contents', function (response) {
        loading.addClass('hidden');

        next_page_url = response.next_page_url;
        contents = response.items;
        filtered_contents = contents;
        exports.markers();
    });
}

exports.loadMapJson = function (attributes) {
    $.getJSON(attributes.json_file, function (data) {
        if (attributes.map_loading) {
            var container = $('.Map');
            container.find('.backdrop').addClass('hidden');
            container.find('.loader').addClass('hidden');
        }
        
        if (attributes.map_content_type && attributes.map_content_type != 'any') {
            data = _.filter(data, function (item) {
                return item.type == attributes.map_content_type;
            });
        }

        contents = data;
        filtered_contents = contents;

        exports.markers();        
    });
}

exports.initContents = function (attributes) {
    exports.loadImages($('img.lazy'));
    map_first_load = false;
    dom_complete = true;

    if (attributes.init_settings) {
        exports.initSettings(attributes);
    }   

    content_id = attributes.content_id;
    watched = attributes.watched;    

    exports.loadJson(attributes);    
}

exports.addMarker = function (content, key) {
    if (content_id != content.id && content.lat && content.lng) {
        var latLng = {lat: content.lat, lng: content.lng};
        var marker = new google.maps.Marker({
            position: latLng,
            map: map,
            icon: js_vars.settings.categories_icon_url + 'icon_' + content.icon + '.png',
            key: key,
            content_id: content.id
        });

    
        markers.push(marker);
        exports.infoWindow(content, marker);

        bounds.extend(marker.position);
    }
}

exports.markers = function () {
    
    if (contents.length) {        
        for (var key in contents) {
            if (contents.hasOwnProperty(key)) {
                var content = contents[key];

                exports.addMarker(content, key);
            }
        }
    }

    exports.clusterMarker(markers);    

    exports.removeMarkers();        
    
    map.addListener('dragend', function () {                
        exports.updateListing(new_markers);
        exports.saveMap();
    });

    map.addListener('zoom_changed', function () {                
        if (!disable_zoom_changed_listener) {
            exports.updateListing(new_markers);
        }
        exports.saveMap();
    });           

    map.addListener('click', function () {
        if (info_window) {
            $('.Listing .Thumbnail').removeClass('hovered');
            info_window.close();
        }
    });

    map.addListener('idle', function () {
        
        if (map_first_load) {
            exports.initLoadImages($('img.lazy'));
            map_first_load = false;
        }        
    });
}

exports.removeMarkers = function () {
    var added_markers = [];
    var removed_markers = [];        

    exports.setMapOnAll(null);

    new_markers = _.filter(markers, function (marker) {
        if (_.some(filtered_contents, {id: marker.content_id}) && !exports.isWatched(marker.content_id)) {
            marker.setMap(map);                       
            return true;
        }
    });
    
    marker_clusterer.removeMarkers(markers);
    exports.clusterMarker(new_markers);
    exports.updateListing(new_markers);                       
}

exports.setMapOnAll = function (map) {
    for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(map);
    }
}

exports.initLoadImages = function (images, container) {
    $(window).load(function () {
        exports.loadImages(images, container);
        dom_complete = true;
    });

    if (dom_complete) {
        exports.loadImages(images, container);
    }
}

exports.loadImages = function (images, container) {
    images.each(function () {
        var $this = $(this);

        if ($this.data('original') != $this.attr('src')) {
            if (container) {
                $this.lazyload({
                    container: $(container),
                    effect: 'fadeIn'
                });
            } else {
                $this.lazyload({
                    effect: 'fadeIn'
                });
            }
        }
    });
}

exports.resetTotalLoadableImages = function () {
    total_loadable_images = 0;
    total_loaded_images = 0;
}

exports.loadJson = function (attributes) {
    $.getJSON(attributes.json_file, function (data) {        
        
        if (attributes.map_content_type && attributes.map_content_type != 'any') {
            data = _.filter(data, function (item) {
                return item.type == attributes.map_content_type;
            });
        }

        contents = data;
        filtered_contents = data;

        if (!settings.ignore_filters) {
            exports.filterByCountry();
            exports.filterByCategory();
            exports.filterByDate();            
        }

        if (settings.hide_watched) {
            filtered_contents = exports.watchedFilter(filtered_contents);
        }

        exports.slideDownContents(filtered_contents);                      
    });
}

exports.ajaxMapContents = function (attributes, page) {
    var perPage = 100;
    var totalPages = Math.floor(attributes.total_map_contents / perPage);
    var requestDone = true;
    var page = page ? page : 1;    

    if (page <= totalPages) {
        var request = $.ajax({
            type: 'get',
            data: {
                map_content_type: attributes.map_content_type,
                page: page,
                per_page: perPage,
                total_pages: totalPages,
                total_contents: attributes.total_map_contents
            },
            url: '/api/map-contents',
            dataType: 'json'
        });

        request.done(function (response) {            
            if (attributes.map_loading && page == 1) {
                var container = $('.Map');
                container.find('.backdrop').addClass('hidden');
                container.find('.loader').addClass('hidden');
            }             

            for (var i = 0; i < response.length; i++) {
                exports.addMarker(response[i], i);
                contents.push(response[i]);
            }

            filtered_contents = contents;
            new_markers = markers;                     

            exports.ajaxMapContents(attributes, page + 1);       
        });

        request.fail(function (response) {
            return exports.swalError(response);
        });
    } else {        
        exports.markers();
    }
}

exports.geocodeAddress = function (attributes) {
    geocoder.geocode({'address': attributes.address}, function(results, status) {
        if (status === google.maps.GeocoderStatus.OK) {
            map.setCenter(results[0].geometry.location);            
            attributes.position = results[0].geometry.location;

            if (attributes.default_marker) {
                exports.mapMarker(attributes);
            }
        } else {
            console.log('Geocode was not successful for the following reason: ' + status);
        }
    });
}

exports.mapMarker = function (attributes) {
    marker = new google.maps.Marker({
        map: map,
        position: attributes.position,
        draggable: attributes.map_marker_draggable,
        title: attributes.map_marker_title,
        icon: attributes.map_icon
    });

    var events = attributes.map_marker_events;

    if (events) {
        for (var key in events) {
            marker.addListener(events[key], function () {
                exports.setLatLng(marker.getPosition());
                exports.geocodeLatLng(marker.getPosition());
            });
        }
    }
}

exports.hoverMarker = function (id) {
    for (var i = 0; i < markers.length; i++) {
        var marker = markers[i];
        var content = contents[marker.key];
                           
        if (content.id == id) {
            marker.setIcon(js_vars.settings.categories_icon_url + 'hover/icon_' + content.icon + '.png');
            var clusters = marker_clusterer.clusters_;
            //console.log(marker_clusterer.clusters_);
            for (var c = 0; c < clusters.length; c++) {
                if (clusters[c].isMarkerAlreadyAdded(marker)) {
                    clusters[c].clusterIcon_.hide();
                    exports.addMarker(content, marker.key);
                }
            }                        
        }
    }
}

exports.unhoverMarker = function (id) {
    for (var i = 0; i < markers.length; i++) {
        var marker = markers[i];
        var content = contents[marker.key];
                           
        if (content.id == id) {
            marker.setIcon(js_vars.settings.categories_icon_url + 'icon_' + content.icon + '.png');
            var clusters = marker_clusterer.clusters_;
            //console.log(marker_clusterer.clusters_);
            for (var c = 0; c < clusters.length; c++) {
                if (clusters[c].clusterIcon_.center_ && clusters[c].isMarkerAlreadyAdded(marker)) {
                    clusters[c].clusterIcon_.show();                    
                }
            }                      
        }
    }
}

exports.setLatLng = function (position) {
    $('input[name="latitude"]').val(position.lat());
    $('input[name="longitude"]').val(position.lng());
}

exports.mapSearch = function (attributes) {
    // Create the search box and link it to the UI element.
    var input = document.getElementById('pac-input');
    var searchBox = new google.maps.places.Autocomplete(input);
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    // Bias the SearchBox results towards current map's viewport.
    map.addListener('bounds_changed', function() {
        searchBox.setBounds(map.getBounds());
    });

    // [START region_getplaces]
    // Listen for the event fired when the user selects a prediction and retrieve
    // more details for that place.
    searchBox.addListener('place_changed', function() {
        var place = searchBox.getPlace();
        //marker.setVisible(false);

        if (!place.geometry) {
            alert(attributes.map_no_geometry);
            return;
        }

        //If the place has a geometry, then present it on a map.
        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);  // Why 17? Because it looks good.
        }

        marker.setMap(null);

        attributes.position = place.geometry.location;

        exports.mapMarker(attributes);
    });

    $('#pac-input').removeClass('hidden');
    $('body').append('<input id="pac-input" class="form-control disable-enter-key hidden" type="text" placeholder="'+attributes.map_search_box_placeholder+'">');
}

exports.geocodeLatLng = function (position) {
    var latlng = {lat: position.lat(), lng: position.lng()};
    geocoder.geocode({'location': latlng}, function(results, status) {
        if (status === google.maps.GeocoderStatus.OK) {
            if (results[1]) {
                var addresses = results[1].address_components;
                var target_country = $('select[name="country_code"]');
                var target_region = $('select[name="region_code"]');
                var countries_need_state = ['AU', 'US', 'CA'];
                var city_name = '';
                var state_name = '';
                var country = addresses[addresses.length - 1];

                country = country['types'][0] == 'country' ? country : addresses[addresses.length - 2];

                var country_name = country['long_name'];
                var country_short_name = country['short_name'];
                var target_region_parent = target_region.parent();

                target_region_parent.addClass('hidden');
                target_country.data('clear-city', false);
                $('select[name="country_code"] option[value='+country_short_name+']').prop('selected', true);
                target_country.val(country_short_name).trigger('chosen:updated');
                target_country.trigger('change');

                if (countries_need_state.indexOf(country_short_name) >= 0) {                                
                    target_region_parent.removeClass('hidden');
                }
                
                for (var key in addresses) {
                    if (addresses.hasOwnProperty(key)) {
                        var long_name = addresses[key]['long_name'];
                        var short_name = addresses[key]['short_name'];

                        if (addresses[key]['types'][0] == 'administrative_area_level_1' && countries_need_state.indexOf(country_short_name) >= 0) {
                            state_name = long_name+', ';

                            setTimeout(function () {
                                 $('select[name="region_code"] > option').each(function () {
                                    var this_option = $(this);
                                    if (this_option.text() == state_name.replace(', ', '')) {
                                        this_option.prop('selected', true);
                                        target_region.val(this_option.val()).trigger('chosen:updated');
                                    }
                                });
                            }, 3000);
                        }

                        if (
                            addresses[key]['types'][0] == 'locality' ||
                            key == 0
                        ) {
                            $('input[name="city_name"]').val(long_name);
                            city_name = long_name+', ';
                        }
                    }
                }

                $('input[name="address"]').val(city_name + state_name + country_name);

            } else {
                console.log('No results found');
            }
        } else {
            console.log('Geocoder failed due to: ' + status);
        }
    });
}

exports.clusterMarker = function (markers) {
    marker_clusterer = new MarkerClusterer(map, markers, {
        maxZoom: null,
        gridSize: null,
        styles: null,
        minimumClusterSize: 10
    });    
}

exports.updateListing = function (markers) {
    var sample_country_code;
    new_sortable = [];

    clearTimeout(timeout);
    timeout = setTimeout(function () {
        for (var i = 0; i < markers.length; i++) {               
            var content = contents[markers[i].key];
            if (content != null && content.id != content_id && map.getBounds() != null) {
                if (map.getBounds().contains(markers[i].getPosition()) && new_sortable.indexOf(content) == -1) {                    
                    new_sortable.push(content);                                     
                }
            }
        }

        if (settings.layout == 'v1') {            

            var total_new_sortable = _.size(new_sortable);
            var total_lacking = settings.total_slots - total_new_sortable;

            if (total_new_sortable < settings.total_slots && total_new_sortable > 0) {
                var filtered = _.filter(contents, function (item) {
                    return item.cc == sample_country_code && !_.contains(new_sortable, item);
                });

                for (var key in filtered) {
                    if (filtered.hasOwnProperty(key) && key <= (total_lacking - 1)) {
                        new_sortable.push(filtered[key]);
                    }
                }
            }

            if (total_new_sortable > 0) {
                exports.slideDownContents(new_sortable);
            }
        } else {
            exports.slideDownContents(new_sortable);
        }

    }, 1500);
}

exports.infoWindow = function (content, marker) {
    google.maps.event.addListener(marker, 'click', (function (marker) {                
        return function() {
            $('.Listing .Thumbnail').removeClass('hovered');
            $('#thumbnail-'+content.id).addClass('hovered');

            if (typeof content !== 'undefined') {
                info_window.setContent(info_template(content));
                info_window.open(map, marker);
            }                                
        }
    })(marker));
}

exports.hideShowCarouselControl = function () {
    var left = $('#main-content-carousel #slide-left-control');
    var right = $('#main-content-carousel #slide-right-control');

    left.addClass('hidden');
    right.addClass('hidden');

    if (slide_left) {
        left.removeClass('hidden');
    }

    if (slide_right) {
        right.removeClass('hidden');
    }
}

exports.watchedFilter = function (contents) {
    return _.filter(contents, function (item) {       

        for (var i = 0; i < watched.length; i++) {            
            if (watched[i] == item.id) {
                return false;
            }
        }

        return true;
    });
}

exports.isWatched = function (id) {
    var include = false;

    if (settings.hide_watched) {
        for (var i = 0; i < watched.length; i++) {
            if (watched[i] == id) {
                include = true;
                break;
            }
        }
    }

    return include;
}

exports.hideWatched = function (elem) {
    settings.hide_watched = 0;

    if (elem.is(':checked')) {
        if (js_vars.settings.logged_in) {
            settings.hide_watched = 1;
        } else {
            elem.prop('checked', false);
            $('#loginModal').modal({
                backdrop: 'static',
                info_message: 'You need to be logged in to turn on this feature.',
            });
        }
    }

    exports.filterByCountry();
    exports.filterByCategory();
    exports.filterByDate();
    exports.filterBySearch();

    if (! settings.disable_map) {
        exports.removeMarkers();
    } else {
        if (settings.hide_watched) {
            filtered_contents = exports.watchedFilter(filtered_contents);
        }
        exports.slideDownContents(filtered_contents);
    }

    exports.saveSettings();
}

exports.slideDownContents = function (contents, sort_key) {
    $('#carousel-item-0').show();
    var sortTypes = {
        highest_rated: 'hr',
        most_discussed: 'md',
        most_viewed: 'mv',
        most_recent_uploaded: 'mru',
        most_recent_filmed: 'mrf'
    }
    
    new_sortable = contents;
    var sort_type = typeof sort_key === 'undefined' ? settings.sort_type : sort_key;
    var sorted_contents = _.sortBy(contents, sortTypes[sort_type]).reverse();

    settings.sort_type = sort_type;
    exports.saveSettings();

    slide_right = false;
    slide_left = false;

    if (sorted_contents.length > settings.total_slots) {
        slide_right = true;
        slide_left = true;
    }

    if (settings.layout == 'v2' || settings.layout == 'v3') {
        if (sorted_contents.length == 0) {
            if (settings.layout == 'v2') {
                $('#carousel-item-0').find('.row').addClass('hidden');
            }
            if (settings.layout == 'v3') {
                $('#carousel-item-0').find('.content-thumbnail').addClass('hidden');
            }
        }else {
            if (settings.layout == 'v2') {
                $('#carousel-item-0').find('.row').removeClass('hidden');
            }

            for (var i = 0; i <= settings.total_slots; i++) {            
                if (settings.layout == 'v2' || settings.layout == 'v3') {
                    $('#content-thumbnail-'+i).removeClass('hidden');
                    if (i > (sorted_contents.length - 1)) {
                        $('#content-thumbnail-'+i).addClass('hidden');
                    }
                }                        
            }

            $('#main-content-carousel').animate({scrollTop:0}, 'slow');
        }
    }

    var chunked = _.chain(sorted_contents).groupBy(function (element, index) {
        return Math.floor(index/settings.total_slots);
    }).toArray().value();

    for (var key in chunked[0]) { 
        if (chunked[0].hasOwnProperty(key) && key <= (settings.total_slots - 1)) { ;
            var content = chunked[0][key];
            var container = $('#content-thumbnail-'+key);
            var container_id = parseInt(container.attr('data-id'));                

            if (!container.length) {
                if (settings.layout == 'v3') {
                    $('#carousel-item-0').append('<div id="content-thumbnail-'+key+'" class="content-thumbnail"></div>');
                } else {
                    $('#carousel-item-0 .row').append('<div id="col-'+key+'" class="col-md-6 col-sm-6 col-xs-12 margin-bottom-10 thumbnail-wrapper"><div id="content-thumbnail-'+key+'" class="content-thumbnail"></div></div>');
                }
                container = $('#content-thumbnail-'+key);
            }            

            if (container_id != content.id && typeof content !== 'undefined') {                  
                var appended = $(template(content));                  
                container.append(appended);
                //var siblings = appended.siblings();
                appended.hide().show("slide", { direction: "up" }, 800, function () {
                    for (var i = 0; i <= settings.total_slots; i++) {
                        $('#content-thumbnail-'+i+' > div:not(:last-child)').remove();
                    }
                    //console.log(appended.parent());
                });
                container.attr('data-id', content.id);
                exports.initLoadImages($('#content-thumbnail-'+key+ ' img.lazy'));                    
            }
        }
    }   

    // if (settings.layout == 'v2') {
    //     exports.initLoadImages($('#carousel-item-0 img.lazy'), '#main-content-carousel');
    // }

    //if (settings.layout == 'v1') {
        //exports.initLoadImages($('#carousel-item-0 img.lazy'));
    //} 

    exports.hideShowCarouselControl();
    exports.appendCarouselChunked(chunked);             
}

exports.mainCarouselChunkedAppend = function (items, total, counter) {    
    timeout = setTimeout(function () {
        if (settings.layout == 'v1') {        
            $('#main-content-carousel').append(block_template({
                items: items[counter],
                id: counter
            }));
        }

        if (settings.layout == 'v3') {            
            $('#carousel-item-0').append(block_template_v2({
                items: items[counter],
                id: counter,
                hidden: counter > 0 ? 'hidden' : '',
            }));       
        }

        if (settings.layout == 'v2') {            
            $('#carousel-item-0 .row').append(block_template_v2({
                items: items[counter],
                id: counter,
                hidden: counter > 0 ? 'hidden' : '',
            }));
        }
        
        exports.loadImages($('#carousel-item-0 img.lazy'));
        $('input[name="total_main_content_carousel_items"]').val(counter);                
        //exports.rememberMainCarouselPage();

        counter++;
        
        if (total > counter) {
            exports.mainCarouselChunkedAppend(items, total, counter);
        } else {
            clearTimeout(timeout);
        }
    }, 500);
}

exports.appendCarouselChunked = function (items) {
    clearTimeout(timeout);
    var counter = 1;    

    if (settings.layout == 'v1') {
        $('#carousel-item-0').nextAll().remove();
    }

    if (settings.layout == 'v2' || settings.layout == 'v3') {
        if (settings.layout == 'v2') {
            var id = settings.total_slots - 1;
            $('#carousel-item-0 .row #col-'+id).nextAll().remove();
        }

        if (settings.layout == 'v2') {
            //$('#carousel-item-0 .row').children().remove();        
        }

        if (items.length == 0) {
            $('#noResultMessage').removeClass('hidden');            
        } else {
            $('#noResultMessage').addClass('hidden');
        }

    }

    if (items.length) {
        exports.mainCarouselChunkedAppend(items, items.length, counter);
    }

    $('#main-content-carousel .carousel-control').attr('data-current-item-id', 0);
}

exports.rememberMainCarouselPage = function () {
    var cache_item = $('#main-content-carousel #carousel-item-'+settings.main_carousel_item);

    if (cache_item.length == 1 && !cache_item.is(':visible') && first_load) {
        $('#main-content-carousel .Listing').hide();
        $('#main-content-carousel .carousel-control').attr('data-current-item-id', settings.main_carousel_item);
        exports.initLoadImages($('#carousel-item-'+settings.main_carousel_item+' img.lazy'));      
        cache_item.show();
        first_load = false;
    }
}

exports.filterByCategory = function () {
    var filtered = filtered_contents ? filtered_contents : contents;
    
    var categories = settings.categories;

    total_categories = categories.length;

    if (total_categories) {
        filtered = _.filter(filtered, function (items) { 
            for (var i = 0; i < total_categories; i++) {
                var items_categories = items.cat;
                for (var key in items_categories) {
                    if (items_categories.hasOwnProperty(key)) {
                        if (items_categories[key] == categories[i]) {
                            return true;
                        }
                    }
                }
            }                    
        });        
    }

    filtered_contents = filtered;      
}

exports.filterByDate = function (filter_type) {
    var filtered = filtered_contents ? filtered_contents : contents;
    var now = moment();
    var filter = [];
    filter['hour_48'] = moment().subtract(48, 'h');
    filter['week_2'] = moment().subtract(2, 'w');
    filter['month_1'] = moment().subtract(1, 'M');
    filter['month_6'] = moment().subtract(6, 'M');
    filter['year_1'] = moment().subtract(1, 'y');
    filter['all_time'] = null;

    filter_type = typeof filter_type !== 'undefined' ? filter_type : $('#show-from-filter-label').attr('data-key');
    
    if (filter[filter_type] != null) {
        filtered = _.filter(filtered, function (item) {
            return item.mru >= filter[filter_type].format('YYYY-MM-DD hh:mm:ss');
        });               
    }

    filtered_contents = filtered;            
}

exports.filterBySearch = function () {
    if (settings.query_string) {
        filtered_contents = _.filter(filtered_contents, function (item) {
            if (item.title.toLowerCase().search(settings.query_string) !== -1) {
                return true;
            }
        });
    }
}

exports.search = function (value) {
    settings.query_string = value.toLowerCase();
    exports.saveSettings();

    if (! settings.disable_map) {
        exports.filterByCountry();
        exports.filterByCategory();
        exports.filterByDate();
        exports.filterBySearch();    
        exports.saveSettings();

        exports.slideDownContents(filtered_contents);
    } else {
        exports.filter(true);
    }
}

exports.getContentById = function (id) {
    return contents[id];
}

exports.saveMap = function () {
    settings.prev_map = {
        position: map.getCenter(),
        zoom: map.getZoom()
    }    

    exports.saveSettings();
}

exports.getSettings = function () {
    return settings;
}

exports.initSettings = function (obj) {
    var except = ['watched', 'map_contents', 'flowplayer_settings'];
    var force_reset = ['ignore_filters', 'layout', 'total_slots', 'query_string', 'ne_lat', 'ne_lng', 'sw_lat', 'sw_lng', 'disable_map'];

    for (var key in obj) {
        if (((!settings[key] && obj.reset_settings) && except.indexOf(key) == -1) || force_reset.indexOf(key) != -1) {
            settings[key] = obj[key];            
        }
    }

    exports.saveSettings();    
}

exports.saveSettings = function () {
    Cookies.set('settings', settings);    
}

exports.carousel = function (e) {
    e.preventDefault();            
    var elem = $(this);
    var direction = elem.attr('data-slide');
    var total_items = parseInt($('input[name="total_main_content_carousel_items"]').val());
    var current_item_id = parseInt(elem.attr('data-current-item-id'));
    var next_item_id = current_item_id == (total_items - 1) ? 0 : current_item_id + 1;
    var prev_item_id = current_item_id == 0 ? (total_items - 1) : current_item_id - 1;
    var current_item = $('#main-content-carousel #carousel-item-'+current_item_id);
    var next_item = $('#main-content-carousel #carousel-item-'+next_item_id);
    var prev_item = $('#main-content-carousel #carousel-item-'+prev_item_id);

    if (direction == 'left') {
        exports.initLoadImages($('#carousel-item-'+prev_item_id+' img.lazy'));
        current_item.addClass('next').hide("slide", {direction: 'right'}, 1000, function () { $(this).removeClass('next') });
        prev_item.show("slide", {direction: direction}, 1000);
        $('#main-content-carousel .carousel-control').attr('data-current-item-id', prev_item_id);
        settings.main_carousel_item = prev_item_id;
    } else {
        exports.initLoadImages($('#carousel-item-'+next_item_id+' img.lazy'));
        current_item.addClass('prev').hide("slide", {direction: 'left'}, 1000, function () { $(this).removeClass('prev') });
        next_item.show("slide", {direction: direction}, 1000);
        $('#main-content-carousel .carousel-control').attr('data-current-item-id', next_item_id);
        settings.main_carousel_item = next_item_id;
    }
    
    slide_right = true;
    slide_left = true;

    exports.hideShowCarouselControl();        
    exports.saveSettings();        

    elem.off(e);

    setTimeout(function () { $('body').on('click', '#main-content-carousel .carousel-control', exports.carousel); }, 1000);
}

exports.mapCategoryFilter = function (elem) {
    var category_id = elem.attr('data-category-id');
    var checkbox = elem.find('input[type="checkbox"]');            

    if (checkbox.is(':checked')) { 
        checkbox.prop('checked', false);
        elem.removeClass('active'); 
        for (var i = 0; i <= settings.categories.length; i++) {                    
            if (settings.categories[i] == category_id) {
                settings.categories.splice(i, 1); 
            }
        }              
    } else { 
        elem.addClass('active');
        checkbox.prop('checked', true);

        if (settings.categories.indexOf(category_id) == -1) {
            settings.categories.push(category_id);
        }
    }

    exports.saveSettings();

    if (! settings.disable_map) {
        // exports.filterByCountry();
        // exports.filterByCategory();
        // exports.filterByDate();
        // exports.filterBySearch();
        // exports.removeMarkers();
        exports.mapFilter(map);
    } else {
        exports.filter(true);
    }    
}

exports.resetMapCategoryFilter = function () {
    settings.categories = [];
    exports.saveSettings();   

    if (! settings.disable_map) {
        exports.filterByCountry();
        exports.filterByCategory();
        exports.filterByDate();
        exports.filterBySearch();
        exports.removeMarkers();
    } else {
        exports.filter(true);
    }    
}

exports.sortContent = function (elem) {
    var sort_type = elem.attr('data-sorting-type');
    var sort_key = elem.attr('data-key');
    var sortable = new_sortable.length == 0 ? contents : new_sortable;   

    settings.sort_type = sort_key;
    exports.saveSettings();

    if (! settings.disable_map) {
        exports.slideDownContents(sortable, sort_key);
    } else {
        exports.filter(true);
    }
}

exports.dateFilter = function (type) {
    settings.show_from = type;
    exports.saveSettings();

    if (! settings.disable_map) {
        exports.filterByCountry();
        exports.filterByCategory();
        exports.filterByDate(type);
        exports.removeMarkers();
    } else {
        exports.filter(true);
    }   
}

exports.jumpToCountry = function (elem) {
    var country_name = elem.attr('data-country-name');
    var country_code = elem.attr('data-country-code');
    var country_zoom = {'IL': 8, 'NZ': 6, 'RO': 7, 'UA': 7, 'GB': 6, 'RU': 4, 'US': 4, 'NL': 7};
    var zoom = typeof country_zoom[country_code] !== 'undefined' ? country_zoom[country_code] : 4;

    settings.country_code = country_code;
    settings.country_name = country_name;
    exports.saveSettings();   

    if (! settings.disable_map) {
        exports.updateListing(new_markers);
        disable_zoom_changed_listener = true;
        geocoder.geocode({'address': country_name}, function (results, status) {
            if (status === google.maps.GeocoderStatus.OK) {
                map.setCenter(results[0].geometry.location);
                map.setZoom(zoom);
                disable_zoom_changed_listener = false;
                exports.mapFilter(map);                          
            } else {
                console.log(status);
            }
        });
    } else {
        exports.filter(true);
    }    
}

exports.filterByCountry = function (countryCode) {
    countryCode = countryCode ? countryCode : settings.country_code;

    if (countryCode != 'worldwide') {
        filtered_contents = _.filter(contents, function (item) {
            return item.cc == countryCode;
        });

        if (filtered_contents.length < settings.total_slots) {
            filtered_contents = contents;            
        }

    } else {
        filtered_contents = contents;
    }
}

exports.filter = function (loader, url) {
    url = url ? url : '/api/contents';

    if (loader) {
        $('.loader-backdrop').show();
        $('#content-thumbnail-'+ (settings.total_slots - 1)).nextAll().remove();
    }

    if (url != '/api/contents') {
        exports.loadingButton($('#viewMore'));
    }

    $.getJSON(url, {}, function (response) {
        filtered_contents = url != '/api/contents' ? filtered_contents.concat(response.items) : response.items;

        exports.slideDownContents(filtered_contents);        

        if (response.next_page_url) {
            $('#viewMoreWrapper').removeClass('hidden');
            $('#viewMore').attr('data-url', response.next_page_url);
        } else {
            $('#viewMoreWrapper').addClass('hidden');
        }

         if (loader) {
            $('.loader-backdrop').hide();
        }
    });
}