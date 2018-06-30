let mix = require('laravel-mix');

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

// App
mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css');

// Tenant Panel Compiling Assets
let tenant_panel_css = [
    'resources/assets/css/jquery-UI.css',
    'resources/assets/css/bootstrap.css',
    'resources/assets/css/neon-core.css',
    'resources/assets/css/neon-theme.css',
    'resources/assets/css/neon-forms.css',
    'resources/assets/css/skin-black.css',
];

let tenant_panel_js = [
    'resources/assets/js/libs/jquery-1.11.3.min.js',
    'resources/assets/js/libs/TweenMax.min.js',
    'resources/assets/js/libs/jquery-ui-1.10.3.minimal.min.js',
    'resources/assets/js/libs/bootstrap.js',
    'resources/assets/js/libs/joinable.js',
    'resources/assets/js/libs/resizeable.js',
    'resources/assets/js/libs/neon-api.js',
    'resources/assets/js/libs/raphael-min.js',
    'resources/assets/js/libs/neon-custom.js',
    'resources/assets/js/libs/neon-demo.js'
];

mix.styles(tenant_panel_css, 'public/css/tenant_panel.css');
mix.scripts(tenant_panel_js, 'public/js/tenant_panel.js');
