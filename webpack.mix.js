let mix = require('laravel-mix');
require('laravel-mix-tailwind');

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

mix.js('src/js/app.js', 'assets/js')
    .sass('src/sass/app.scss', 'assets/css')
    .sass('src/sass/style.scss', './')
    .tailwind();

// copy images
mix.copy('src/images/*', 'assets/images' );