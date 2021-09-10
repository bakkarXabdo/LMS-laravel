composer install
php -r "copy('.env.example', '.env');"
php artisan key:generate
php artisan migrate --seed
npm install
npm run dev
php artisan serve
