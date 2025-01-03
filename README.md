# Деплой

## Вкатить дамп БД в локальный докер
```
docker exec -i mysql mysql -uroot -proot example_laravel_backend_for_nuxt < example_laravel_backend_for_nuxt.sql
```

## Общие
1. Выполнить команду: `cp .env.example .env`.
2. Выполнить команду: `php artisan key:generate`
3. Выполнить команду: `php artisan storage:link`

## Создания папок и их конфигурация для разделения хранилища

`sudo apt-get install acl`  
`sudo chmod 775 -R $project/storage`  
`sudo usermod -aG www-data user`  
`sudo usermod -aG user www-data`  
`sudo service nginx restart`  
`sudo service php8.0-fpm restart`  
`setfacl -Rdm u:www-data:rwx,u:user:rwx $project/storage`  
`sudo service nginx restart`  
`sudo service php8.0-fpm restart`

## Обязательное заполнение .env

`UPLOAD_FILE_DOMAIN` - подстановка к путям медиа-контента (полный домен). Например: `https://backoffice-api.example-laravel-backend-for-nuxt.ru`   
`DOMAIN` - основной домен для бекенда (без сабдомена)  
`WEB_API_SUBDOMAIN` - поддомен для api  
`BACKOFFICE_API_SUBDOMAIN` - поддомен для api для админке  
`PROTOCOL=https` - протокол

`MAIL_FROM_ADDRESS` - support@example-laravel-backend-for-nuxt.ru  
`MAILGUN_DOMAIN` - домен для мейлгана  
`MAILGUN_SECRET` - секрет для мейлгана  
`MAILGUN_ENDPOINT` - эндпоинт для мейлгана  
`MAIL_MAILER` - mailgun  
`MAIL_FROM_NAME` - ELB

`BROADCAST_DRIVER`=redis  
`QUEUE_CONNECTION`=redis

`APP_NAME`  
`APP_ENV`  

`DB_CONNECTION`  
`DB_HOST`  
`DB_PORT`  
`DB_DATABASE`  
`DB_USERNAME`  
`DB_PASSWORD`  

`REDIS_HOST`  
`REDIS_PASSWORD`  
`REDIS_PORT`