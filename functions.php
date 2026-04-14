    <?php
//※※※↑↑↑functions.phpトップの<?phpより上にはコメントを書かないこと(エラーの原因になる)！※※※


// GitHub URL変更確認 20260414

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

// ------------------------------------------
// 通常投稿（post）のアーカイブURLを /blog に変更
// ------------------------------------------
// URL例: https://〇〇.com/blog でアーカイブ表示されます
function post_has_archive($args, $post_type) {
    if ('post' === $post_type) {
        $args['rewrite'] = true;
        $args['has_archive'] = 'blog';
        $args['label'] = '雑記ブログ一覧';
    }
    return $args;
}
add_filter('register_post_type_args', 'post_has_archive', 10, 2);

// ------------------------------------------
// トップページ（front-page.php）の投稿表示数を12件に設定
function news_posts_per_page($query) {
    if (is_admin() || !$query->is_main_query()) return;
    if ($query->is_front_page()) {
        $query->set('posts_per_page', 12);
    }
}
add_action('pre_get_posts', 'news_posts_per_page');










// ------------------------------------------
// カスタム投稿タイプ「works」（技術ブログ）をつくる
// ------------------------------------------
// ★これを使うと、WordPress に “投稿・固定ページ” 以外の
//   新しい記事の種類を追加できる。
// ★ここでは「技術記事だけを入れる箱（works）」を作る。

// 追加説明①：cpy_register_works の細かい意味
// ● cpy → あなたのテーマの頭文字（prefix）
//          「他の人の関数名とぶつけないための名前タグ」
// ● register → WordPress に「登録してね」とお願いする意味
// ● works → 新しく作る投稿タイプのID（技術ブログ専用の箱）
// → つまり関数名全体の意味は『cpyテーマで "works" を登録する先生』


// ★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
// ▼▼▼▼▼▼▼▼▼▼▼▼▼ 使用者（あなた）視点での動く順番 ▼▼▼▼▼▼▼▼▼▼▼▼▼
// ① WordPress が起動する
// ② init というタイミングが来る
// ③ add_action が「cpy_register_works 呼んで！」と WordPress に伝える
// ④ cpy_register_works 関数が呼ばれる
// ⑤ $labels（表示名）を設定する
// ⑥ $args（動きのルール）を設定する
// ⑦ register_post_type() で "works" を WP に登録する
// ⑧ WP ダッシュボード左側に「技術ブログ一覧」というメニューが追加される
// ⑨ /works で一覧ページが使えるようになる
// ⑩ 投稿とは別の “技術ブログ専用の箱” が完成
// ▲▲▲▲▲▲▲▲▲▲▲▲▲ 使用者視点の流れを完全理解 ▲▲▲▲▲▲▲▲▲▲▲▲▲
// ★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★


