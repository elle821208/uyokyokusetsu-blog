

<?php
/**
 * theme-setup.php
 *
 * 【役割】
 * テーマ全体の初期設定を管理するファイル。
 * WordPressテーマの「土台設定」をまとめる。
 *
 * 【主な内容】
 * - add_theme_support()
 * - register_nav_menus()
 * - アイキャッチ有効化
 * - title-tag対応
 * - html5対応
 *
 * 【似た名前との違い】
 * enqueue.php
 * → CSS・JS読み込み専用
 *
 * admin-ui.php
 * → 管理画面UI調整用
 *
 * 実務では setup.php / theme-setup.php などがよく使われる。
 */


// ------------------------------------------
// サムネイル画像（アイキャッチ）を使う設定
// ------------------------------------------
// 投稿や固定ページでアイキャッチ画像（サムネイル）を使えるようにします。
add_theme_support('post-thumbnails'); 
add_image_size('post-thumbnails', 400, 200, true); // 幅400×高さ200（トリミングあり）
add_image_size('custom-thumb', 640, 360, true);    // 幅640×高さ360（トリミングあり）

// ------------------------------------------
// タブのタイトルに表示する文字列をカスタマイズ
// ------------------------------------------
// 例）「mindset | サイト名」などに表示されます。
// 対象ページ: トップページ、カテゴリページ、記事ページなど
// 影響ファイル: header.php などタイトルを出力しているファイル
function titles() {
    $title = wp_title(' | ', true, 'right');
    if (is_home()) {
        echo '①紆余曲折 |トップ ';
    } elseif (is_category()) {
        single_cat_title();
        echo ' | サイト名';
    } else {
        echo $title . 'サイト名';
    }
}
