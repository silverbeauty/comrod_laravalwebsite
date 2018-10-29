<div id="{{ $is_ajax ? 'video-ajax' : 'video' }}" style="width:100%;height:1005;"></div>
<script>
    var sources = {!! json_encode($content->jwplayer_files) !!};
    var playerInstance = jwplayer("{{ $is_ajax ? 'video-ajax' : 'video' }}");
    playerInstance.setup({
        key: 'yzq0qsurBaZI0V9gT7u1n2cqKUn5fE60WDu8OQ==',
        autostart: true,
        playlist: [{
                sources: sources
        }],
        primary: "html5",
        width: '100%',
        aspectratio: "16:9"
    });    
</script>