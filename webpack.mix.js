const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');

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

mix.js('resources/js/admin.js', 'public/js/admin.js')
    .js('resources/js/app.js', 'public/js/app.js')
    .sourceMaps();

mix.sass('resources/sass/app.scss', 'public/css/app.css', {}, [tailwindcss('app.tailwind.config.js')])
    .options({
        processCssUrls: false,
        postCss: [tailwindcss('app.tailwind.config.js')]
    });

mix.sass('resources/sass/admin.scss', 'public/css/admin.css', {}, [tailwindcss('admin.tailwind.config.js')])
    .options({
        processCssUrls: false,
        postCss: [tailwindcss('admin.tailwind.config.js')]
    });
