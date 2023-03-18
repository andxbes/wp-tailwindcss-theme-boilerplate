const mix = require('laravel-mix');
const local = require('./assets/js/utils/local-config');
const requireResolve = require('resolve');

// get molnarg's http2 module
const http2Module = require(requireResolve.sync('http2', { basedir: process.cwd() }));
require('laravel-mix-versionhash');
require('laravel-mix-tailwind');
const fs = require("fs");



function findFiles(dir) {
    const fs = require('fs');
    return fs.readdirSync(dir).filter(file => {
        return fs.statSync(`${dir}/${file}`).isFile();
    });
}

function buildSass(dir, dest) {
    findFiles(dir).forEach(function (file) {
        if (!file.startsWith('_') && !file.startsWith('.')) {
            mix.sass(dir + '/' + file, dest);
        }
    });
}

function buildJs(dir, dest) {
    findFiles(dir).forEach(function (file) {
        if (!file.startsWith('_') && !file.startsWith('.')) {
            mix.js(dir + '/' + file, dest);
        }
    });
}


mix.setPublicPath('./build');

mix.webpackConfig({
    externals: {
        "jquery": "jQuery",
    }
});

if (local.proxy) {
    var bs_config = {
        proxy: local.proxy,
        injectChanges: true,
        https: local.https ? local.https : false,
        httpModule: http2Module,
        open: (local.open == true),
        files: [
            './*.php',
            'build/**/*.{css,js}',
            'templates/**/*.php',
            'woocommerce/**/*.php',
            'app/walkers/*.php',
            'blocks/**/*.php',
        ]
    };
    //console.info('browserSync_config - ' , bs_config);
    mix.browserSync(bs_config);
}

mix.tailwind();
mix.js('assets/js/app.js', 'js');

// buildJs('assets/js/components/alpine/','js/components/alpine/');


// mix.sass('assets/scss/admin.scss', 'css');
// mix.sass('assets/scss/app.scss', 'css');
buildSass('assets/scss/', 'css');
buildSass('assets/scss/components/', 'css/components/');
// buildSass('assets/scss/components/woocommerce/', 'css/components/woocommerce/');
if (mix.inProduction()) {
    // mix.version(); //WPO не хочет с атрибутами склеивать файлы
    mix.sourceMaps();
}
