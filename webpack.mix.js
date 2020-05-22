const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss')

// require('laravel-mix-tailwind');
require('laravel-mix-purgecss');

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
   .sass('resources/sass/app.scss', 'public/css')
   .copy('node_modules/@fortawesome/fontawesome-free/webfonts', 'public/webfonts')
   .options({
        processCssUrls: false,
        postCss: [ tailwindcss('tailwind.config.js') ],
    });

if (mix.inProduction()) {
  mix
   .version()
   .purgeCss('/[\w-/.:]+(?<!:)/g');
}


// const mix = require('laravel-mix');

// require('laravel-mix-tailwind');

// /*
//  |--------------------------------------------------------------------------
//  | Mix Asset Management
//  |--------------------------------------------------------------------------
//  |
//  | Mix provides a clean, fluent API for defining some Webpack build steps
//  | for your Laravel application. By default, we are compiling the Sass
//  | file for the application as well as bundling up all the JS files.
//  |
//  */

// mix.js('resources/js/app.js', 'public/js')
//    .postCss('resources/css/app.css', 'public/css')
//    .tailwind('./tailwind.config.js');

// if (mix.inProduction()) {
//   mix
//    .version();
// }
