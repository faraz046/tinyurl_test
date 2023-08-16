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

# Mysql setup
Please run the below queries after you have added the data for products, categories and their associations. This will generate the required materialized view for the shop.

`CREATE TABLE mv_products_by_category AS
SELECT p.id AS id, p.name AS product_name, p.price, p.created_at, c.id AS category_id, c.name AS category_name
FROM products p
JOIN product_categories pc ON p.id = pc.product_id
JOIN categories c ON pc.category_id = c.id;`

`CREATE INDEX idx_product_category_id ON mv_products_by_category (id, category_id);
CREATE INDEX idx_product_name ON mv_products_by_category (product_name);
CREATE INDEX idx_price ON mv_products_by_category (price);
CREATE INDEX idx_created_at ON mv_products_by_category (created_at);
CREATE INDEX idx_category_name ON mv_products_by_category (category_name);`

# npm
This project uses npm. Please run `npm install` and  `npm run build` for frontend compilations.

# App
After registration/login, shop can be accessed at `/shop/product` e.g `http://localhost:8085/shop/product`





