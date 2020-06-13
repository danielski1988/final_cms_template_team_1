let mix = require('laravel-mix');

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

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/scss/app2.css')
   .styles('public/scss/app2.css',
    'public/css/app2.css')
    .styles(['resources/assets/css/attendance.css'], 'public/css/attendance.css')
    .styles(['resources/assets/css/classteacher.css'], 'public/css/classteacher.css');