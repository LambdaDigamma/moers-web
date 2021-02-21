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

mix.js('resources/js/app.js', 'public/js').vue()
    .postCss("resources/css/app.css", "public/css", [
        require("tailwindcss"),
        require("autoprefixer")
    ])
    // .options({
    //     processCssUrls: false,
    //     postCss: [tailwindcss('./tailwind.config.js')]
    // })
    .webpackConfig(require("./webpack.config.js"))
    .sourceMaps()
    .extract()
