
<?php
/**
 * enqueue.php
 *
 * 【役割】
 * CSS・JavaScriptの読み込み管理専用ファイル。
 *
 * 【主な内容】
 * - wp_enqueue_style()
 * - wp_enqueue_script()
 * - CDN読み込み
 * - Swiper.js
 * - Prism.js
 *
 * 【似た名前との違い】
 * theme-setup.php
 * → テーマ初期設定
 *
 * integrations系
 * → 外部ライブラリごとにさらに分割する場合もある
 *
 * 実務ではかなり定番の分割ファイル。
 */


// =============================================
// Prism.js を読み込むための設定（functions.php）
// =============================================

function add_prismjs_to_theme() {
  // Prism.js の CSS（見た目のスタイル）を読み込む
  wp_enqueue_style(
    'prismjs-css', // スタイルの名前（自由に変更可）
    'https://cdn.jsdelivr.net/npm/prismjs@1.29.0/themes/prism.min.css' // CDNのURL（外部の倉庫）
  );

  // Prism.js の JavaScript（コードを色付けする仕組み）を読み込む
  wp_enqueue_script(
    'prismjs-js', // スクリプトの名前（自由に変更可）
    'https://cdn.jsdelivr.net/npm/prismjs@1.29.0/prism.min.js', // CDNのURL
    array(),  // 依存するスクリプト（なし）
    null,     // バージョン番号（自動）
    true      // 読み込み位置：trueはHTMLの一番下（速くなる）
  );
}

// WordPress に「この関数を使ってね！」と登録する
add_action('wp_enqueue_scripts', 'add_prismjs_to_theme');






// ==============================
// コードコピー機能のJS/CSSを読み込み
// ==============================
function uyokyokusetsu_enqueue_copy_code_assets() {
    // JSを読み込み（テーマの/js/copy-code.js）
    wp_enqueue_script(
        'copy-code',
        get_template_directory_uri() . '/js/copy-code.js',
        array(),
        null,
        true // フッターで読み込む
    );

    // CSSを読み込み（テーマの/css/copy-code.css）
    wp_enqueue_style(
        'copy-code-style',
        get_template_directory_uri() . '/css/copy-code.css'
    );
}
add_action('wp_enqueue_scripts', 'uyokyokusetsu_enqueue_copy_code_assets');







// ==============================
// resposive.css スマホ対応（レスポンシブデザイン）専用の CSS
// ==============================
function theme_responsive_css() {
    wp_enqueue_style(
        'responsive',
        get_template_directory_uri() . '/css/responsive.css',
        array(),
        '1.0.0'
    );
}
add_action('wp_enqueue_scripts', 'theme_responsive_css');







// // ==============================
// // 学習用 JavaScript ファイル群
// // ==============================
// function my_enqueue_scripts() {
//     wp_enqueue_script('tetsu-basics',
//         get_template_directory_uri() . '/Tetsu-Js-Study/basics.js',
//         array(), '1.0', true);

//     wp_enqueue_script('tetsu-functions',
//         get_template_directory_uri() . '/Tetsu-Js-Study/functions.js',
//         array(), '1.0', true);

//     wp_enqueue_script('tetsu-arrays-loops',
//         get_template_directory_uri() . '/Tetsu-Js-Study/arraysAndLoops.js',
//         array(), '1.0', true);

//     wp_enqueue_script('tetsu-objects-builtins', 
//         get_template_directory_uri() . '/Tetsu-Js-Study/objectsAndBuiltIns.js',
//         array(), '1.0', true);

//     wp_enqueue_script('tetsu-dom-browser',
//         get_template_directory_uri() . '/Tetsu-Js-Study/domAndBrowser.js',
//         array(), '1.0', true);
// }
// add_action('wp_enqueue_scripts', 'my_enqueue_scripts');



// // ==============================
// // ダークモード＆季節判定 JS を全ページで読み込み
// // ==============================       
// function enqueue_darkmode_season_script() {
//     wp_enqueue_script(
//         'darkmode-season',
//         get_template_directory_uri() . '/Tetsu-Js-Study/darkmode-season.js', // ← フォルダ構成に合わせたパス
//         array(), // 依存スクリプトなし
//         null,    // バージョン番号（キャッシュ防止したいときは time() にすると便利）
//         true     // フッターで読み込む（高速化）
//     );
// }
// add_action('wp_enqueue_scripts', 'enqueue_darkmode_season_script');