function cpy_register_works() {

    // ▼投稿タイプの名前（ラベル）をまとめたもの
//   ※ブログの管理画面（UI）に表示される文字や、裏側のシステムが使う名前。
$labels = [

    // ----------------------------------------------------------
    // ▼① singular_name
    // ----------------------------------------------------------
    'singular_name' => 'tech ※singular_name',   
    // 【UIでの表示】ほぼ表示されない（通常はメニューには出ない）
    // 【裏側での使用】WordPress内部で「1つの記事の呼び名」として使われる。
    //   例：更新メッセージなどで “tech を更新しました” と表示される場合がある。
    // ※表示されないことも多い → 使われるのは内部ロジック中心。

    // ----------------------------------------------------------
    // ▼② edit_name（⚠ WordPressに存在しないラベル）
    // ----------------------------------------------------------
    'edit_name'     => 'tech',
    // 【UIでの表示】完全に表示されない（無効／ダッシュボードに反映されない）
    // 【裏側の影響】なし。WordPressのラベル項目に edit_name は存在しないため無効。
    // ※消しても動作に一切影響なし。

    // ----------------------------------------------------------
    // ▼③ all_items
    // ----------------------------------------------------------
    'all_items'  => '技術ブログ一覧 ※all_items',  
    // 【UIでの表示】ダッシュボード左メニューで "技術ブログ一覧" をクリックしたときの
    //   一覧ページのタイトル（上部見出し）として表示される。
    //   例：ページ上部に「投稿を追加」と表示される。
    //
    // ▼表示される場所イメージ：
    // ┌─────────────────────────┐
    // │ 投稿を追加                ← ここが all_items の表示場所
    // └─────────────────────────┘
    //
    // 【裏側での影響】管理画面の「一覧画面のラベル」として使われるだけ。
    //   データ処理には影響しない（名前が変わっても記事データは変わらない）。
];


    // ▼ここでテスト：ラベル名の変更による変化を学習できる
    // ▼変更してダッシュボードでどう変わるか試せるテスト案
    //   'singular_name' => 'recipe',（レシピ）
    //   'singular_name' => 'work',（作品）
    //   'singular_name' => 'memo',（メモ）
    //   管理画面の「投稿名」の表示が変わります。


   // ▼投稿タイプの設定（とても大事な部分）
// ----------------------------------------------------------
// $args を書き換えると、ダッシュボードに表示されるメニュー、URL、
// 投稿画面の機能、有効化されるエディタなどがすべて変わる。
// ----------------------------------------------------------
$args = [

    // ------------------------------------------------------------------
    // ▼① label（＝左メニューに表示される投稿タイプの名前）
    // ------------------------------------------------------------------
    'label' => '技術ブログ倉庫 ※(functions.php cpy_register_works $args で設定)',
    // 【UIの変化】
    //   WordPressダッシュボード左側メニューに表示される。
    //   「投稿」「固定ページ」と同じ位置に新しい項目が出る。
    //
    // 【裏側の影響】
    //   POST TYPE 名（識別子）は register_post_type() の第一引数に依存するため、
    //   この label を変えてもデータ構造には一切影響しない。
    //
    // ▼テスト例（変えると即ダッシュボードで変化が見える）
    // 'label' => 'レシピ倉庫',
    // 'label' => '作品ひきだし',
    // 'label' => 'なんでもノート',
    // → ダッシュボード左メニューの「技術ブログ一覧」がこの文字に置き換わる！
    

    // ------------------------------------------------------------------
    // ▼② labels（より細かいラベル設定）
    // ------------------------------------------------------------------
    'labels' => $labels,
    // ※$labels 配列で指定したものが、
    //   「一覧ページタイトル」「新規追加画面タイトル」「更新メッセージ」
    //   などに反映される。
    //
    // 【UIの変化の例】
    //   all_items     → 一覧ページ上部タイトルに出る
    //   add_new_item  → 新規追加ページ上のタイトル
    //   singular_name → 更新メッセージなどに使われることがある


    // ------------------------------------------------------------------
    // ▼③ public（一般公開するか）
    // ------------------------------------------------------------------
    'public' => true,
    // 【UIの変化】
    //   true：通常の投稿と同じように公開できる（URLで誰でも閲覧可能）
    //   false：管理画面にはあるが、フロント側の閲覧は不可
    //
    // 【裏側の影響】
    //   WordPress の公開状態（公開・非公開・REST API）に影響


    // ------------------------------------------------------------------
    // ▼④ show_in_rest（ブロックエディタを使うか）
    // ------------------------------------------------------------------
    'show_in_rest' => true,
    // 【UIの変化】
    //   true：ブロックエディタが使える（Gutenberg）
    //   false：旧クラシックエディタになる
    //
    // 【裏側の影響】
    //   REST API に公開されるため、
    //   JavaScript系プラグインやGutenbergが参照できるようになる


    // ------------------------------------------------------------------
    // ▼⑤ has_archive（自動で一覧ページを作るか）
    // ------------------------------------------------------------------
    'has_archive' => true,
    // 【UIの変化】
    //   フロント側に /works/ のような一覧ページが自動生成される
    //
    // 【裏側の影響】
    //   WordPressのリライトルールが追加され、一覧表示が可能になる


    // ------------------------------------------------------------------
    // ▼⑥ hierarchical（親子階層を作るか）
    // ------------------------------------------------------------------
    'hierarchical' => false,
    // 【UIの変化】
    //   true：固定ページのように「親ページ」が選べる（階層を作れる）
    //   false：投稿と同じで階層なし
    //
    // 【裏側の影響】
    //   階層構造のデータ（page_parent）が使われるかどうかが変わる


    // ------------------------------------------------------------------
    // ▼⑦ rewrite（URLルール）
    // ------------------------------------------------------------------
    'rewrite' => [
        'slug' => 'works',
        'with_front' => true
    ],
    // 【UIの変化】
    //   フロント側 URL が /works/〇〇〇 になる
    //
    // ▼テスト：ここを変えるとURLの形が変わる
    //
    //   'slug' => 'techblog' → /techblog/〇〇〇
    //   'slug' => 'portfolio' → /portfolio/〇〇〇
    //
    // 【裏側の影響】
    //   リライトルール（.htaccess の内部処理）に新規ルールが追加される


    // ------------------------------------------------------------------
    // ▼⑧ menu_position（左メニューでの表示位置）
    // ------------------------------------------------------------------
    'menu_position' => 5,
    // 【UIの変化】
    //   5 → 「投稿」のすぐ下
    //   20 → 「固定ページ」の下あたり
    //
    // ▼テスト
    //   3 → ダッシュボードのかなり上に出現
    //   100 → メニューの一番下に出現
    //
    // 【裏側の影響】
    //   システム処理には影響なし。純粋に UI の順番だけ。


    // ------------------------------------------------------------------
    // ▼⑨ can_export（エクスポートを許可するか）
    // ------------------------------------------------------------------
    'can_export' => true,
    // 【UIの変化】
    //   ツール → エクスポート で、works投稿をエクスポート可能
    //
    // 【裏側の影響】
    //   WordPressの XML エクスポートで対象に含まれる


    // ------------------------------------------------------------------
    // ▼⑩ supports（投稿編集画面の機能）
    // ------------------------------------------------------------------
    'supports' => [
        'title',          // タイトル入力欄を表示
        'editor',         // 本文のエディタ（ブロック / クラシック）
        'thumbnail',      // アイキャッチ画像の設定
        'page-attributes' // 並び順（menu_order）が使える
    ],
    // 【UIの変化】
    //   これを消したり追加すると、投稿編集画面の項目が増減する
    //
    // ▼テスト例
    //   'excerpt' → 抜粋欄が出現
    //   'comments' → コメント欄が使えるようになる
    //
    // 【裏側の影響】
    //   WordPressの postmeta（投稿のメタ情報）にどの項目を保存するかが変わる
];

// ▼WordPressに「新しい投稿タイプ works を作ってね」と指示
register_post_type('works', $args);
}

