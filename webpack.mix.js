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

// Admin Panel Compiling Assets
let admin_panel_css = [
    'resources/assets/css/jquery-UI.css',
    'resources/assets/css/bootstrap.css',
    'resources/assets/css/neon-core.css',
    'resources/assets/css/neon-theme.css',
    'resources/assets/css/neon-forms.css',
    'resources/assets/css/skin-black.css',
];

let admin_panel_js = [
    'resources/assets/js/jquery-1.11.3.min.js',
    'resources/assets/js/TweenMax.min.js',
    'resources/assets/js/jquery-ui-1.10.3.minimal.min.js',
    'resources/assets/js/bootstrap.js',
    'resources/assets/js/joinable.js',
    'resources/assets/js/resizeable.js',
    'resources/assets/js/neon-api.js',
    'resources/assets/js/raphael-min.js',
    'resources/assets/js/neon-custom.js',
    'resources/assets/js/neon-demo.js'
];

mix.styles(admin_panel_css, 'public/css/admin_panel.css');
mix.scripts(admin_panel_js, 'public/js/admin_panel.js');
