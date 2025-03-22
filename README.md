# How to run

1. composer update
2. composer dump-autoload **(optional)**
3. Copy .env.example and rename it to .env
4. Inside .env edit DB_DATABASE, DB_USERNAME, DB_PASSWORD and all extra info you need
5. php artisan jwt:secret
6. composer renv **(script to refresh cache and env variables)**
7. php artisan migrate
8. php artisan db:seed --class=AdminSeeder
9. php artisan db:seed --class=ClientsSeeder
10. php artisan serve **or** set a virtual host.
