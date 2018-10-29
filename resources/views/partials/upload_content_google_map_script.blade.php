<script>
    var map;
    var marker;
    var geocoder           

    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 7,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        geocoder = new google.maps.Geocoder();

        geocodeAddress();

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
                window.alert("Autocomplete's returned place contains no geometry");
                return;
            }

            // If the place has a geometry, then present it on a map.
            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17);  // Why 17? Because it looks good.
            }

            marker.setMap(null);

            marker = new google.maps.Marker({
                map: map,
                position: place.geometry.location,
                draggable: true,
                title: 'Drag Me!',
                icon: '{{ asset("images/categories/icon_8.png") }}'
            });

            //setLatLng(marker.getPosition());
            //geocodeLatLng(marker.getPosition());

            marker.addListener('dragend', function () {
                setLatLng(marker.getPosition());
                geocodeLatLng(marker.getPosition());                    
            });                
        });
        
        $('#pac-input').removeClass('hidden');
        $('body').append('<input id="pac-input" class="form-control disable-enter-key hidden" type="text" placeholder="Search Google Maps">');               
    }

    function geocodeAddress()
    {
        var address = $('input[name="city_name"]').val()+' '+ $('select[name="region_code"] option:selected').text() +' '+ $('select[name="country_code"] option:selected').text();
        //console.log(address);
        geocoder.geocode({'address': address}, function(results, status) {
            if (status === google.maps.GeocoderStatus.OK) {
                map.setCenter(results[0].geometry.location);
                marker = new google.maps.Marker({
                    map: map,
                    position: results[0].geometry.location,
                    draggable: true,
                    title: 'Drag Me!',
                    icon: '{{ asset("images/categories/icon_8.png") }}'
                });

                //setLatLng(marker.getPosition());
                //geocodeLatLng(marker.getPosition());

                marker.addListener('dragend', function () {
                    setLatLng(marker.getPosition());
                    geocodeLatLng(marker.getPosition());
                });
            } else {
                console.log('Geocode was not successful for the following reason: ' + status);
            }
        });
    }

    function geocodeLatLng(position)
    {
        var latlng = {lat: position.lat(), lng: position.lng()};
        geocoder.geocode({'location': latlng}, function(results, status) {
            if (status === google.maps.GeocoderStatus.OK) {
                if (results[1]) {
                    var addresses = results[1].address_components;
                    var total_addresses = addresses.length;
//console.log(results[1]);
                    for (var key in addresses) {
                        if (addresses.hasOwnProperty(key)) {
                            var long_name = addresses[key]['long_name'];
                            var short_name = addresses[key]['short_name'];

                            if (
                                addresses[key]['types'][0] == 'locality' ||
                                key == 0
                            ) {
                                $('input[name="city_name"]').val(long_name);
                            }

                            if (addresses[key]['types'][0] == 'country') {
                                $('select[name="country_code"] option[value='+short_name+']').prop('selected', true);
                                $('select[name="country_code"]')
                                .val(short_name)
                                .trigger('chosen:updated');                                
                            }
                        }
                    }

                    $('input[name="address"]').val(results[1].formatted_address);

                } else {
                    console.log('No results found');
                }
            } else {
                console.log('Geocoder failed due to: ' + status);
            }
        });
    }

    function setLatLng(position) {
        $('input[name="latitude"]').val(position.lat());
        $('input[name="longitude"]').val(position.lng());
    }

    function setAddress() {
        var latlng = {lat: parseInt($('input[name="latitude"]').val()), lng: parseInt($('input[name="longitude"]').val())};     
        geocoder.geocode({'location': latlng}, function(results, status) {
            if (status === google.maps.GeocoderStatus.OK) {
                if (results[1]) {
                    $('input[name="address"]').val(results[1].formatted_address);
                } else {
                    console.log('No results found');
                }
            } else {
                console.log('Geocoder failed due to: ' + status);
            }
        });
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.browser_api_key') }}&libraries=places&callback=initMap" async defer></script>