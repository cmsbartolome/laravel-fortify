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

// mix.js('resources/js/app.js', 'public/js')
mix.js('resources/js/custom/password_validator.js', 'public/js');
mix.js('resources/js/custom/bootstrap.js', 'public/js');
mix.js('resources/js/sb-admin-2.min.js', 'public/js')
// mix.js('resources/js/custom/jquery.easing.min.js', 'public/js')
mix.sass('resources/sass/app.scss', 'public/css');
mix.sass('resources/sass/sb-admin-2.scss', 'public/css');
//.sourceMaps();
