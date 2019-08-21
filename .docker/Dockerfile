FROM php:7.2.13-apache-stretch

COPY . /srv/app
COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /srv/app

RUN apt-get update
RUN docker-php-ext-install mysqli pdo_mysql mongodb && docker-php-ext-enable mysqli

RUN chown -R www-data:www-data /srv/app \
    && a2enmod rewrite