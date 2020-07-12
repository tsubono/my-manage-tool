#!/bin/bash
source /home/manage/.bash_profile

cd /home/manage/config
ln nuxt.env ../my-manage-tool/client/.env
ln laravel.env ../my-manage-tool/.env

## Laravel Setup
sudo chown manage:manage -R /home/manage/my-manage-tool/
cd /home/manage/my-manage-tool/
ln -nfs storage /home/manage/config/storage
sudo chmod -R 777 storage
cd /home/manage/my-manage-tool/
pwd
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan migrate --force

## Nuxt Setup
cd client
rm -rf node_modules
npm cache verify
npm cache clean --force
npm install vue-color
npm ci
npm run build
npm run start > /dev/null 2>&1 &

