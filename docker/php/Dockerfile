FROM php:8.4-fpm-alpine

WORKDIR /var/www

RUN apk add --no-cache  \
        bash \
        su-exec \
        gettext-dev \
        icu-dev \
        libjpeg-turbo-dev \
        libmcrypt-dev \
        libpng-dev \
        libzip-dev \
        oniguruma-dev \
        postgresql-dev \
        unzip && \
    apk add --no-cache --virtual .build-deps \
        autoconf \
        gcc \
        linux-headers \
        make && \
    docker-php-ext-configure gd --with-jpeg && \
    docker-php-ext-configure intl && \
    docker-php-ext-install -j$(nproc) \
        bcmath \
        exif \
        gd \
        gettext \
        intl \
        mbstring \
        opcache \
        pcntl \
        pdo \
        pdo_pgsql \
        pgsql \
        zip && \
    pecl install -o -f redis xdebug && \
    docker-php-ext-enable redis xdebug && \
    # clean
    apk del .build-deps && \
    rm -rf /var/cache/apk/* /tmp/*

COPY ./docker/php/ini/php.ini /usr/local/etc/php/conf.d/php.ini

RUN curl -sS https://getcomposer.org/installer | php -- \
    --filename=composer \
    --install-dir=/usr/local/bin

COPY . /var/www

RUN composer install --no-interaction --prefer-dist --optimize-autoloader

RUN php artisan storage:link && \
    php artisan route:cache && \
    chmod 777 -R /var/www/storage/ && \
    chown -R www-data:www-data /var/www/
