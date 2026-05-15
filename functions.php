<?php
//※※※↑↑↑functions.phpトップの<?phpより上にはコメントを書かないこと(エラーの原因になる)！※※※


// GitHub URL変更確認 20260514 functions.phpをincludesフォルダのファイル８種で分割


// =====================================
// テーマ基本設定
// =====================================
require_once get_template_directory() . '/includes/theme-setup.php';

// =====================================
// CSS・JS読み込み
// =====================================
require_once get_template_directory() . '/includes/enqueue.php';

// =====================================
// カスタム投稿タイプ
// =====================================
require_once get_template_directory() . '/includes/custom-post-types.php';

// =====================================
// クエリ制御
// =====================================
require_once get_template_directory() . '/includes/query-filters.php';

// =====================================
// 環境判別
// =====================================
require_once get_template_directory() . '/includes/environment.php';

// =====================================
// 管理画面UI
// =====================================
require_once get_template_directory() . '/includes/admin-ui.php';

// =====================================
// ダッシュボード
// =====================================
require_once get_template_directory() . '/includes/dashboard-widget.php';

// =====================================
// LocalWP専用
// =====================================
require_once get_template_directory() . '/includes/local-env.php';



