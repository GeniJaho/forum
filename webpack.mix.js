const mix = require('laravel-mix');
var webpack = require('webpack');

require('laravel-mix-criticalcss');

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
    .criticalCss({
        enabled: mix.inProduction(),
        paths: {
            base: 'https://forum.genijaho.dev',
            templates: './public/css/critical/',
            suffix: '.min'
        },
        urls: [
            { url: '/', template: 'home' },
            { url: '/profiles/Mariglen%20Jahollari', template: 'profile' },
            { url: '/threads/suscipit/lorem-ipsum-dolor-sit-amet', template: 'threads.show' },
            { url: '/threads', template: 'threads.index' },
        ],
        options: {
            minify: true,
        },
    })
    .styles('resources/css/home.css', 'public/css/home.css')
    .styles('node_modules/tributejs/dist/tribute.css', 'public/css/tribute.css');

mix.copyDirectory('resources/img', 'public/img');

mix.webpackConfig({
    plugins: [
        new webpack.IgnorePlugin({
            resourceRegExp: /^\.\/locale$/,
            contextRegExp: /moment$/,
        })
    ]
});
