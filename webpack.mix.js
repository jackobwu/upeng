const mix = require('laravel-mix');

mix 
    .js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/theme-light.scss', 'public/css')
    .webpackConfig({
        resolve: {
            alias: {
                '@': path.resolve('resources/js')
            }
        },
        output: {
            chunkFilename: 'js/[name].js'
        }
    })
    .babelConfig({ plugins: ['syntax-dynamic-import'] });
