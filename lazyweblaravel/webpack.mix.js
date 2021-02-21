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
    .sass('resources/sass/app.scss', 'public/css');

//.postCss('resources/css/app.css', 'public/css', [


mix.js('resources/js/auth_helpers.js', 'public/js');
mix.js('resources/js/videojs-contrib-hls.js', 'public/js');
mix.js('resources/js/videojs-contrib-hls.min.js', 'public/js');

mix.postCss('resources/css/chatbox.css', 'public/css', [
]);

mix.postCss('resources/css/layout_common.css', 'public/css', [
]);
mix.postCss('resources/css/resume.css', 'public/css', [
]);
mix.postCss('resources/css/login.css', 'public/css', [
]);
