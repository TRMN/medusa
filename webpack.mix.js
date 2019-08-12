let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application, as well as bundling up your JS files.
 |
 */
mix.js('resources/js/app.js', 'public/js/')
    .scripts([
        'resources/js/jquery.min.js',
        'node_modules/bootstrap-sass/assets/javascripts/bootstrap.min.js',
        'resources/js/reveal.min.js',
        'resources/js/jquery-ui.min.js',
        'resources/js/jquery.autocomplete.min.js',
        'resources/js/selectize.min.js',
        'resources/js/js.cookie.min.js',
        'resources/js/rcswitcher.min.js',
], 'public/vendor.js')
    .sass('resources/scss/app.scss', 'public/css/app.css')
    .sass('resources/scss/overrides.scss', 'public/css/overrides.css')
    .styles([
        'resources/scss/bootstrap.css',
        'resources/scss/jquery-ui.css',
        'resources/scss/normalize.min.css',
        'resources/scss/jquery.ui.datepicker.min.css',
        'resources/scss/selectize.css',
        'resources/scss/selectize.bootstrap3.css',
        'resources/scss/font-awesome.css',
        'node_modules/bootstrap-block-grid/dist/bootstrap3-block-grid.min.css'
], 'public/css/vendor.css');

