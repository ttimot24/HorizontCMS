const mix = require('laravel-mix');
require('laravel-vue-i18n/mix');

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

mix.setPublicPath('resources');

mix.autoload({
   jquery: ['$', 'window.jQuery']
});

mix.i18n('resources/lang');

mix.ts('resources/assets/ts/app.ts', 'js')
   .ts('resources/assets/ts/main.ts', 'js')
   .ts('resources/assets/ts/pages.ts', 'js')
   .js('resources/assets/ts/dragndrop.js', 'js')
   .vue()
   .sass('resources/assets/sass/horizontcms-next.scss', 'css');