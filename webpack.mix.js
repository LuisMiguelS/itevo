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
    .sass('resources/assets/sass/app.scss', 'public/css')
    .version();

// Tenant
let tenant_css = [
    'resources/assets/css/jquery-UI.css',
    'resources/assets/css/bootstrap.css',
    'resources/assets/css/neon-core.css',
    'resources/assets/css/neon-theme.css',
    'resources/assets/css/neon-forms.css',
    'resources/assets/css/skin-black.css',

    //Datatables css
    'resources/assets/css/datatables/dataTables.bootstrap.min.css',
    'resources/assets/css/datatables/responsive.bootstrap.min.css',
    'resources/assets/css/datatables/buttons.bootstrap.min.css'
];

let tenant_js = [
    'resources/assets/js/libs/jquery-1.11.3.min.js',
    'resources/assets/js/libs/TweenMax.min.js',
    'resources/assets/js/libs/jquery-ui-1.10.3.minimal.min.js',
    'resources/assets/js/libs/bootstrap.js',
    'resources/assets/js/libs/joinable.js',
    'resources/assets/js/libs/resizeable.js',
    'resources/assets/js/libs/neon-api.js',
    'resources/assets/js/libs/raphael-min.js',
    'resources/assets/js/libs/neon-custom.js',
    'resources/assets/js/libs/neon-demo.js',

    //Datatable js
    'resources/assets/js/libs/datatables/jquery.dataTables.min.js',
    'resources/assets/js/libs/datatables/dataTables.bootstrap.min.js',
    'resources/assets/js/libs/datatables/dataTables.responsive.min.js',
    'resources/assets/js/libs/datatables/responsive.bootstrap.min.js',
    'resources/assets/js/libs/datatables/dataTables.buttons.min.js',
    'resources/assets/js/libs/datatables/buttons.bootstrap.min.js',
    'resources/assets/js/libs/datatables/jszip.min.js',
    'resources/assets/js/libs/datatables/pdfmake.min.js',
    'resources/assets/js/libs/datatables/vfs_fonts.js',
    'resources/assets/js/libs/datatables/buttons.html5.min.js',
    'resources/assets/js/libs/datatables/buttons.print.min.js',
    'resources/assets/js/libs/datatables/buttons.server-side.js'
];

mix.styles(tenant_css, 'public/css/tenant.css')
    .version();

mix.scripts(tenant_js, 'public/js/tenant.js')
    .version();
