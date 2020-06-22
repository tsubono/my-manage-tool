cp /home/manage/config/laravel.env /home/manage/my-manage-tool/.env
cp /home/manage/config/nuxt.env /home/manage/my-manage-tool/client/.env

## Laravel Setup
sudo chown manage:manage -R /home/manage/my-manage-tool/
cd /home/manage/my-manage-tool/
ln -nfs storage /home/manage/config/storage
sudo chmod -R 777 app/storage
rm -rf vendor/
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan migration --force

## Nuxt Setup
cd client
rm -rf node_modules
npm cache verify
npm cache clean --force
npm install vue-color
npm ci
npm run build
npm run start > /dev/null 2>&1 &

