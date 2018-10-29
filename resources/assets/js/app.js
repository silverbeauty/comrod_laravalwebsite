//window.$ = window.jQuery = require('jquery');
//require('jquery-ui/autocomplete.js');
//require('jquery-ui/effect-slide.js');
require('bootstrap');
require('sweetalert');
require('icheck');
//require('chosen/chosen.jquery.min.js');
//require('video.js');
//var autosize = require('autosize');
//var _ = require('underscore');

var Dropzone = require('dropzone');

Dropzone.autoDiscover = false;

var dropzone_files = [];

var module = require('./modules.js');

if (typeof js_vars !== 'undefined') {
    if (! js_vars.settings.disable_map) {
        window.mapCallback = function () {
            module.initMap(js_vars.settings);
        };
    } else {
        if (js_vars.settings.init_settings) {
            module.initSettings(js_vars.settings);
        }

        module.filter(false);
    }    
}

var delay = (function(){
  var timer = 0;
  return function(callback, ms){
    clearTimeout (timer);
    timer = setTimeout(callback, ms);
  };
})();

$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
        }
    });

    _.templateSettings.variable = 'rc';    

    swal.setDefaults({
        confirmButtonColor: '#23a9dc'
    });    
    
    module.chosenSelect();
    module.ajaxChosen();
    module.scroll();

    var flowplayer_elem = $('.flow-player');

    if (flowplayer_elem.length) {
        flowplayer_elem.flowplayer();
    }

    $('.datepicker').datetimepicker({
        format: 'YYYY-MM-DD',
    });

    $('.timepicker').datetimepicker({
        format: 'HH:mm:ss',        
    });

    $("img.lazy").lazyload({
        effect: 'fadeIn'
    });

    // $(window).bind("load", function() {
    //     var timeout = setTimeout(function() {
    //         $("img.lazy-sporty").trigger("sporty")
    //     }, 5000);
    // });
    
    $('.ellipsis').ellipsis({
        lines: 1,
        responsive: true
    });

    
    $('#viewMore').click(function () {
        module.filter(false, $(this).attr('data-url'));
    });
    
    
    // $(window).scroll(function () {
    //     var $this = $(this);
    //     var scrollTop = $this.scrollTop();        
    //     var innerHeight = $this.innerHeight();
    //     var scrollHeight = $('body')[0].scrollHeight;
    //     //console.log(scrollTop + ' ' + innerHeight + ' ' + scrollHeight);

    //     if ((scrollTop + innerHeight) >= scrollHeight) {
    //         for (var i = 0; i <= 3; i++) {
    //             $('#carousel-item-0 .thumbnail-wrapper').each(function(key, item) {
    //                 var item = $(item);

    //                 if (item.is(':hidden')) {
    //                     item.removeClass('hidden');
    //                     module.loadImages(item.find('img'), '#main-content-carousel');
    //                     return false;
    //                 }
    //             });

    //             $('#carousel-item-0 .thumbnail-wrapper').each(function(key, item) {
    //                 var item = $(item);

    //                 if (item.is(':visible')) {
    //                     module.loadImages(item.find('img'));                
    //                 }
    //             });
    //         }
    //     }        
    // });

    $('#main-content-carousel').on('scroll', function () {
        var $this = $(this);
        var scrollTop = $this.scrollTop();
        var innerHeight = $this.innerHeight();
        var scrollHeight = $this[0].scrollHeight;

        //console.log(scrollTop + ' ' + innerHeight + ' ' + scrollHeight);

        if ((scrollTop + innerHeight) >= scrollHeight) {
            var counter = 0;
            $('#carousel-item-0 .thumbnail-wrapper').each(function(key, item) {
                var item = $(item);

                if (item.is(':hidden')) {
                    item.removeClass('hidden');
                    module.loadImages(item.find('img'), '#main-content-carousel');
                    counter++

                    if (counter == 2) {
                        return false;
                    }
                }
            });
        }

        $('#carousel-item-0 .thumbnail-wrapper').each(function(key, item) {
            var item = $(item);

            if (item.is(':visible')) {
                module.loadImages(item.find('img'));                
            }
        });
    });

    $('body').on('mouseover', '.Listing .Thumbnail', function () {
        var elem = $(this);
        var marker_id = elem.attr('data-marker-id');

        $('.Thumbnail').removeClass('hovered');

        module.hoverMarker(marker_id);
    });

    $('body').on('mouseout', '.Listing .Thumbnail', function () {
        var elem = $(this);
        var marker_id = elem.attr('data-marker-id');

        $('.Thumbnail').removeClass('hovered');
        
        module.unhoverMarker(marker_id);
    });

    $('body').on('click', '#main-content-carousel .carousel-control', module.carousel);

    $('input[name="hide_watched"]').click(function () {
        var elem = $(this);

        module.hideWatched(elem);
    });

    $('.show-all-categories-on-map').click(function () {
        var checkboxes = $('.category-filter input[type="checkbox"]');

        $('.category-filter').removeClass('active');

        checkboxes.prop('checked', false);
        module.resetMapCategoryFilter();
    });

    $('.category-filter').click(function (e) {
        e.preventDefault();
        var elem = $(this);      
        module.mapCategoryFilter(elem);
    });

    $('#search-input').keyup(function (e) {
        var value = $(this).val();

        delay(function () {
            module.search(value);
        }, 500);
    });

    $('body').on('click', '.content-sorting', function () {
        var elem = $(this);
        module.sortContent(elem);         
    });

    $('.country-map-trigger').click(function (e) {
        e.preventDefault();
        var elem = $(this);
        module.jumpToCountry(elem);
    });

    $('body').on('click', '.show-from-filter', function (e) {
        e.preventDefault();
        var elem = $(this);
        var filter_type = elem.attr('data-filter-type');

        module.dateFilter(filter_type);        
    });

    $('.modal').on('show.bs.modal', function (e) {
        var elem = $(this);
        var info_message = elem.data('bs.modal') ? elem.data('bs.modal').options.info_message : null;
        var trigger = $(e.relatedTarget);
        var content = trigger.data('content');       

        elem.find('.alert').addClass('hidden');
        module.chosenSelect();

        if (info_message) {           
            var alert_info = elem.find('.alert-info');

            alert_info.removeClass('hidden');
            alert_info.html(info_message);
        }

        if (typeof content !== 'undefined') {            
            for (var key in content) {
                if (content.hasOwnProperty(key)) {
                    elem.find('*[name="'+key+'"]').val(content[key]);

                    if (key == 'checkboxes') {
                        elem.find('input[type="checkbox"]').prop('checked', false);
                        var checkboxes = content[key];
                        for (var c_key in checkboxes.data) {
                            if (checkboxes.data.hasOwnProperty(c_key)) {
                                $('input[type="checkbox"]#'+checkboxes.id_prefix+'-'+checkboxes.data[c_key][checkboxes.key]).prop('checked', true);
                            }
                        }
                    }                 
                }
            }            
        }

        var zIndex = 1040 + (10 * $('.modal:visible').length);
        $(this).css('z-index', zIndex);
        setTimeout(function() {            
            $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
        }, 0);
    });

    $('.modal').on('hidden.bs.modal', function () {
        var elem = $(this);
        var attributes = elem.data('attributes');
        elem.data('bs.modal', null);

        if (elem.attr('id') == 'contentModal') {
            window.history.back();
        }

        if (attributes && attributes.clearOnClose) {
            elem.find('.clearable').html('')
        }

        $('.modal').each(function () {
            var $this = $(this);

            if ($this.is(':visible')) {
                $('body').addClass('modal-open');
                return;
            }
        });

        elem.modal('hide');

        if (global_js_vars.player == 'videojs') {
            videojs('video-ajax').dispose();
        }
    });

    $('body').on('click', '.confirm-action', function (e) {
        e.preventDefault();
        var elem = $(this);
        module.actionConfirm(elem);
    });

    $('body').on('click', '.checkbox-ajax', function () {
        var elem = $(this);
        var data = JSON.parse(elem.attr('data-ajax-data'));
        var loader = elem.next('.fa-spinner');

        if (elem.is(':checked')) {
            data.remove = false;
        }

        module.ajaxStartStop(function () {
            loader.removeClass('hidden');
        }, function () {
            loader.addClass('hidden');
            $(this).unbind('ajaxStart');
        });
        
        
        module.ajax(data, elem, function (elem, response) {            
            module.swalSuccess(response.success_title, response.success_body);
        });
    });    

    autosize($('textarea'));

    $('.show').click(function () {
        var elem = $(this);
        var parent = $(elem.attr('data-parent'));
        var hidden_element = parent.find('.hidden-element');
        if (hidden_element.is(':visible')) {
            hidden_element.addClass('hidden');
            elem.find('.fa').removeClass('fa-chevron-circle-up').addClass('fa-chevron-circle-down');
        } else {
            hidden_element.removeClass('hidden');
            elem.find('.fa').removeClass('fa-chevron-circle-down').addClass('fa-chevron-circle-up');
        }
    });

    $('input.icheck').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass: 'iradio_flat-blue'
    });

    $('textarea.select-all').focus(function () {
        var elem = $(this);
        elem.select();

        // Work around Chrome's little problem
        elem.mouseup(function() {
            // Prevent further mouseup intervention
            elem.unbind("mouseup");
            return false;
        });
    });

    $('.focus-trigger').click(function () {
        var elem = $(this);
        $(elem.attr('data-target-focus')).focus();
    });

    $('body').on('click', '.custom-checkbox', function () {
        var elem = $(this);
        var checkbox = elem.find('input[type="checkbox"]');

        if (checkbox.is(':checked')) {
            elem.addClass('active');
        } else {
            elem.removeClass('active');
        }
    });

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {        
        $($(e.target).attr('data-target-focus')).focus();
    })

    $('input[type="checkbox"]').click(function () {
        var elem = $(this);
        var hidden_element = elem.attr('data-hidden-element');

        if (typeof hidden_element !== 'undefined') {
            $(hidden_element).addClass('hidden');

            if (elem.is(':checked')) {
                $(hidden_element).removeClass('hidden');
            }
        }
    });

    $('.date-select').change(function () {
        var elem = $(this);
        var prefix = elem.attr('data-prefix');
        var hidden_element = $('#'+elem.attr('data-hidden-element'));
        var day = $('select[data-type="'+prefix+'-day"]').val();
        var month = $('select[data-type="'+prefix+'-month"]').val();
        var year = $('select[data-type="'+prefix+'-year"]').val();

        hidden_element.val(year+'-'+month+'-'+day);
    });

    $('body').on('change', 'select.broken-data', function () {
        var elem = $(this);
        var type = elem.attr('data-type');
        var target_name = elem.attr('data-target-name');
        var dependency = JSON.parse(elem.attr('data-dependency-names'));

        for (var key in dependency) {
            if (dependency.hasOwnProperty(key)) {
                dependency[key] = $('select[name="'+dependency[key]+'"]').val();
            }
        }

        if (type == 'date') {
            $('input[name="'+target_name+'"]').val(dependency['year'] + '-' + dependency['month'] + '-' + dependency['day']);
        } else if (type == 'time') {
            $('input[name="'+target_name+'"]').val(dependency['hour'] + ':' + dependency['minute'] + ':' + (typeof dependency['second'] !== 'undefined' ? dependency['second'] : '00'));
        }

    });

    $('body').on('click', '.btn-ajax', function (e) {
        e.preventDefault();
        var elem = $(this);
        var data = typeof elem.attr('data-ajax-data') !== 'undefined' ? JSON.parse(elem.attr('data-ajax-data')) : null;
        var callbacks = [];
        callbacks['likeDislike'] = module.likeDislikeCallback;        

        var callback = callbacks.hasOwnProperty(elem.attr('data-callback')) ? callbacks[elem.attr('data-callback')] : null;

        module.loadingButton(elem);
        module.ajax(data, elem, callback);

    });

    $('body').on('submit', '.form-ajax', function (e) {
        e.preventDefault();
        var elem = $(this);
        var offence_date = elem.find('input[name="offence_date"]');
        var country_code = elem.find('select[name="country_code"]');
        var latitude = elem.find('input[name="latitude"]');
        var longitude = elem.find('input[name="longitude"]');
        var confirm_location = false;
        var confirm_date = false;
        var confirm_location_title;
        var confirm_location_body;
        var confirm_location_button_text;
        var confirm_date_title;
        var confirm_date_body;
        var confirm_date_button_text;

        if (
            typeof latitude !== 'undefined' && latitude.val() == '' &&
            typeof longitude !== 'undefined' && longitude.val() == ''
        ) {
            confirm_location = true;
            confirm_location_title = elem.data('no-location-confirm-title');
            confirm_location_body = elem.data('no-location-confirm-body');
            confirm_location_button_text = elem.data('no-location-confirm-button-text');
        }

        if (typeof offence_date !== 'undefined' && offence_date.val() == '') {
            confirm_date = true;
            confirm_date_title = elem.data('no-date-confirm-title');
            confirm_date_body = elem.data('no-date-confirm-body');
            confirm_date_button_text = elem.data('no-date-confirm-button-text');
        }

        if (confirm_location || confirm_date) {
            if (confirm_location) {
                var close = confirm_date ? false : true; 
                module.swalConfirm(confirm_location_title, confirm_location_body, confirm_location_button_text, function () {
                    if (confirm_date) {
                        module.swalConfirm(confirm_date_title, confirm_date_body, confirm_date_button_text, function () {
                            module.loadingButton(elem.find('.btn'));
                            module.ajax(elem.serialize(), elem);
                        });
                    } else {
                        module.loadingButton(elem.find('.btn'));
                        module.ajax(elem.serialize(), elem);
                    }
                }, false, close);
            } else {                    
                module.swalConfirm(confirm_date_title, confirm_date_body, confirm_date_button_text, function () {
                    module.loadingButton(elem.find('.btn'));
                    module.ajax(elem.serialize(), elem);
                });                    
            }
        } else {
            module.loadingButton(elem.find('.btn'));
            module.ajax(elem.serialize(), elem);            
        }
    });

    $('body').on('click', '.show-trigger', function () {
        var elem = $(this);
        var hidden_element = $(elem.attr('data-hidden-element'));
        var focusable = $(elem.attr('data-focusable'));
        var collapsable_element = $(elem.attr('data-collapsable-element'));
        var hidable_element = $('.hidable-element');
        
        hidable_element.addClass('hidden');
        hidden_element.removeClass('hidden');
        collapsable_element.find('> .form-wrapper').toggleClass('hidden');

        if (typeof focusable !== 'undefined') {
            focusable.focus();
        }

        collapsable_element.collapse('show');        
        
    });

    $('body').on('click', '.hide-trigger', function () {
        $($(this).attr('data-hidable-target')).addClass('hidden');
    });

    $('body').on('click', '.collapse-trigger', function () {
        var target = $($(this).data('collapse-target'));
        target.collapse('hide');
        target.find('input[type=text]').val('');
    });

    $('body').on('click', '.login-modal', function () {
        var elem = $(this);

        $('#loginModal').modal({
            backdrop: 'static',
            info_message: elem.data('info-message')
        })
    }); 

    $('body').on('keydown.autocomplete', '.Autocomplete input', function () {
        var elem = $(this);
        var url = elem.attr('data-url');
        var data = elem.attr('data');
        var custom_response = elem.data('custom-response');
        var multiple = elem.data('multiple');
        var loader = elem.parent().find('.loader');           
        
        data = typeof data !== 'undefined' ? JSON.parse(data) : {};
        multiple = typeof multiple !== 'undefined' ? multiple : false;

        for (var key in data) {
            if (data.hasOwnProperty(key)) {
                data[key] = $('*[name="'+data[key]+'"]').val();
            }
        }

        var results = elem.autocomplete({
            source: function (request, response) {
                data.term = multiple ? module.extractLast(request.term) : request.term;
                loader.removeClass('hidden');

                var request = $.ajax({
                    type: 'get',
                    url: url,
                    data: data,
                    dataType: 'json'           
                });

                request.done(function (data) {                        
                    loader.addClass('hidden');
                    response(data);                                       
                });              
            },
            minLength: 2,
            focus: function () {
                return multiple ? false : true;
            },
            select: function (event, ui) {
                if (multiple) {
                    var terms = module.split( this.value );
                    terms.pop();
                    terms.push( ui.item.value );
                    terms.push( "" );
                    this.value = terms.join( ", " );
                    return false;
                }

                return true;
            },
            appendTo: elem.next()
        });

        if (typeof custom_response !== 'undefined') {
            var custom_responses = [];
            custom_responses['user_search'] = module.autocompleteSearchUsers
            results.data('ui-autocomplete')._renderItem = custom_responses[custom_response];
        }        
    });    
    
    $('.modal').on('shown.bs.modal', function (e) {
        var button = $(e.relatedTarget);
        var attribute = button.data('attribute');

        if (attribute && attribute.map_element_id) {
            module.initMap(button.data('attribute'));
        }            
    });    
    
    $('body').on('change', 'select.country', function () {
        var elem = $(this);
        var countries_need_state = JSON.parse(elem.attr('data-countries-need-state'));
        var region_parent = $(elem.attr('data-region-parent'));
        var city_parent = $(elem.attr('data-city-parent'));
        var region = region_parent.find('select');
        var city = city_parent.find('input[name="city_name"]');
        var get_regions_url = elem.attr('data-get-regions-by-country-url');
        var clear_city = elem.data('clear-city');

        clear_city = typeof clear_city !== 'undefined' ? clear_city : true;
        region_parent.addClass('hidden');
        region.empty();

        if (clear_city) {
            city.val('');
        }
        
        if (typeof countries_need_state !== 'undefined') {
            for (var key in countries_need_state) {
                if (countries_need_state.hasOwnProperty(key)) {
                    if (countries_need_state[key] == elem.val()) {
                        region_parent.removeClass('hidden');                        

                        $.ajax({
                            type: 'get',
                            data: {country_code: elem.val()},
                            url: get_regions_url,
                            dataType: 'json'
                        }).done(function (response) {
                            $.map(response, function (item) {
                                region.append('<option value="'+item.code+'">'+item.name+'</option>');
                            });

                            region.trigger('chosen:updated');
                        });

                    }
                }
            }
        }
    });

    $('body').on('change', 'select[data-live-search="true"]', function () {
        var elem = $(this);
        var url = elem.attr('data-url');
        var dependency = JSON.parse(elem.attr('data-dependency'));
        var options = JSON.parse(elem.attr('data-target-options'));
        var target = $(elem.attr('data-target'));
        var data = {};

        target.html('<option></option>');

        for (var key in dependency) {
            if (dependency.hasOwnProperty(key)) {
                data[key] = $(dependency[key]).val();
            }
        }

        $.ajax({
            type: 'get',
            data: data,
            url: url,
            dataType: 'json'
        }).done(function (response) {
            $.map(response, function (item) {
                target.append('<option value="'+item[options.value]+'">'+item[options.label]+'</option>');
            });

            target.trigger('chosen:updated');
        });
    });
    
    $('body').on('click', '.popup', function (e) {
        var winHeight = 350;
        var winWidth = 520;
        var winTop = (screen.height / 2) - (winHeight / 2);
        var winLeft = (screen.width / 2) - (winWidth / 2);
        var elem = $(this);

        window.open(elem.attr('data-url'), 'sharer', 'top=' + winTop + ',left=' + winLeft + ',toolbar=0,status=0,width=' + winWidth + ',height=' + winHeight);
    });

    $('body').on('click', '.add-element', function (e) {
        var elem = $(this);        
        var dependency = elem.attr('data-dependency');
        var counter = $(elem.attr('data-counter'));
        var total_count = parseInt(counter.val());
        var data = typeof dependency != 'undefined' ? JSON.parse(dependency) : {};

        data.id = total_count + 1;
        counter.val(data.id);

        module.addElement(elem, data);
    });

    $('body').on('click', '.remove-element', function (e) {
        var elem = $(this);
        var counter = $(elem.attr('data-counter'));
        var total_count = parseInt(counter.val());
        var removable = elem.closest('.removable');

        removable.fadeOut('slow', function () {
            removable.remove();
            counter.val(total_count - 1);
        });
    });    

    $('body').on('click', '.reset-input', function () {
        var elem = $(this);
        var inputs = elem.attr('data-input-names').split(',');

        for (var i = 0; i < inputs.length; i++) {
            $('input[name="'+inputs[i]+'"]').val('');
        }
    });

    $('body').on('keydown', '.disable-enter-key', function (e) {
        return e.keyCode != 13;
    });  

    if ($('.dropzone-video').length) {        
        var dropzone_video = new Dropzone('.dropzone-video', {
            paramName: 'video',
            maxFilesize: 512,
            maxFiles: 1,
            previewsContainer: '.dropzone-video-preview',
            previewTemplate: $('#dz-video-preview-template').html(),
            clickable: true,
            dictDefaultMessage: '<i class="fa fa-cloud-upload fa-2x"></i><h5>'+js_vars.dropzone_upload_text+'</h5>',
            acceptedFiles: 'video/*',
            addRemoveLinks: true,            
            url: '/upload/upload-video',
            dictRemoveFile: js_vars.dropzone_remove_video,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},        
        });

        dropzone_video.on('addedfile', function (file) {
            $('.dropzone-hidable').addClass('hidden');
            $('.dropzone-video-preview').removeClass('hidden');
            $('.dropzone-video-preview .alert-danger').addClass('hidden');
        });

        dropzone_video.on('removedfile', function (file) {
            $('.dropzone-hidable').removeClass('hidden');
            $('.dropzone-video-preview').addClass('hidden');
            $('.dropzone-dropping-area').removeClass('active');

            $.ajax({
                type: 'post',
                data: {},
                url: '/api/delete-temp-uploaded-video',
                dataType: 'json'
            });
        });

        dropzone_video.on('uploadprogress', function (file, progress) {
            $('.upload-video-progress-counter').html(Math.round(progress)+'%');            
        });

        dropzone_video.on('success', function (file, response) {
            $('input[name="embed_type"]').val('');
        });

        dropzone_video.on('error', function (file, response) {
            var alert = $('.dropzone-video-preview .alert-danger');
            alert.removeClass('hidden');
            alert.html(response.video[0]);
            //console.log(response);
        });            
    }

    if ($('.dropzone-video-thumbnail').length) {        
        var dropzone_video_thumbnail = new Dropzone('.dropzone-video-thumbnail', {
            init: function () {
                var $this = this;
                var existingFileCount = 0;
                if (js_vars.thumbnail) {
                    $.each(js_vars.thumbnail, function (key, item) {
                        var mockFile = {
                            size: null,
                            accepted: true
                        };
                        $this.emit('addedfile', mockFile);
                        $this.emit('thumbnail', mockFile, item.url);
                        $this.emit('complete', mockFile);
                        $this.files.push(mockFile);
                        existingFileCount = existingFileCount + 1;                        
                    });

                    $.each($this.files, function (key, file) {
                        $(file.previewTemplate).append('<input type="hidden" name="server_filename" value="'+file.name+'">');
                        $(file.previewTemplate).append('<input type="hidden" name="photo_id" value="'+file.photo_id+'">');
                        $(file.previewTemplate).append('<input type="hidden" name="content_id" value="'+file.contentId+'">');
                    });

                    if (existingFileCount < 1) {
                        $('.dropzone-video-thumbnail').removeClass('hidden');
                    } else {
                        $('.dropzone-photo-preview').removeClass('hidden');
                    }
                }
            },
            paramName: 'photo',
            maxFilesize: 20,
            maxFiles: 1,
            parallelUploads: 1,
            previewsContainer: '.dropzone-photo-preview',
            previewTemplate: $('#dz-photo-preview-template').html(),
            clickable: true,
            dictDefaultMessage: '<i class="fa fa-cloud-upload fa-2x"></i><h5>'+js_vars.dropzone_upload_text+'</h5>',
            acceptedFiles: 'image/*',
            addRemoveLinks: true,            
            url: '/upload/change-thumbnail',
            dictRemoveFile: js_vars.dropzone_remove_photo,
            dictMaxFilesExceeded: js_vars.dropzone_max_files_exceeded,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},        
        });

        dropzone_video_thumbnail.on('addedfile', function (file) {
            $('.dropzone-hidable').addClass('hidden');
            $('.dropzone-photo-preview').removeClass('hidden');
            $('.dropzone-photo-preview .alert-danger').addClass('hidden');
        });

        dropzone_video_thumbnail.on('removedfile', function (file) {
            var id = $(file.previewTemplate).find('input[name="photo_id"]').val();
            var contentId = $(file.previewTemplate).find('input[name="content_id"]').val();
            var filename = $(file.previewTemplate).find('input[name="server_filename"]').val();
            var request = $.ajax({
                type: 'post',
                data: {id: id, content_id: contentId, filename: filename},
                url: '/api/delete-temp-uploaded-photo',
                dataType: 'json'
            });

            //dropzone_video_thumbnail.options.maxFiles = dropzone_video_thumbnail.options.maxFiles + 1;console.log(dropzone_video_thumbnail.options.maxFiles);
            $('.dropzone-photo-preview').addClass('hidden');
            $('.dropzone-video-thumbnail').removeClass('hidden');
        });

        dropzone_video_thumbnail.on('uploadprogress', function (file, progress) {
            $('.upload-photo-progress-counter').html(Math.round(progress)+'%');            
        });

        dropzone_video_thumbnail.on('success', function (file, response) {
            $(file.previewTemplate).append('<input type="hidden" name="server_filename" value="'+response.filename+'">');
        });

        dropzone_video_thumbnail.on('error', function (file, response) {
            var alert = $(file.previewTemplate).find('.alert-danger');
            //alert.removeClass('hidden');
            //alert.html(response.photo[0]);
            //console.log(response);
        });

        dropzone_video_thumbnail.on('maxfilesexceeded', function (file) {
            $(file.previewTemplate).remove();
        });

        dropzone_video_thumbnail.on('maxfilesreached', function () {
            $('.dropzone-video-thumbnail').addClass('hidden');
        });

        dropzone_video_thumbnail.on('sending', function (file, xhr, formData) {
            formData.append('id', js_vars.content_id);
        });
    }

    if ($('.dropzone-photo').length) {        
        var dropzone_photo = new Dropzone('.dropzone-photo', {
            init: function () {
                var $this = this;
                var existingFileCount = 0;
                if (js_vars.photos) {
                    $.each(js_vars.photos, function (key, item) {
                        var mockFile = {
                            photo_id: item.id,
                            contentId: item.content_id,
                            name: item.filename,
                            size: null,
                            accepted: true
                        };
                        $this.emit('addedfile', mockFile);
                        $this.emit('thumbnail', mockFile, item.url);
                        $this.emit('complete', mockFile);
                        $this.files.push(mockFile);
                        existingFileCount = existingFileCount + 1;                        
                    });

                    $.each($this.files, function (key, file) {
                        $(file.previewTemplate).append('<input type="hidden" name="server_filename" value="'+file.name+'">');
                        $(file.previewTemplate).append('<input type="hidden" name="photo_id" value="'+file.photo_id+'">');
                        $(file.previewTemplate).append('<input type="hidden" name="content_id" value="'+file.contentId+'">');
                    });

                    if (existingFileCount < 4) {
                        $('.dropzone-photo').removeClass('hidden');
                    }
                }
            },
            paramName: 'photo',
            maxFilesize: 20,
            maxFiles: 4,
            parallelUploads: 1,
            previewsContainer: '.dropzone-photo-preview',
            previewTemplate: $('#dz-photo-preview-template').html(),
            clickable: true,
            dictDefaultMessage: '<i class="fa fa-cloud-upload fa-2x"></i><h5>'+js_vars.dropzone_upload_text+'</h5>',
            acceptedFiles: 'image/*',
            addRemoveLinks: true,            
            url: '/upload/upload-photo',
            dictRemoveFile: js_vars.dropzone_remove_photo,
            dictMaxFilesExceeded: js_vars.dropzone_max_files_exceeded,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},        
        });

        dropzone_photo.on('addedfile', function (file) {
            $('.dropzone-hidable').addClass('hidden');
            $('.dropzone-photo-preview').removeClass('hidden');
            $('.dropzone-photo-preview .alert-danger').addClass('hidden');
        });

        dropzone_photo.on('removedfile', function (file) {
            var id = $(file.previewTemplate).find('input[name="photo_id"]').val();
            var contentId = $(file.previewTemplate).find('input[name="content_id"]').val();
            var filename = $(file.previewTemplate).find('input[name="server_filename"]').val();
            var request = $.ajax({
                type: 'post',
                data: {id: id, content_id: contentId, filename: filename},
                url: '/api/delete-temp-uploaded-photo',
                dataType: 'json'
            });

            //dropzone_photo.options.maxFiles = dropzone_photo.options.maxFiles + 1;console.log(dropzone_photo.options.maxFiles);
            $('.dropzone-photo').removeClass('hidden');
        });

        dropzone_photo.on('uploadprogress', function (file, progress) {
            $('.upload-photo-progress-counter').html(Math.round(progress)+'%');            
        });

        dropzone_photo.on('success', function (file, response) {
            $(file.previewTemplate).append('<input type="hidden" name="server_filename" value="'+response.filename+'">');
        });

        dropzone_photo.on('error', function (file, response) {
            var alert = $(file.previewTemplate).find('.alert-danger');
            //alert.removeClass('hidden');
            //alert.html(response.photo[0]);
            //console.log(response);
        });

        dropzone_photo.on('maxfilesexceeded', function (file) {
            $(file.previewTemplate).remove();
        });

        dropzone_photo.on('maxfilesreached', function () {
            $('.dropzone-photo').addClass('hidden');
        });
    }

    if ($('.dropzone-avatar').length) {
        var dropzone_avatar = new Dropzone('.dropzone-avatar', {
            paramName: 'avatar',
            maxFilesize: 20,
            maxFiles: 1,
            previewsContainer: '.dropzone-avatar-preview',
            previewTemplate: $('#dz-avatar-preview-template').html(),
            clickable: '.dz-avatar-trigger',
            dictDefaultMessage: '<i class="fa fa-cloud-upload fa-2x"></i><h5>Drop files here or click to upload</h5>',
            acceptedFiles: 'image/*',
            addRemoveLinks: false,            
            url: '/upload/update-avatar',
            dictRemoveFile: 'Remove Photo',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
        });

        dropzone_avatar.on('addedfile', function (file) {
            $('.dropzone-hidable').addClass('hidden');
            $('.dropzone-avatar-preview').removeClass('hidden');            
        });

        dropzone_avatar.on('uploadprogress', function (file, progress) {
            $('.upload-avatar-progress-counter').html(Math.round(progress)+'%');            
        });

        dropzone_avatar.on('success', function (file, response) {
            $('img.avatar').prop('src', response.avatar_url);
        });

        dropzone_avatar.on('complete', function (file) {                        
            $('.dropzone-hidable').removeClass('hidden');
            $('.dropzone-avatar-preview').addClass('hidden');
            dropzone_avatar.removeFile(file);
        });

        dropzone_avatar.on('error', function (file, message, response) {
            module.swalError(response);            
        });
    }

    $('input[type="radio"].redirect').on('ifChecked', function (e) {
        var elem = $(this)
        var href = elem.data('href');
        var pjax_container = elem.data('pjax');

        // if (typeof pjax_container !== 'undefined') {
        //     return $.pjax({
        //         url: href,
        //         container: pjax_container
        //     });
        // }

        return location.href = href;
    });

    $('body').on('click', '.dropdown-menu a, .change-value, .change-label', function () {
        var elem = $(this);
        var target_label = elem.attr('data-target-label');
        var label = elem.attr('data-label');
        var key = elem.data('key');
        var sorting_type = elem.data('sorting-type');
        var parent = elem.parent();
        var grand_parent = elem.parent().parent();
        var target_flag = elem.data('target-flag');
        var target_input = elem.data('target-input');
        var icon_class = elem.data('icon-class');

        //key = typeof sorting_type !== 'undefined' ? sorting_type : key;

        if (typeof target_label !== 'undefined') {
            $(target_label).html(label);
            $(target_label).attr('data-key', key);            
            grand_parent.find('.hidden').removeClass('hidden');
            parent.addClass('hidden');
        }

        if (target_input) {
            $(target_input).val(elem.data('value'));
        }

        if (typeof target_flag !== 'undefined') {
            var flag_icon_class = 'fs14 flag-icon flag-icon-'+key;

            if (typeof icon_class !== 'undefined') {
                flag_icon_class = icon_class;
            }

            $(target_flag).removeClass().addClass(flag_icon_class);
        }
    });

    $('body').on({
        mouseenter: function () {
            var elem = $(this);
            var control = elem.find('.carousel-control');
            if (!control.hasClass('hidden')) {
                control.fadeIn('slow');
            }
        },
        mouseleave: function () {
            var elem = $(this);
            var control = elem.find('.carousel-control');
            if (!control.hasClass('hidden')) {
                control.fadeOut('slow');
            }
        }
    }, '#main-content-carousel, #photos-carousel');

    $('body').on('hide.bs.collapse', '.collapse', function (e) {
        e.stopPropagation();
        var elem = $(this);
        var trigger = elem.attr('data-trigger');

        if (typeof trigger !== 'undefined') {
            trigger = $(trigger);
            var collapse_text = trigger.attr('data-collapse-text');
            var collapse_icon = trigger.attr('data-collapse-icon');
            var in_icon = trigger.attr('data-in-icon');
            var target_icon = $(trigger.attr('data-target-icon'));

            trigger.html(collapse_text);
            target_icon.removeClass(in_icon);
            target_icon.addClass(collapse_icon);
        }
    });

    $('body').on('show.bs.collapse', '.collapse', function (e) {
        e.stopPropagation();
        var elem = $(this);
        var trigger = elem.attr('data-trigger');
        var focusable = $(elem.attr('data-focusable'));

        if (typeof focusable !== 'undefined') {
            focusable.focus();
        }

        if (typeof trigger !== 'undefined') {
            trigger = $(trigger);
            var in_text = trigger.attr('data-in-text');
            var collapse_icon = trigger.attr('data-collapse-icon');
            var in_icon = trigger.attr('data-in-icon');
            var target_icon = $(trigger.attr('data-target-icon'));

            trigger.html(in_text);
            target_icon.removeClass(collapse_icon);
            target_icon.addClass(in_icon);
        }
    });    

    $.pjax.defaults.timeout = 100000;
    

    $('body').on('click', 'a.pjax', function(event) {        
        var elem = $(this);
        var activable = elem.data('activable');        

        activable = typeof activable !== 'undefined' ? activable : false;
        
        $('a[data-pjax-container]').removeClass('active');

        if (activable) {
            elem.addClass('active');
        }
        
        $.pjax.click(event, {
            container: elem.data('pjax-container')
        });              
    });

    $(document).on('pjax:send', function () {
        $('.modal.resize').each(function () {
            var $this = $(this);

            $this.find('.loading').removeClass('hidden');
            $this.find('.close').addClass('hidden');
            $this.find('.modal-dialog')
            .removeClass('modal-lg')
            .addClass('modal-sm');
        });
    });

    $(document).on('pjax:complete', function () {
        // var reloadable_script = $('script.reloadable');
        // reloadable_script.remove();

        // reloadable_script.each(function() {            
        //     var $this = $(this);
        //     var script = document.createElement('script');
        //     var type = $this.attr('type');
        //     if (type) script.type = type;
        //     script.src = $this.attr('src');
        //     script.className = 'reloadable';
        //     $('#appJsContainer').append(script);
        // });

        $('.modal.resize').each(function () {
            var $this = $(this);

            $this.find('.loading').addClass('hidden');            
            $this.find('.modal-dialog')
            .removeClass('modal-sm')
            .addClass('modal-lg');
        });

        $('button.close').removeClass('hidden');

        $('a[data-toggle="dropdown"]').dropdown();
        $('a[data-toggle="collapse"]').collapse();

        var flowplayer_elem = $('.flow-player');

        if (flowplayer_elem.length) {
            flowplayer_elem.flowplayer();
        }
        
        if (typeof ga !== 'undefined') {
            ga('set', 'location', window.location.href);
            ga('send', 'pageview');
        }

        if (typeof _paq !== 'undefined') {
            _paq.push(['setDocumentTitle', window.title]);
            _paq.push(['setCustomUrl', window.location.href]);
            _paq.push(['trackPageView']);
        }        
    });

    $(document).on('pjax:timeout', function (event) {
        event.preventDefault();
    });

    $(document).ajaxComplete(function () {
        autosize($('textarea'));
        module.scroll();
    });    
});