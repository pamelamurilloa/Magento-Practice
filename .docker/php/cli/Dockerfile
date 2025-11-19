FROM php:8.2-cli AS base

RUN apt update && apt install -y git libfreetype-dev unzip \
    libjpeg62-turbo-dev \
    libpng-dev \
    libicu-dev \
    libxml++2.6-dev \
    libxslt-dev \
    libzip-dev \
    npm \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-configure pcntl \
    && docker-php-ext-install -j$(nproc) bcmath ctype gd intl pdo_mysql simplexml soap sockets xsl zip pcntl ftp \
    && curl https://getcomposer.org/download/2.7.9/composer.phar -o /usr/local/bin/composer \
    && chmod +x /usr/local/bin/composer \
    && npm install -g grunt-cli

COPY include/magento.ini /usr/local/etc/php/conf.d/
COPY include/php.ini-development /usr/local/etc/php/php.ini



WORKDIR /app

FROM base AS cli


FROM base AS cron
COPY include/magentocron /etc/cron.d/
RUN apt update && apt install -y cron procps
