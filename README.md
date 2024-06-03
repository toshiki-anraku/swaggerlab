# Laravel Project with Sail and Pest Testing

## プロジェクト概要

このプロジェクトは、Laravel Sail を使用した開発環境と、Pest を使用したテスト環境を備えた Laravel アプリケーションです。本番環境とテスト環境を分けることで、安全かつ効率的な開発とテストを実現します。

## 前提条件

-   Docker と Docker Compose がインストールされていること

## セットアップ手順

### 1. プロジェクトのクローン

まず、リポジトリをクローンします。

```bash
git clone https://github.com/your-repo/your-project.git
cd your-project
```

### 2. Sail のインストール

Sail を使用して必要なコンテナをビルドします。

```bash
./vendor/bin/sail up -d
```

### 3. 環境設定

`.env` ファイルを作成し、適切な値を設定します。

```bash
cp .env.example .env
./vendor/bin/sail artisan key:generate
```

`.env` ファイル内のデータベース設定を以下のように設定します：

```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=sail
DB_PASSWORD=password
```

### 4. テスト環境設定

テスト専用の環境設定ファイル `.env.testing` を作成します。

```env
# .env.testing
DB_CONNECTION=mysql
DB_HOST=mysql_test
DB_PORT=3306
DB_DATABASE=testing_database
DB_USERNAME=sail
DB_PASSWORD=password
```

### 5. Docker Compose ファイルの設定

`docker-compose.yml` ファイルにテスト用のデータベースサービスを追加します。

```yaml
version: "3"
services:
    laravel.test:
        # existing configuration

    mysql:
        image: "mysql/mysql-server:8.0"
        ports:
            - "${FORWARD_DB_PORT:-3306}:3306"
        environment:
            MYSQL_ROOT_PASSWORD: "${DB_PASSWORD}"
            MYSQL_ROOT_HOST: "%"
            MYSQL_DATABASE: "${DB_DATABASE}"
            MYSQL_USER: "${DB_USERNAME}"
            MYSQL_PASSWORD: "${DB_PASSWORD}"
            MYSQL_ALLOW_EMPTY_PASSWORD: 1
        volumes:
            - "sail-mysql:/var/lib/mysql"
            - "./vendor/laravel/sail/database/mysql/create-testing-database.sh:/docker-entrypoint-initdb.d/10-create-testing-database.sh"
        networks:
            - sail
        healthcheck:
            test:
                - CMD
                - mysqladmin
                - ping
                - "-p${DB_PASSWORD}"
            retries: 3
            timeout: 5s

    mysql_test:
        image: "mysql/mysql-server:8.0"
        environment:
            MYSQL_ROOT_PASSWORD: "password"
            MYSQL_ROOT_HOST: "%"
            MYSQL_DATABASE: "testing_database"
            MYSQL_USER: "sail"
            MYSQL_PASSWORD: "password"
            MYSQL_ALLOW_EMPTY_PASSWORD: 1
        volumes:
            - "sail-mysql-test:/var/lib/mysql"
        networks:
            - sail
        healthcheck:
            test:
                - CMD
                - mysqladmin
                - ping
                - "-ppassword"
            retries: 3
            timeout: 5s

volumes:
    sail-mysql:
        driver: local
    sail-redis:
        driver: local
    sail-meilisearch:
        driver: local
    sail-mysql-test:
        driver: local

networks:
    sail:
        driver: bridge
```

### 6. マイグレーションとシーディング

データベースのマイグレーションとシーディングを実行します。

```bash
./vendor/bin/sail artisan migrate --seed
```

### 7. テストの実行

テスト環境を使用してテストを実行します。

```bash
./vendor/bin/sail test --env=testing
```

## その他のコマンド

### サーバーの起動

```bash
./vendor/bin/sail up -d
```

### サーバーの停止

```bash
./vendor/bin/sail down
```

### キャッシュのクリア

```bash
./vendor/bin/sail artisan cache:clear
./vendor/bin/sail artisan config:clear
./vendor/bin/sail artisan route:clear
./vendor/bin/sail artisan view:clear
```

## Scribe を使用した API ドキュメントの生成

このプロジェクトでは、Scribe を使用して API ドキュメントを生成します。

### インストール手順

1. **Scribe のインストール**:

    ```bash
    ./vendor/bin/sail composer require --dev knuckleswtf/scribe
    ```

2. **設定ファイルの公開**:

    ```bash
    ./vendor/bin/sail artisan vendor:publish --tag=scribe-config
    ```

3. **ドキュメントの生成**:

    ```bash
    ./vendor/bin/sail artisan scribe:generate
    ```

4. **ドキュメントの確認**:
   ローカルサーバーを起動し、`public/docs`ディレクトリ内の`index.html`ファイルにアクセスします。

Scribe の詳細については、[Scribe の公式ドキュメント](https://scribe.knuckles.wtf/laravel)を参照してください。

## まとめ

このプロジェクトは、Laravel Sail を使用した開発環境と、Pest を使用したテスト環境を提供します。本番環境とテスト環境を分けることで、安全かつ効率的な開発とテストが可能です。これにより、開発者は安心してコードを書き、テストを実行することができます。
