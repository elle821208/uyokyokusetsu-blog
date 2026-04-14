

## ローカル環境localwpのテーマフォルダのパス場所
- ローカルのテーマ：
```
Local Sites/uyokyokusetsu-blog-local/app/public/wp-content/themes/Uyokyokusetsu-blog-dev
```

functions.phpの
   ▼ 3. ダッシュボード警告バナーで下記をを設定している。
add_action('admin_notices', function() 

    if (WP_ENV === 'production') 
        echo '<div style="padding:12px; background:#ff4444; color:#fff; font-size:18px; font-weight:bold; text-align:center;">
        🔴【本番環境】です。操作に注意！
        </br>※functions.phpに記載。




# 作業前に絶対やること（pull忘れ防止メモ）

## ✅ 1. 最初に必ず **pull** する！
```
git pull origin main
```
- これを忘れると **コンフリクト（衝突）** が発生して面倒になる
- 作業前の “おまじない” として絶対に実行する

---

# 🔄 Local → GitHub → 本番環境 の流れ（小学生でもわかる版）

## ① VSCode（ローカル環境）で作業する
- index.php / functions.php などを編集
- WordPress の投稿も編集可

## ② 変更を保存したら Git に登録する
```
git add .
git commit -m "今日の変更内容"
```

git commit-m "今日の変更内容"  # ❌ スペースを入れ忘れると commit できない


## ③ GitHub にアップする（push）
```
git push origin main
```

※ push する前には必ず **git pull** を忘れない！

---

# 🌍 本番環境（サーバー）への反映

## 方法①：FileZilla でテーマフォルダを上書きアップロードする
- ローカルのテーマ：
```
Local Sites/uyokyokusetsu-blog-local/app/public/wp-content/themes/Uyokyokusetsu-blog-dev
```
- FileZilla でサーバー側の同じテーマフォルダへアップロード
- ※ 必ずバックアップを取ってから

## 方法②：GitHub Actions（自動デプロイ）を使う（まだ未設定）
- 将来的に自動化したい場合は相談してください

---

# 👀 毎回見えるようにするコツ

### ✔ この README.md をプロジェクトの一番上に置く
→ VSCode を開くたびに目に入るので pull を忘れなくなる

### ✔ GitLens / Git Graph を VSCode に入れる
→ pull していない時に赤色警告で表示される

---

# 📝 よく使うGitコマンド一覧
```
# pull
git pull origin main

# ステージング
git add .

# コミット
git commit -m "メッセージ"

# push
git push origin main
```

---

必要であれば、あなた専用のもっと簡単な超シンプル版README.mdも作れます。


test
test
test
テスト
