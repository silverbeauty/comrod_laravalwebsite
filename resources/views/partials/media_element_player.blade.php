<video id="{{ $is_ajax ? 'video-ajax' : 'video' }}" controls="controls" width="100%" height="503">
     
</video>
<script>
    $(function () {
        var sources = {!! json_encode($content->video_files['files']) !!};
        
        var player = new MediaElementPlayer("{{ $is_ajax ? 'video-ajax' : 'video' }}", {
            features: ['playpause','progress','current','duration','tracks','volume','fullscreen'],
            type: ['video/mp4', 'application/x-mpegurl'],
            success: function (media, node, player) {                
                media.setSrc(sources);
                media.load();
                media.play();

                $('#' + node.id + '-mode').html('mode: ' + media.pluginType);
            }
        });       
        
    });
    
</script>