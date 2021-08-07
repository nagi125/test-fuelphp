FROM php:7.4-fpm

ENV TZ Asia/Tokyo
ENV COMPOSER_ALLOW_SUPERUSER 1

# install Lib for composer
RUN curl -sL https://deb.nodesource.com/setup_12.x | bash - && \
    apt-get update -qq && \
    apt-get install --no-install-recommends -y libpq-dev libonig-dev libxml2-dev nodejs git zip unzip && \
    apt-get install --no-install-recommends -y zlib1g-dev libfreetype6-dev libpng-dev libjpeg62-turbo-dev libwebp-dev libxpm-dev && \
    apt-get clean && \
    rm -rf /var/cache/apt && \
    npm install npm@latest -g

# add extention
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp --with-xpm && \
    docker-php-ext-install -j$(nproc) gd && \
    docker-php-ext-install mbstring pdo pdo_pgsql json

# php.conf php-fpm.conf
COPY conf/php.ini /usr/local/etc/php/php.ini
COPY conf/docker.conf /usr/local/etc/php-fpm.d/docker.conf

# install Composer
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer && \
    chmod +x /usr/local/bin/composer

# install Oil
RUN curl https://get.fuelphp.com/oil | sh

WORKDIR /app
