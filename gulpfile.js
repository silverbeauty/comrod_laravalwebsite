var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.sass('app.scss');
    mix.sass('app_ltr.scss');
    //mix.sass('flowplayer.scss');
    mix.browserify([        
        'app.js',                
    ], 'resources/assets/js/browserified.js');

    //mix.browserify('flowplayer.hlsjs.js');

    mix.scripts([
        //'jquery.min.js',
        'jquery.pjax.js',
        'jquery.lazyload.js',
        'jquery.ellipsis.js',
        'jquery-ui.js',
        'moment.js',
        'underscore.js',
        'autosize.js',
        'bootstrap-datetimepicker.js',
        'chosen.jquery.js',
        'ajax-chosen.js',
        'jquery.dataTables.js',
        'dataTables.select.js',
        'js.cookie.js',
        'markerclusterer.js',
        'metisMenu.js',
        'sb-admin.js',
        'browserified.js',                        
    ], 'public/js/app.js');

    mix.scripts([
        'jquery.min.js',
        //'jquery.pjax.js',        
        //'flowplayer.js',
        //'flowplayer.hlsjs.min.js',
        //'flowplayer.quality-selector.js',
        //'video.js',
        //'videojs-resolution-switcher.js',
        //'asf.min.js',
        //'flowplayer.init.js'        
    ], 'public/js/jquery.js');

    mix.scripts([
        'flowplayer.js',
        //'flowplayer.hlsjs.min.js',
        'flowplayer.quality-selector.js',                
    ], 'public/js/flowplayer.js');

    //mix.scriptsIn('public/js/vendor', 'public/js/app.js');

    mix.version([
        'css/app.css',
        //'css/flowplayer.css',
        'css/app_ltr.css',
        'js/app.js',
        'js/jquery.js',
        'js/flowplayer.js',
        'js/flowplayer.hlsjs.js'
    ]);
});
