const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/bootstrap.scss', 'public/css')
    .sass('resources/sass/admin.scss', 'public/css')
    .sass('resources/sass/simplelineicons.scss', 'public/css')
    .sass('resources/sass/front.scss', 'public/css')
    .options({processCssUrls: false})
    .scripts([
    'public/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js',
    'public/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js',
    'public/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js',
    'public/js/plugin/moment/moment.min.js',
    'public/js/plugin/datatables/datatables.min.js',
    'public/js/plugin/bootstrap-notify/bootstrap-notify.min.js',
    'public/js/plugin/sweetalert/sweetalert.min.js',
    'public/js/plugin/select2/select2.full.min.js'
], 'public/js/admincommon.js')
    .sourceMaps();

mix.options({processCssUrls: false})
    .scripts([
    'public/js/wow.min.js',
    'public/js/plugin/typeahead.js/typeahead.bundle.js',
    'public/js/plugin/bootstrap-notify/bootstrap-notify.min.js',
], 'public/js/frontcommon.js')
    .sourceMaps();