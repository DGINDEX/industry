### [システム名]について
システムに関する概要説明をここに記載。

### 動作環境
本システムは以下の環境下にて動作する。
* PHP 7.4系統最新
* MySQL 8系統最新
* nginx 1.19.10
* Laravel 8系統最新
* フロント側はスマホ/タブレットでの表示も想定。要レスポンシブ対応。

### 開発環境構築と実行まで
開発環境は以下の手順にてダウンロード、起動可能

```bash
git clone git@github.com:auto-id-frontier/business_matching.git
cd business_matching
docker-compose build
docker-compose up -d
```

.envの作成(.env.exampleをコピーして作成)

```bash
winpty docker-compose exec php bash
composer install
php artisan config:cache
php artisan route:cache

npm install
npm run dev

php artisan migrate
php artisan db:seed

php artisan storage:link
```

dockerにて仮想環境起動後、以下URLにアクセス  
https://localhost:8080/

### 注意事項
何かあれば記載。なければ項目ごと消して良い。
