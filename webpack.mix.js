const mix = require('laravel-mix');

require('laravel-mix-purgecss');

mix.js('resources/js/app.js', 'public/js');
mix.sass('resources/sass/app.scss', 'public/css').options({
    processCssUrls: true
});

mix.copy('resources/fonts/Tajawal', 'public/fonts/Tajawal');
