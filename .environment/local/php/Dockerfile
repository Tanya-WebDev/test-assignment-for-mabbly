FROM php:8.2-fpm-alpine3.19

RUN set -ex \
  && apk --no-cache add \
    postgresql-dev \
    libzip-dev \
    bash \
    zip

RUN apk add libzip-dev
RUN docker-php-ext-install zip

RUN docker-php-ext-install pdo pdo_pgsql
RUN apk add --update linux-headers
RUN apk --update --no-cache add autoconf g++ make && \
    pecl install -f xdebug-3.2.0 && \
    docker-php-ext-enable xdebug && \
    apk del --purge autoconf g++ make

RUN apk --update --no-cache add autoconf g++ make && \
     pecl install -f pcov && \
     docker-php-ext-enable pcov && \
     apk del --purge autoconf g++ make

RUN curl -sL https://getcomposer.org/installer | php -- --install-dir /usr/bin --filename composer

WORKDIR /app

RUN echo 'pm.max_children = 30' >> /usr/local/etc/php-fpm.d/zz-docker.conf

CMD ["php-fpm"]