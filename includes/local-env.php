
<?php
/**
 * dashboard-widget.php
 *
 * 【役割】
 * ダッシュボードトップ専用の管理ファイル。
 *
 * 【主な内容】
 * - ダッシュボードウィジェット追加
 * - Welcomeパネル削除
 * - 不要メタボックス削除
 * - WordPressニュース非表示
 *
 * 【似た名前との違い】
 * admin-ui.php
 * → 管理画面全体用
 *
 * dashboard-widget.php
 * → /wp-admin/index.php 専用
 *
 * 実務では dashboard.php と命名されることも多い。
 */





/* ======================================================
   ▼ 4. ローカル環境だけ WEBサイトに警告バナー（ヘッダー固定）
====================================================== */
function tetsu_local_front_notice() {
    if (WP_ENV === 'local') {

        // ヘッダー固定バナー
        echo '
        <div style="
            width:100%;
            background:#1133aa;
            color:white;
            padding:12px;
            text-align:center;
            font-size:18px;
            position:fixed;
            top:0;
            left:0;
            z-index:9999;
        ">
            🔵【ローカル環境のサイト】（本番ではありません）
        </div>';

        // バナーの高さ分だけ余白
        echo '<style>
            body { margin-top:50px !important; }
        </style>';
    }
}
add_action('wp_head', 'tetsu_local_front_notice');


/* ======================================================
   ▼ 4-2. LocalWP だけ WEBサイトのフッターにも警告バナー追加
====================================================== */
add_action('wp_footer', function() {
    if (WP_ENV === 'local') {
        echo '
        <div style="
            width:100%;
            background:#1133aa;
            color:white;
            padding:12px;
            text-align:center;
            font-size:16px;
            font-weight:bold;
            margin-top:20px;
        ">
            🔵【ローカル環境】これは開発用サイトです
        </div>';
    }
});


/* ======================================================
   ▼ 4-3. LocalWP のサイト背景色を変更
====================================================== */
add_action('wp_head', function() {
    if (WP_ENV === 'local') {
        echo '<style>
            body { background:#fffbe6 !important; }
        </style>';
    }
});

