
<?php
/**
 * query-filters.php
 *
 * 【役割】
 * WP_Query や投稿取得条件を調整するファイル。
 *
 * 【主な内容】
 * - pre_get_posts
 * - 投稿並び替え
 * - 検索除外
 * - カテゴリ絞り込み
 *
 * 【似た名前との違い】
 * custom-post-types.php
 * → 投稿タイプそのものを登録する
 *
 * query-filters.php
 * → 投稿の「取得条件」を変更する
 *
 * 中級以上の実務でよく使われる。
 */


// ------------------------------------------
// トップページ（front-page.php）の投稿表示数を12件に設定
function news_posts_per_page($query) {
    if (is_admin() || !$query->is_main_query()) return;
    if ($query->is_front_page()) {
        $query->set('posts_per_page', 12);
    }
}
add_action('pre_get_posts', 'news_posts_per_page');

