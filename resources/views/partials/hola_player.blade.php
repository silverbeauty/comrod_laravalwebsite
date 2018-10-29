<video id="{{ $is_ajax ? 'video-ajax' : 'video' }}" class="video-js vjs-default-skin vjs-big-play-centered">
     
</video>
<script>
    $(function () {
        var src = {!! json_encode($content->video_files['files']) !!};
        
        var player = videojs("{{ $is_ajax ? 'video-ajax' : 'video' }}", {
            controls: true,
            autoplay: true,
            preload: 'auto',
            plugins: {
                videoJsResolutionSwitcher: {
                    default: 'high',
                    dynamicLabel: false
                }
            }
        });

        player.updateSrc(src)

        player.on('resolutionchange', function(){
            console.info('Source changed to %s', player.src())
        });

        player.play();
        
    });
    
</script>