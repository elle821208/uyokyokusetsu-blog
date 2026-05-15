
<?php
/**
 * admin-ui.php
 *
 * 【役割】
 * WordPress管理画面全体のUI調整用ファイル。
 *
 * 【主な内容】
 * - 管理画面CSS
 * - 管理バー制御
 * - メニュー非表示
 * - 投稿一覧カラム調整
 *
 * 【似た名前との違い】
 * dashboard-widget.php
 * → ダッシュボードトップ専用
 *
 * admin-ui.php
 * → wp-admin 全体に関係する処理
 *
 * 実務では admin.php と命名されることも多い。
 */


/* ======================================================
   ▼ 2. ダッシュボード背景色（環境ごと）
====================================================== */
function tetsu_admin_env_style() {

    if (WP_ENV === 'local') {
        echo '<style>
            body.wp-admin { background: #e3f0ff !important; }
        </style>';
    } else {
        echo '<style>
            body.wp-admin { background: #ffe5e5 !important; }
        </style>';
    }
}
add_action('admin_head', 'tetsu_admin_env_style');






/* ======================================================
   ▼ 5. 投稿一覧に「完成・途中・放置」のカラータグ
====================================================== */
function tetsu_custom_post_state_tags($states, $post) {

    $status = get_post_status($post->ID);

    // 一度クリア
    $states = array();

    $labels = array(
        'complete' => '<span style="color:#28a745; font-weight:bold;">🟩 完成（公開可能）</span>',
        'progress' => '<span style="color:#f0ad4e; font-weight:bold;">🟨 途中（書きかけ）</span>',
        'paused'   => '<span style="color:#d9534f; font-weight:bold;">🟥 放置（優先度低）</span>',
    );

    switch ($status) {
        case 'publish':
            $states[] = $labels['complete'];
            break;

        case 'draft':
        case 'pending':
            $states[] = $labels['progress'];
            break;

        case 'private':
            $states[] = $labels['paused'];
            break;

        default:
            if (!empty($post->post_password)) {
                $states[] = $labels['paused'];
            }
            break;
    }

    return $states;
}
add_filter('display_post_states', 'tetsu_custom_post_state_tags', 10, 2);



