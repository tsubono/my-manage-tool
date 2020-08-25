## Laravel + Nuxt.js を用いた個人事業主向け管理システム

### 言語
- Laravel v7.2.2
- Nuxt.js v2.12.0
- MySQL 5.7

***

## API ローカル環境構築
◯ 前提条件 <br>
`Docker`と`docker-compose`が使用可能であること

◯ APIコンテナ立ち上げ <br>
[初回]
```
$ docker-compose up -d --build
```
[2回目以降]
```
$ docker-compose up -d
```

[コンテナが起動しているか確認]
```
$ docker-compose ps
```

```
app-build-my_manage_tool      docker-php-entrypoint /bin ...   Up      9000/tcp                               
app-my_manage_tool            docker-php-entrypoint php-fpm    Up      9000/tcp                               
https_portal-my_manage_tool   /init                            Up      0.0.0.0:443->443/tcp,                  
                                                                       0.0.0.0:80->80/tcp                     
mysql-my_manage_tool          docker-entrypoint.sh mysqld      Up      0.0.0.0:3306->3306/tcp, 33060/tcp      
nginx-my_manage_tool          nginx -g daemon off;             Up      0.0.0.0:8000->80/tcp  
```

[コンテナを停止する場合]
```
docker-compose down
```

◯ 備考 <br>
- DB作成
- Laravelのmigration実行
- Laravelの.env生成
などもbuild時に合わせて行われます

<br>

#### ローカルでDBを確認する
[mysql設定] <br>
```
host: 127.0.0.1
port: 3306
database: my_manage_tool
user: my_manage_tool
password: password
```
◯ ターミナルで確認する場合
```
docker exec -it mysql-my_manage_tool mysql -u root -ppassword
```
◯ クライアントツールを使用する場合 <br>
```
上記[mysql設定]の情報で接続可能
```

<br>

#### コンテナに入りたい場合
[nginx]
```
docker exec -it web-my_manage_tool bash
```
[mysql]
```
docker exec -it mysql-my_manage_tool bash
```
[app]
```
docker exec -it app-my_manage_tool bash
```

(使用例) マイグレーションしたいとき
```
docker exec -it app-my_manage_tool bash
composer dump-autoload
php artisan migrate
```

<br>

## Nuxt.js ローカル環境立ち上げ
```
$ cd client
$ cp .env.example .env
$ npm install
$ npm run dev
```

.envにはAPI (Laravel側)のエンドポイントを記載


## CORS対策
[fruitcake/laravel-cors](https://github.com/fruitcake/laravel-cors)を使用 


## 認証
[tymon/jwt-auth](https://github.com/tymondesigns/jwt-auth)を使用

```
php artisan jwt:secret
```

 `php artisan jwt:secret`
で.env にjwt-authの秘密鍵 (JWT_SECRET) が生成される


## 備考
ファイルストレージにS3を使用しているので、
.envにAWSの認証情報を記載する必要有

