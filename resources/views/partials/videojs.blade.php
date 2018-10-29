<video id="{{ $is_ajax ? 'video-ajax' : 'video' }}" class="video-js vjs-default-skin vjs-big-play-centered">
     
</video>
<script>
    $(function () {
        var src = {!! json_encode($content->video_files['files']) !!};
        
        videojs("{{ $is_ajax ? 'video-ajax' : 'video' }}", {
            controls: true,
            autoplay: true,
            preload: 'auto',
            techOrder: ['flash'],
            plugins: {
                videoJsResolutionSwitcher: {
                    default: 'high',
                    dynamicLabel: false
                }
            }
        }, function(){
            var player = this;
            window.player = player

            player.updateSrc(src)

            player.on('resolutionchange', function(){
                console.info('Source changed to %s', player.src())
            })

        }).play();
        
    });
    
</script>