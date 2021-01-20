let mix = require('laravel-mix');
require('laravel-mix-purgecss');

mix.sass('./sass/main.scss', './dist/main.css').options({
        processCssUrls: false,
}).js('./bootstrap/js/index.js', './dist/bootstrap-scripts.js').purgeCss({
	content:["./*.php", "./template-parts/*.php", "./template-parts/blocks/*/*.php", "./inc/*.php"],
	safelist: require("purgecss-with-wordpress").safelist
});

mix.autoload({ 
  'jquery': ['$', 'window.jQuery', 'jQuery'],
});