// ▼WordPressが起動したときに上の関数を読み込む
add_action('init', 'cpy_register_works');












// ------------------------------------------
// 技術ブログ（works）投稿タイプのアーカイブページで
// ?w_year=2025&w_month=07 のような年月絞り込みを可能にする
// ------------------------------------------
// 対象ページ: /works などの works 投稿タイプアーカイブ
// 対象ファイル: archive-works.php（テンプレートファイル）
// 絞り込み条件がないとき → 全 works 表示
// 絞り込みがあるとき → 年月一致する works のみ表示
function filter_works_archive_by_date($query) {
    if (!is_admin() && $query->is_main_query() && $query->is_post_type_archive('works')) {
        // クエリパラメータから「年」と「月」を取得（URL例: /works?w_year=2025&w_month=07）
        $year  = isset($_GET['w_year'])  ? intval($_GET['w_year'])  : null;
        $month = isset($_GET['w_month']) ? intval($_GET['w_month']) : null;

        // 年または月が指定されている場合にのみ、date_query で絞り込む
        if ($year || $month) {
            $date_query = [];
            if ($year)  $date_query['year']  = $year;
            if ($month) $date_query['month'] = $month;
            $query->set('date_query', [$date_query]); // 年月で絞り込み
        }

        // 投稿タイプは「works」のみに限定
        $query->set('post_type', 'works');

        // 表示件数は制限なし（全件表示）
        // 必要に応じて 12 件などに変更可能
        $query->set('posts_per_page', -1);
    }
}
add_action('pre_get_posts', 'filter_works_archive_by_date');

// ------------------------------------------
// トップページでは「zakki」カテゴリのみ表示するように制限
// 対象ページ: front-page.php（トップ）
// 対象投稿タイプ: post（通常投稿）
function filter_main_query_for_front($query) {
    if (is_admin() || !$query->is_main_query()) return;
    if (is_front_page()) {
        $query->set('category_name', 'zakki'); // zakkiカテゴリのみ
    }
}
add_action('pre_get_posts', 'filter_main_query_for_front');

