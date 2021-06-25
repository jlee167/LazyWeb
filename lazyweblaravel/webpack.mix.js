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


mix.js('resources/js/auth.js', 'public/js');
mix.js('resources/js/full-page-scroll.js', 'public/js');
mix.js('resources/js/jwt.js', 'public/js');

mix.js('resources/js/page-specific/main.js', 'public/js');
mix.js('resources/js/page-specific/forum.js', 'public/js');
mix.js('resources/js/page-specific/login.js', 'public/js');
mix.js('resources/js/page-specific/login-oauth-ui.js', 'public/js');
mix.js('resources/js/page-specific/support.js', 'public/js');
mix.js('resources/js/page-specific/register.js', 'public/js');

mix.js('resources/js/tests/sql-injection.js', 'public/js');


mix.postCss('resources/css/chatbox.css', 'public/css', []);
mix.postCss('resources/css/footer.css', 'public/css', []);
mix.postCss('resources/css/layout_common.css', 'public/css', []);
mix.postCss('resources/css/resume.css', 'public/css', []);
mix.postCss('resources/css/login.css', 'public/css', []);
mix.postCss('resources/css/dashboard.css', 'public/css', []);
mix.postCss('resources/css/support.css', 'public/css', []);
mix.postCss('resources/css/main.css', 'public/css', []);
mix.postCss('resources/css/register.css', 'public/css', []);
mix.postCss('resources/css/full-page-scroll.css', 'public/css', []);
