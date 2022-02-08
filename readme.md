## Requirements
- php >= 7.4
- composer
- git (optional)
- npm (optional)

## Install
```powershell
git clone https://github.com/bakkarXabdo/LMS-laravel lms
cd lms
composer install
php -r "copy('.env.developement', '.env');"
php artisan key:generate
# configure database credentials before migrating
mysql -uroot -ppassword -e"create database lms;"
php artisan migrate --seed
npm install
npm run dev
php artisan serve
```
