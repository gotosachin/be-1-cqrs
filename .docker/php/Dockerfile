FROM php:8.1.6-fpm-bullseye as build

ENV BUILD_PACKAGES \
    libpq-dev \
    libssl-dev \
    libz-dev \
    libzip-dev \
    librabbitmq-dev \
    libssh-dev

RUN apt-get update -yqq \
    && apt-get install -yqq --no-install-recommends \
        curl \
        git \
        $BUILD_PACKAGES \
        supervisor \
        zip \
        unzip \
    && docker-php-ext-install bcmath \
    && docker-php-ext-install opcache \
    && docker-php-ext-install pdo \
    && docker-php-ext-install pdo_pgsql \
    && docker-php-ext-install sockets \
    && pecl install -o -f amqp \
    && docker-php-ext-enable amqp \
    && pecl install -o -f redis \
    && docker-php-ext-enable redis \
    && pecl install xdebug-3.1.3 \
    && docker-php-ext-enable xdebug \
    && rm -rf /tmp/pear \
    && apt-get remove -qq --purge -y $BUILD_PACKAGES \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

ADD .docker/php/conf.d/www.conf /usr/local/etc/php-fpm.d/www.conf
ADD .docker/php/conf.d/opcache.ini-production $PHP_INI_DIR/conf.d/opcache.ini
ADD .docker/php/php-production.ini $PHP_INI_DIR/php.ini

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

ARG PUID=1000
ENV PUID ${PUID}
ARG PGID=1000
ENV PGID ${PGID}

RUN groupmod -o -g ${PGID} www-data \
    && usermod -o -u ${PUID} -g www-data www-data \
    && chown -R 1000:1000 /var/www \
    && mkdir -p /var/log/supervisor \
    && chown -R 1000:1000 /var/log/supervisor/ \
    && mkdir -p /opt/run/ \
    && chown -R 1000:1000 /opt/run

WORKDIR /var/www

ADD --chown=www-data:www-data ./ /var/www

USER 1000:1000

VOLUME ["/var/www"]
