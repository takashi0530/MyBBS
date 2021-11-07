const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        // tailwindcssを読み込み
        require('tailwindcss')
    ])
    // vueの読み込み
    .vue()
    // ホットリロードの設定（ブラウザの自動更新）
    .browserSync('localhost:8590')
    // 読み込みファイルのバージョニング設定（キャッシュ対策）
    .version();
