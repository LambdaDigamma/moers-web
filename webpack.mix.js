const mix = require('laravel-mix')
const path = require('path')

require('laravel-mix-tailwind')
require('laravel-mix-purgecss');
const tailwindcss = require('tailwindcss')

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
    .sass('resources/sass/main.scss', 'public/css')
    .options({
        processCssUrls: false,
        postCss: [tailwindcss('./tailwind.config.js')]
    })
    .purgeCss({
        enabled: mix.inProduction(),
        defaultExtractor: content => content.match(/[\w-/.:]+(?<!:)/g) || []
    })
    .webpackConfig({
        output: {chunkFilename: '[name].js?id=[chunkhash]'},
        resolve: {
            alias: {
                'vue$': 'vue/dist/vue.runtime.esm.js',
                '@': path.resolve('resources/js'),
            },
        }
    })
    .sourceMaps()
    .extract()
