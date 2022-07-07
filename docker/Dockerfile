FROM php:8.1.3-fpm-alpine

LABEL version="1.0"
LABEL maintainer="mtorresa@uni.pe"
LABEL description="PHP FPM with Nginx over Alpine for projects API RestFul"

WORKDIR /app

RUN apk add --update --no-cache nginx supervisor && mkdir -p /run/nginx/ && \
    docker-php-source extract && \
    apk add --update --no-cache \
        zlib-dev \
        libzip-dev \
        libpng \
        libpng-dev \
        libxml2-dev \
        libmcrypt-dev \
        libwebp-dev \
        libjpeg-turbo-dev \
        freetype-dev \
        autoconf \
        make \
        g++ \
        icu-dev && \
    pecl install -o -f redis && \
    pecl install -o -f mcrypt && \
    docker-php-ext-enable redis && \
    docker-php-ext-enable mcrypt && \
    docker-php-ext-install pdo && \
    docker-php-ext-install pdo_mysql && \
    docker-php-ext-install mysqli && \
    docker-php-ext-configure gd --with-freetype --with-jpeg  --with-webp && \
    docker-php-ext-install gd && \
    docker-php-ext-install zip && \
    docker-php-ext-install dom && \
    docker-php-ext-install intl && \
    docker-php-ext-install iconv && \
    docker-php-ext-install bcmath && \
    docker-php-ext-install opcache && \
    docker-php-ext-install exif && \
    docker-php-ext-install sockets && \
    echo "=====> Start Installing Composer" && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer  && \
    echo "=====> Finish Installing Composer" && \
    docker-php-source delete && \
    rm -rf /var/cache/apk/* && \
    rm -rf /tmp/* && \
    chown -R www-data:www-data /var/lib/nginx /var/log/nginx

COPY ./entrypoint.sh  /
COPY ./php/php.ini  /usr/local/etc/php/conf.d/99-overrides.ini
COPY ./nginx/server.conf  /etc/nginx/conf.d/default.conf
COPY ./nginx/nginx.conf /etc/nginx/nginx.conf
COPY ./supervisor/supervisord.conf /etc/supervisord.conf

EXPOSE 80

ENTRYPOINT ["/entrypoint.sh"]