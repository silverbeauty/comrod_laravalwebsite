<script>
    _.templateSettings.variable = 'rc';

    var map;
    var bounds
    var total_slots = 9;
    var marker;
    var disable_zoom_changed_listener = false;
    var markers = [];
    var geocoder;
    var info_window;
    var delay = 100;
    var contents = {!! json_encode($map_contents) !!};
    var addresses = [];
    var next_address = 0;
    var template  = _.template(`<div class="appended">
        <div id="thumbnail-<%- rc.id %>" class="Thumbnail hoverable" data-marker-id="<%- rc.id %>">
        <a href="<%- rc.url %>">
            <div class="Thumbnail__Header">
                <div>
                    <span><%- rc.title %></span>
                    <i class="flag-icon flag-icon-<%- rc.country_code.toLowerCase() %>"></i>
                </div>
                <div class="backdrop"></div>
            </div>
            <img class="img-responsive lazy" data-original="<%- rc.thumbnail_url %>">
        </a>
        <div class="nav Thumbnail__Footer">
            <ul class="nav navbar-nav">
                <li><i class="fa fa-eye"></i> <%- rc.total_views %></li>
                <li><i class="fa fa-comments"></i> <%- rc.total_comments %></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><i class="fa fa-thumbs-up"></i> <%- rc.total_rating %></li>                    
            </ul>
            <div class="backdrop"></div>
        </div>        
    </div></div>`);
    var block_template = _.template(`<% var chunked = _.chain(rc.items).groupBy(function (element, index) {
            return Math.floor(index/3);
        }).toArray().value();    
    %>
    <div id="carousel-item-<%- rc.id %>" class="Listing gutter-5 sortable-content" style="display:none">
        <% _.each(chunked, function (items, key) { %>
            <div class="row">
                <% _.each(items, function (item, key) { %>
                    <div class="col-md-4 col-sm-6 col-xs-12 caruser-each">
                        <div id="content-thumbnail-<%- key %>" data-id="<%- item.id %>" class="content-thumbnail">
                            <div id="thumbnail-<%- item.id %>" class="Thumbnail hoverable" data-marker-id="<%- item.id %>">
                                <a href="<%- item.url %>">
                                    <div class="Thumbnail__Header">
                                        <div>
                                            <span><%- item.title %></span>
                                            <i class="flag-icon flag-icon-<%- item.country_code.toLowerCase() %>"></i>
                                        </div>
                                        <div class="backdrop"></div>
                                    </div>
                                    <img class="img-responsive lazy-sporty" data-original="<%- item.thumbnail_url %>">
                                </a>
                                <div class="nav Thumbnail__Footer">
                                    <ul class="nav navbar-nav">
                                        <li><i class="fa fa-eye"></i> <%- item.total_views %></li>
                                        <li><i class="fa fa-comments"></i> <%- item.total_comments %></li>
                                    </ul>
                                    <ul class="nav navbar-nav navbar-right">
                                        <li><i class="fa fa-thumbs-up"></i> <%- item.total_rating %></li>
                                        {{-- <li><i class="fa fa-thumbs-down"></i> <%- item.total_dislikes %></li> --}}
                                    </ul>
                                    <div class="backdrop"></div>
                                </div>                                
                            </div>                                            
                        </div>
                    </div>
                <% }) %>
            </div>
        <% }) %>
    </div>`);
    var info_template = _.template(`<div class="appended">
        <div id="thumbnail-<%- rc.id %>" class="Thumbnail hoverable" data-marker-id="<%- rc.id %>">
        <a href="<%- rc.url %>">
            <div class="Thumbnail__Header">
                <div>
                    <span><%- rc.title %></span>
                    <i class="flag-icon flag-icon-<%- rc.country_code.toLowerCase() %>"></i>
                </div>
                <div class="backdrop"></div>
            </div>
            <img class="img-responsive lazy" src="<%- rc.thumbnail_url %>">
        </a>
        <div class="nav Thumbnail__Footer">
            <ul class="nav navbar-nav">
                <li><i class="fa fa-eye"></i> <%- rc.total_views %></li>
                <li><i class="fa fa-comments"></i> <%- rc.total_comments %></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><i class="fa fa-thumbs-up"></i> <%- rc.total_rating %></li>
                {{-- <li><i class="fa fa-thumbs-down"></i> <%- rc.total_dislikes %></li> --}}
            </ul>
            <div class="backdrop"></div>
        </div>        
    </div></div>`);
    var marker_clusterer = null;
    var timeout = null;
    var default_sortable = {!! json_encode(map_info($main_contents)) !!};
    var new_sortable = [];
    var cookie_settings = typeof Cookies.get('settings') !== 'undefined' ? JSON.parse(Cookies.get('settings')) : null;
    var default_lat = {{ $user_geo['latitude'] }};
    var default_lng = {{ $user_geo['longitude'] }};
    var default_zoom = {{ map_zoom_by_country_code($user_geo['country_code']) }};
    var default_sort_type = '{{ $sort_key }}';
    var default_show_from = '{{ $show_from_filter_key }}';
    var default_categories = [];
    var default_main_carousel_item = 0;
    var default_hide_watched = 0;
    var default_country_code = '{{ $default_country_code }}';
    var default_country_name = '{{ $default_country_name }}';
    var settings = {};
    var filtered_contents = contents;
    var total_categories = 0;
    var new_markers;
    var slide_left = false;
    var slide_right = false;
    var first_load = true;
    var logged = {{ $signed_in ? 1 : 0 }};
    var watched = {!! json_encode($watched) !!};

    if (cookie_settings != null) {
        default_lat = typeof cookie_settings.latitude !== 'undefined' ? cookie_settings.latitude : default_lat;
        default_lng = typeof cookie_settings.longitude !== 'undefined' ? cookie_settings.longitude : default_lng;
        default_zoom = typeof cookie_settings.zoom !== 'undefined' ? cookie_settings.zoom : default_zoom;
        default_sort_type = typeof cookie_settings.sort_type !== 'undefined' ? cookie_settings.sort_type : default_sort_type;
        default_show_from = typeof cookie_settings.show_from !== 'undefined' ? cookie_settings.show_from : default_show_from;
        default_categories = typeof cookie_settings.categories !== 'undefined' ? cookie_settings.categories : default_categories;
        default_main_carousel_item = typeof cookie_settings.main_carousel_item !== 'undefined' ? cookie_settings.main_carousel_item : default_main_carousel_item;
        default_hide_watched = typeof cookie_settings.hide_watched !== 'undefined' ? cookie_settings.hide_watched : default_hide_watched;
        default_country_code = typeof cookie_settings.country_code !== 'undefined' ? cookie_settings.country_code : default_country_code;
        default_country_name = typeof cookie_settings.country_name !== 'undefined' ? cookie_settings.country_name : default_country_name;           
    }

    settings.latitude = default_lat;
    settings.longitude = default_lng;
    settings.zoom = default_zoom;
    settings.sort_type = default_sort_type;
    settings.show_from = default_show_from;
    settings.categories = default_categories;
    settings.main_carousel_item = default_main_carousel_item;
    settings.hide_watched = default_hide_watched;
    settings.country_code = default_country_code;
    settings.country_name = default_country_name;
</script>
<script async src="{{ asset('js/homepage_map_script.js') }}"></script>