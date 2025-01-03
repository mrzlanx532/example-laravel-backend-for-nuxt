SET GLOBAL time_zone = 'UTC';
CREATE DATABASE IF NOT EXISTS `elb` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'elb'@'%' IDENTIFIED WITH mysql_native_password BY 'elb';
GRANT ALL ON *.* TO 'elb'@'%';

USE elb;