// ------------------------------------------
// 月別アーカイブページで ?cat=◯◯ のカテゴリ絞り込みを許可
// 例: /2025/07/?cat=mindset のような形式
function filter_monthly_archive_by_category($query) {
    if (!is_admin() && $query->is_main_query() && is_date() && isset($_GET['cat'])) {
        $query->set('category_name', sanitize_text_field($_GET['cat']));
    }
}
add_action('pre_get_posts', 'filter_monthly_archive_by_category');

// ------------------------------------------
// カテゴリーページで ?year=2025&monthnum=07 による年月絞り込みを許可
// 対象ページ: /category/mindset など
function filter_archive_by_category_and_date($query) {
    if (!is_admin() && $query->is_main_query() && $query->is_category()) {
        if (isset($_GET['year']))     $query->set('year', intval($_GET['year']));
        if (isset($_GET['monthnum'])) $query->set('monthnum', intval($_GET['monthnum']));
    }
}
add_action('pre_get_posts', 'filter_archive_by_category_and_date');




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



// ==============================
//includes(functions.phpの記載を分担させるための、php機能ファイルの入ったフォルダ)を読み込む
// ==============================
require_once get_template_directory() . '/includes/enqueue.php';
require_once get_template_directory() . '/includes/theme-setup.php';//includesフォルダのtheme-setup.php を読み込む












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




/*↓↓↓ g-doc備忘録のリンクを追加 2026.04.08*/

/* ======================================================
   ▼ 3. ダッシュボード警告バナー
====================================================== */
add_action('admin_notices', function() {

$common_notice = '
    <div style="margin-top:10px; line-height:1.8; font-size:16px; text-align:left; max-width:1200px; margin-left:auto; margin-right:auto;">

        <div style="font-size:22px; font-weight:bold; margin-bottom:10px;">
            📘 CPTカスタム投稿タイプ運用メモ
        </div>

        <ul style="margin:0 0 15px 20px; padding:0;">
            <li>カスタム投稿タイプCPTの既存記事の大幅修正は崩れやすい</li>
            <li>新規記事の追加・複製運用には強い</li>
            <li>CPT記事を更新したい場合、新規記事へコピペして記事タイトルを変えて元の記事を削除してから</li>
            <li>ツールのwordpress XML エクスポート / インポート</li>
            <li>または WP記事を直接コピペして更新</li>
        </ul>





<div style="margin-top:20px; margin-bottom:20px;">
    <div style="font-size:22px; font-weight:bold; margin-bottom:10px;">
        🚀 更新方法 早見表
    </div>

    <ul style="margin:0 0 15px 20px; padding:0; line-height:1.9;">
        <li>✍️ 1記事 / 複数記事（部分更新） → XML（記事の引っ越し）</li>
        <li>🚚 サイト丸ごと → .wpress（家ごと引っ越し）</li>
        <li>🖼 投稿画像 → 基本は WordPress、表示不良時のみ FileZilla uploads</li>
        <li>🧩 自作テーマ / CPT定義 → FileZillaでテーマ同期（functions.php 最優先）</li>
        <li>🧯 緊急時 1記事だけ → 直接コピペが最も安全</li>
    </ul>

    <div style="font-size:20px; font-weight:bold;">
        💡 一言で覚える
    </div>

    <div style="margin-left:20px; line-height:1.8;">
        XML = 記事の引っ越し<br>
        .wpress = サイト丸ごとの引っ越し
    </div>

    <div style="font-size:20px; font-weight:bold; margin-top:15px;">
        🔄 既存CPT記事の更新
    </div>

    <div style="margin-left:20px; line-height:1.8;">
        XMLは追加向き<br>
        更新は直接記事コピペ または 新規投稿へコピペ → XML
    </div>
</div>








        <div style="font-size:18px; font-weight:bold; margin-bottom:6px;">
            🔗 G-docリンク
        </div>

        <ul style="margin:0 0 0 20px; padding:0;">
            
            <li>
                <a href="https://docs.google.com/document/d/1589qwPCYu-iU2IvmWgJn67FdSgIeVWTmIjb08d5dH_c/edit?tab=t.0"
                   target="_blank"
                   style="color:#fff; text-decoration:underline;">
                   【WPブログ記事投稿更新・基本編】記事・画像・テーマ反映・逆反映｜LocalWP→本番
                </a>
            </li>
            <li>
                <a href="https://docs.google.com/document/d/16eoaSWN__D2yqMTat2TZ5KMsdexfHR0m0evbNWKf-Fk/edit?usp=drive_link"
                   target="_blank"
                   style="color:#fff; text-decoration:underline;">
                   【WPブログ記事投稿更新・応用編_CPT画像トラブル対応】LocalWP→本番｜XMLと.wpress の違い・uploads・FileZilla完全版
                </a>
            </li>
            <li>
                <a href="https://docs.google.com/document/d/1JdGxaO0h2ldwHrtG8Z3AlR6DPFEi43pdkccXmCPtyNo/edit?tab=t.0#heading=h.5o0291aojspu"
                   target="_blank"
                   style="color:#fff; text-decoration:underline;">
                   【FileZilla】でWordPressに自作テーマをアップロードする方法
                </a>
            </li>
        </ul>
    </div>
';




    if (WP_ENV === 'production') {
        echo '<div style="padding:12px; background:#ff4444; color:#fff; font-size:18px; font-weight:bold; text-align:center;">
        🔴【本番環境】です。操作に注意！
        </br>ローカル環境用ocalwpテーマフォルダ → uyokyokusetsu-blog-dev の functions.php の 3. ダッシュボード警告バナーに記載。
        </br>ローカル環境localwpパス → C:\Users\Tetsuya_new\Local Sites\uyokyokusetsu-blog\app\public\wp-content\themes\uyokyokusetsu-blog-dev
        </br>ローカル環境localwpはこのfunctions.phpを修正すると即時反映される。
        </br>本番環境はこのlocalwpテーマフォルダuyokyokusetsu-blog-devをFilleZillaでアップロードして更新する。
        ' . $common_notice . '
        </div>';
    }

    if (WP_ENV === 'local') {
        echo '<div style="padding:12px; background:#2277ff; color:#fff; font-size:18px; font-weight:bold; text-align:center;">
        🔵【ローカル環境】です。安心して編集できます。
         </br>ローカル環境用ocalwpテーマフォルダ → uyokyokusetsu-blog-dev の functions.php の 3. ダッシュボード警告バナーに記載。
        </br>ローカル環境localwpパス → C:\Users\Tetsuya_new\Local Sites\uyokyokusetsu-blog\app\public\wp-content\themes\uyokyokusetsu-blog-dev
        </br>ローカル環境localwpはこのfunctions.phpを修正すると即時反映される。
        </br>本番環境はこのlocalwpテーマフォルダuyokyokusetsu-blog-devをFilleZillaでアップロードして更新する。
        ' . $common_notice . '
        </div>';
    }

});


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



