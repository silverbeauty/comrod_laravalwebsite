
    <div
        class="flow-player functional"
        data-swf="{{ asset('flowplayer.swf') }}"
        data-key="$108835620266723"
    >
        <video autoplay preload poster="{{ $content->video_poster_url }}">


              <script src="//player.h-cdn.com/player_vjs5.js"></script>


            <div><h1>Video tag with Hola player - playing HDS without HolaCDN</h1></div>
            <video preload="none" class="video-js vjs-default-skin" width="640" height="360" controls>
              <source src="http://player.h-cdn.org/static/hds/manifest.f4m" type="application/adobe-f4m">
            </video>
            <script>
              (function(){
                  window.hola_player(function(player){
                      player.init({tech: 'html5'});
                  });
              })();
            </script>
  



        </video>
    </div>
@endif
