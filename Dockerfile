FROM php:8.1-fpm

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN apt-get update && apt-get install -y libzip-dev libpq-dev libicu-dev zip unzip nano

RUN docker-php-ext-configure intl && docker-php-ext-install pdo pdo_pgsql pgsql zip intl
RUN pecl install xdebug && docker-php-ext-enable xdebug

RUN mv /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini
COPY ./php.ini /usr/local/etc/php/conf.d/php.ini

COPY . /app/
RUN chmod ugo+rwx /app/yii
