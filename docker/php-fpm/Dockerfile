FROM php:8.3.3-fpm-alpine as linux_dependencies

# Versions
ARG XDEBUG_VERSION=3.3.1

RUN apk add --update linux-headers
# Install modules
RUN apk upgrade --update && apk --no-cache add \
        $PHPIZE_DEPS \
        freetype-dev \
        libjpeg-turbo-dev \
        libpng-dev \
        icu-dev \
        libpq \
        curl-dev \
        oniguruma-dev \
        unzip \
        postgresql-dev \
        git \
        ffmpeg

FROM linux_dependencies AS php_installation

RUN docker-php-ext-install \
		bcmath \
    intl \
    opcache \
    mbstring

FROM php_installation AS php_extentions_installation
RUN pecl install xdebug-${XDEBUG_VERSION}

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        -j$(nproc) gd \
        pdo \
        pdo_pgsql \
    && docker-php-ext-enable \
              xdebug

RUN docker-php-source delete

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

CMD ["php-fpm"]

EXPOSE 9000
