FROM php:7.4-fpm-alpine

RUN set -ex \
    && apk --no-cache add \
        postgresql-dev make \
    && docker-php-ext-install pdo \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo_pgsql

RUN apk upgrade --no-cache --update && apk add \
     php7-simplexml \
     postgresql-dev \
     php7-xml \
     php7-xmlreader \
     php7-xmlwriter \
     php7-zip \
     libpng-dev \
     libjpeg-turbo-dev \
     libxpm-dev \
     libwebp-dev \
     freetype-dev \
     libzip-dev \
     zip \
     php7-zip \
     php7-redis \
     && docker-php-ext-install -j$(nproc) iconv \
     && docker-php-ext-configure gd \
              --with-freetype=/usr/include/ \
              --with-jpeg=/usr/include/ \
              --with-webp=/usr/include/ \
     && docker-php-ext-install -j$(nproc) gd \
     && docker-php-ext-configure zip \
              --with-zip \
     && docker-php-ext-install zip \
     && docker-php-ext-enable zip \
     && docker-php-ext-install pcntl \
     && docker-php-ext-enable pcntl \
     && rm -rf /var/cache/apk/*

RUN apk add --no-cache --update $PHPIZE_DEPS --virtual buildDeps autoconf g++ \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del buildDeps

RUN docker-php-ext-install exif

RUN curl -sS https://getcomposer.org/installer | php -- --version=2.0.6 --install-dir=/usr/local/bin --filename=composer

RUN apk update && apk add bash

RUN apk add --update nodejs npm

RUN apk add --no-cache git

RUN mkdir /composer
RUN mkdir /npm
RUN chown www-data:www-data /npm
RUN chown www-data:www-data /composer

RUN npm set cache "/npm" -g

WORKDIR /var/www/app

