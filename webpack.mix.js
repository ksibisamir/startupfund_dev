const { mix } = require('laravel-mix');
let minifier = require('minifier');



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

const BrowserSyncPlugin = require('browser-sync-webpack-plugin')

mix.sass('public/assets/scss/style.scss', 'public/assets/css').sass('public/assets/scss/admin.scss', 'public/assets/css').options({
    processCssUrls: false
})

mix.then(() => {
    minifier.minify('public/assets/css/style.css')
});

mix.then(() => {
    minifier.minify('public/assets/css/admin.css')
});

mix.webpackConfig({
    plugins: [
        new BrowserSyncPlugin({
            open: 'http://127.0.0.1:8000',
            host: '127.0.0.1',
            proxy: 'http://127.0.0.1:8000',
            files: ['resources/views/**/*.php', 'app/**/*.php', 'routes/**/*.php','public/assets/**/*']
        })
        ]
})
