## Laravel + Nuxt.js を用いた個人事業主向け管理システム

### 言語
- Laravel v7.2.2
- Nuxt.js v2.12.0
- MySQL 5.7

### CORS対策
[fruitcake/laravel-cors](https://github.com/fruitcake/laravel-cors)を使用 

### 認証
[tymon/jwt-auth](https://github.com/tymondesigns/jwt-auth)を使用

***
### Laravel初期設定 (Local)
```
composer install
cp .env.example .env
php artisan key:generate
php artisan jwt:secret
php artisan migrate
```

 `php artisan jwt:secret`
で.env にjwt-authの秘密鍵 (JWT_SECRET) が生成される

ファイルストレージにS3を使用しているので、
.envにAWSの認証情報を記載する必要有


### Nuxt.js初期設定 (Local)
```
cd client
npm install
npm run dev
```
