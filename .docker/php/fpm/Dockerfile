FROM php:8.2-fpm AS base



RUN apt update && apt install -y git libfreetype-dev unzip \
    libjpeg62-turbo-dev \
    libpng-dev \
    libicu-dev \
    libxml++2.6-dev \
    libxslt-dev \
    libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-configure pcntl \
    && docker-php-ext-install -j$(nproc) bcmath ctype gd intl pdo_mysql simplexml soap sockets xsl zip pcntl \
    && curl https://getcomposer.org/download/2.7.9/composer.phar -o /usr/local/bin/composer \
    && chmod +x /usr/local/bin/composer 

#SE INSTALA EL BINARIO DE MAILHOG
RUN cd $(mktemp -d) \
    && curl -L  https://github.com/mailhog/mhsendmail/releases/download/v0.2.0/mhsendmail_linux_amd64 -o mhsendmail_linux_amd64 \
    && chmod +x mhsendmail_linux_amd64 \
    && mv mhsendmail_linux_amd64 /usr/local/bin/mhsendmail


COPY include/magento.ini /usr/local/etc/php/conf.d/
COPY include/php.ini-development /usr/local/etc/php/php.ini
COPY include/zzz-docker.conf /usr/local/etc/php-fpm.d/



WORKDIR /app 


FROM base AS fpm 

FROM base AS xdebug
RUN pecl install xdebug && docker-php-ext-enable xdebug
COPY include/zz-xdebug-settings.ini /usr/local/etc/php/conf.d/


# TODO PENDIENTE INSTALAR XDEBUG 
# TODO PENDIENTE INSTALAR MAILHOG