/* ======================================================
   ▼ 6. ダッシュボードに「運用ルール＋作業順」メモ
====================================================== */
function tetsu_add_dashboard_widget() {
    wp_add_dashboard_widget(
        'tetsu_rules_widget',
        '📝 ブログ運用ルール（完成・途中・放置＋作業順）',
        'tetsu_dashboard_rules_display'
    );
}
add_action('wp_dashboard_setup', 'tetsu_add_dashboard_widget');

function tetsu_dashboard_rules_display() {
    echo '
        <div style="font-size:15px; line-height:1.8;">

            <h2 style="margin-bottom:10px;">📌 作業の順番（連番）</h2>
            <ol style="margin-bottom:25px;">
                <li><strong>🟨 途中（書きかけ）記事を進める</strong><br>
                    まずここから。少しでも完成へ。</li>
                <li><strong>🟩 完成（公開可能）を本番へ反映</strong><br>
                    読み直してOKなら公開。</li>
                <li><strong>🟥 放置（優先度低）をチェック</strong><br>
                    やる気がある日に回収。</li>
            </ol>

            <h3>🟩 完成（公開可能）【作業順：2】</h3>
            <ul>
                <li>本番へ反映する候補</li>
                <li>読み直してOKの状態</li>
                <li><strong>WP状態：公開（publish）</strong></li>
            </ul>

            <h3>🟨 途中（書きかけ）【作業順：1】</h3>
            <ul>
                <li>構成がまだ完成していない</li>
                <li>画像・図解が不足</li>
                <li>リライト待ち</li>
                <li><strong>WP状態：下書き（draft）</strong></li>
            </ul>

            <h3>🟥 放置（優先度低）【作業順：3】</h3>
            <ul>
                <li>アイデアだけ</li>
                <li>いつ書くかわからない</li>
                <li>下書きの下書き</li>
                <li><strong>WP状態：非公開（private）</strong></li>
            </ul>

        </div>
    ';
}












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



    









