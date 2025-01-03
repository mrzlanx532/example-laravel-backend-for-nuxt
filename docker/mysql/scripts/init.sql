SET GLOBAL time_zone = 'UTC';
CREATE DATABASE IF NOT EXISTS `example_laravel_backend_for_nuxt` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'example_laravel_backend_for_nuxt'@'%' IDENTIFIED WITH mysql_native_password BY 'example_laravel_backend_for_nuxt';
GRANT ALL ON *.* TO 'example_laravel_backend_for_nuxt'@'%';

USE example_laravel_backend_for_nuxt;
