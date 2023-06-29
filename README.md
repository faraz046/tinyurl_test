# tinyurl_test
A simple online shop - Test

# Stack
PHP 8, Apache, Mysql, Node, Npm, Vue
I've included docker-compose setup which can be run via
`docker-compose up --build`

# Getting started
After setup, run `composer install` and run migrations `php artisan migrate`

# Test Data
Please run `php artisan db:seed --class=ProductCategorySeeder` after running migrations.

# npm
This project uses npm. Please run `npm install` and  `npm run build` for frontend compilations.

# App
After registration/login, shop can be accessed at `/shop/product` e.g `http://localhost:8085/shop/product`





