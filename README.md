## Installation

- git clone https://github.com/rendybustari/manage-user-example
- composer install
- set .env
- php artisan key:generate
- php artisan vendor:publish --provider="Laravolt\Indonesia\ServiceProvider"
- php artisan migrate
- php artisan laravolt: indonesia:seed (delete space sebelum "indonesia")
- php artisan db:seed --class=SuperadminSeeder
