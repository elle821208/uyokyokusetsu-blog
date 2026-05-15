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
            🔗 G-docリンク(WP編集・本番反映・Git・アップロード)
        </div>
        <ul style="margin:0 0 0 20px; padding:0;">    
            <li>
                <a href="https://docs.google.com/document/d/1GP98bfsUdzuEe3K0qyDnrPt8xMVfu5J-bcE13SfRH0s/edit?tab=t.0#heading=h.pdmgkac5ybai"
                   target="_blank"
                   style="color:#fff; text-decoration:underline;">
                   【親】プログラミング独学_コマンド・Git総合入口リンク集｜パス・cd・GitHub・WordPress連携
                </a>
            </li>
             <li>
                <a href="https://docs.google.com/document/d/1faL86C8E0hBqvByB4Xcqml3843TEfGrxl5-KQuP_dDM/edit?tab=t.0#heading=h.cm1wgoz62ggw"
                   target="_blank"
                   style="color:#fff; text-decoration:underline;">
                   【WP移行・復元】Imacでローカル環境と本番環境を再現する3ステップ（WordPress三代要素・Gitテーマフォルダー・FTP画像uploads・All in one migration DBデータ・LocalWP）
                </a>
            </li>
             <li>
                <a href="https://docs.google.com/document/d/1MIdFizLCXld5ymYR7k3ldTsfTu6kuTU0cTH7Xoo0GEE/edit?tab=t.0#heading=h.6zgbd3828i7"
                   target="_blank"
                   style="color:#fff; text-decoration:underline;">
                   【子】VSCodeとGitHubのgit status git push pull 連携・更新・差分確認テスト｜久しぶりに更新が反映されるかのチェック方法 git fetch　git diff                </a>
            </li>
            <li>
                <a href="https://docs.google.com/document/d/1JdGxaO0h2ldwHrtG8Z3AlR6DPFEi43pdkccXmCPtyNo/edit?tab=t.0#heading=h.5o0291aojspu"
                   target="_blank"
                   style="color:#fff; text-decoration:underline;">
                   【FileZilla】でWordPressに自作テーマをアップロードする方法
                </a>
            </li>
        </ul>


        <div style="font-size:18px; font-weight:bold; margin-bottom:6px;">
            🔗 G-docリンク(WP投稿記事更新)
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
           
        </ul>
    </div>
';




    if (WP_ENV === 'production') {
        echo '<div style="padding:50px; background:#ff4444; color:#fff; font-size:18px; font-weight:bold; text-align:left;">
        🔴【本番環境】です。操作に注意！
        </br>WPの三大構成要素（1)テーマフォルダーはGithub＆vscode、(2)uploads画像はFilleZilla、(3)DB＆設定はAll in one Migration で成り立つ。
        </br>①このページはVScodeでwp正本フォルダ　WP正本テーマフォルダ uyokyokusetsu-blog を開く。
        </br>②uyokyokusetsu-blog → functions.php の 3. ダッシュボード警告バナーで編集する。
        </br>③上記の正本テーマフォルダパス → C:\Users\Tetsuya_new\Tetsuya-Works_win\03_スキルアップ・学習関係\01_プログラミング関係（哲也）
        </br>\03_WordPress\themes\uyokyokusetsu-blog
        </br>④ローカル環境Localwp（確認用）内のLocalsitesフォルダはシンボリックリンクで上記の正本フォルダを読み込んでいる。
        </br>このfunctions.phpを修正すると即時反映される。
        </br>⑤ブラウザ本番環境はこの正本テーマフォルダuyokyokusetsu-blogをFilleZillaでアップロードして更新する。
        ' . $common_notice . '
        </div>';
    }

    if (WP_ENV === 'local') {
        echo '<div style="padding: 50px;px; background:#2277ff; color:#fff; font-size:18px; font-weight:bold; text-align:left;">
        🔵【ローカル環境】です。安心して編集できます。
        </br>WPの三大構成要素（1)テーマフォルダーはGithub＆vscode、(2)uploads画像はFilleZilla、(3)DB＆設定はAll in one Migration で成り立つ。
        </br>①このページはVScodeでwp正本フォルダ　WP正本テーマフォルダ uyokyokusetsu-blog を開く。
        </br>②uyokyokusetsu-blog → functions.php の 3. ダッシュボード警告バナーで編集する。
        </br>③上記の正本テーマフォルダパス → C:\Users\Tetsuya_new\Tetsuya-Works_win\03_スキルアップ・学習関係\01_プログラミング関係（哲也）
        </br>\03_WordPress\themes\uyokyokusetsu-blog
        </br>④ローカル環境Localwp（確認用）内のLocalsitesフォルダはシンボリックリンクで上記の正本フォルダを読み込んでいる。
        </br>このfunctions.phpを修正すると即時反映される。
        </br>⑤Localでブラウザ表示チェック後、GitHubへ保存する（履歴管理）
        </br>⑥ブラウザ本番環境はこの正本テーマフォルダuyokyokusetsu-blogをFilleZillaでアップロードして更新する。
        ' . $common_notice . '
        </div>';
    }

});

