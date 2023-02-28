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

mix.setPublicPath('resources');

mix.webpackConfig(webpack => {
   return {
       plugins: [
           new webpack.ProvidePlugin({
               $: 'jquery',
               jQuery: 'jquery', 
               'window.jQuery': 'jquery',
           })
       ]
   };
});

mix.ts('resources/assets/js/app.ts', 'js')
   .js('resources/assets/js/filemanager.js', 'js')
   .ts('resources/assets/js/pages.ts', 'js')
   .js('resources/assets/js/dragndrop.js', 'js')
   .vue()
   .sass('resources/assets/sass/horizontcms-next.scss', 'css');