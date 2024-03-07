FROM php:8.2-fpm
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV USER="www-data"

WORKDIR /app

RUN apt update -y

# Installing dependencies
RUN apt install -y \
    libzip-dev \
    zip \
    unzip \
    curl \
    libcurl4-gnutls-dev libpng-dev libfreetype6-dev libjpeg62-turbo-dev

RUN docker-php-ext-install zip pdo pdo_mysql curl opcache
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --enable-gd
RUN docker-php-ext-install gd
RUN docker-php-ext-configure exif
RUN docker-php-ext-install exif

# Installing composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . /app

COPY ./.docker/php/php.ini /usr/local/etc/php/php.ini
COPY ./.docker/php/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf

RUN chown -R $USER:$USER /app

RUN composer update --no-interaction --no-dev --no-scripts --optimize-autoloader

COPY ./.docker/entrypoint.sh /etc/entrypoint.sh
RUN chmod +x /etc/entrypoint.sh

ENTRYPOINT ["sh", "/etc/entrypoint.sh"]

EXPOSE 9000
