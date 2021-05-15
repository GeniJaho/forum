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
    .postCss("resources/css/app.css", "public/css", [
        require("tailwindcss")
    ])
    .styles('resources/css/neon.css', 'public/css/neon.css')
    .styles('node_modules/tributejs/dist/tribute.css', 'public/css/tribute.css');

mix.copyDirectory('resources/img', 'public/img');
