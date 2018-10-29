@if (count($flowplayer_settings['clip']['qualities']))
    <div id="{{ $is_ajax ? 'flowplaye-ajax' : 'flowplayer' }}"></div>
    <script type="text/javascript">
    $(function () {
        var settings = {!! json_encode($flowplayer_settings) !!};
        
        flowplayer("#{{ $is_ajax ? 'flowplaye-ajax' : 'flowplayer' }}", settings).one("ready", function (e, api, video) {
            // http://demos.flowplayer.org/api/starttime.html#t={seconds}
            
            var QueryString = function () {
              // This function is anonymous, is executed immediately and 
              // the return value is assigned to QueryString!
              var query_string = {};
              var query = window.location.search.substring(1);             
              var vars = query.split("&");
              for (var i=0;i<vars.length;i++) {
                var pair = vars[i].split("=");
                    // If first entry with this name
                if (typeof query_string[pair[0]] === "undefined") {
                  query_string[pair[0]] = decodeURIComponent(pair[1]);
                    // If second entry with this name
                } else if (typeof query_string[pair[0]] === "string") {
                  var arr = [ query_string[pair[0]],decodeURIComponent(pair[1]) ];
                  query_string[pair[0]] = arr;
                    // If third or later entry with this name
                } else {
                  query_string[pair[0]].push(decodeURIComponent(pair[1]));
                }
              } 
              return query_string;
            }();

            var pos = QueryString.t;

            if (pos) {
                // 1 decimal precision
                pos = Math.round(parseFloat(pos) * 10) / 10;
                if (pos < video.duration) {
                    api.seek(pos);
                }
            }

            if (window.hola_cdn) {
               window.hola_cdn.init();
            } else {
               window.hola_cdn_on_load = true;
            }
        });
    });
    </script>
@else
    <div
        class="flow-player functional"
        data-swf="{{ asset('flowplayer.swf') }}"
        data-key="$108835620266723"
    >    
        <video autoplay preload poster="{{ $content->video_poster_url }}">
            <source type="video/mp4" src="{{ $content->video_default_url }}">                                
        </video>
    </div>
@endif