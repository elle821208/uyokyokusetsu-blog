

<?php
/**
 * environment.php
 *
 * 【役割】
 * 環境判定・環境別読み込みを管理するファイル。
 *
 * 【主な内容】
 * - local / staging / production 判定
 * - 環境別設定読み込み
 * - wp_get_environment_type()
 *
 * 【似た名前との違い】
 * local-env.php
 * → ローカル環境専用処理
 *
 * environment.php
 * → 環境全体の振り分け管理
 *
 * 実務では environment ディレクトリ化されることも多い。
 */


/* ======================================================
   ▼ 1. 環境判別（本番 / ローカル）
====================================================== */
if ( !defined('WP_ENV') ) {
    if (
        strpos($_SERVER['HTTP_HOST'], 'localhost') !== false ||
        strpos($_SERVER['HTTP_HOST'], '.local') !== false
    ) {
        define('WP_ENV', 'local');   // LocalWP
    } else {
        define('WP_ENV', 'production'); // 本番
    }
}

