<script type="text/javascript">
    flowplayer("#flowplayer", js_vars.settings.flowplayer_settings).one("ready", function (e, api, video) {
        // http://demos.flowplayer.org/api/starttime.html#t={seconds}
        var hash = window.location.hash,
            pos = hash.substr(3);;
     
        if (hash.indexOf("#t=") === 0 && !isNaN(pos)) {
          // 1 decimal precision
          pos = Math.round(parseFloat(pos) * 10) / 10;
          if (pos < video.duration) {
            api.seek(pos);
          }
        }
     
      });
</script>