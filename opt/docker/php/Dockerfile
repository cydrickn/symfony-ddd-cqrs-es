FROM alpine:3.7 as base

ENV TIMEZONE            Asia/Manila
ENV SYMFONY_ENV         prod

RUN apk add --update openssh \
    curl \
    wget \
    git \
    php7 \
    php7-cli \
    php7-curl \
    php7-openssl \
    php7-json \
    php7-fpm \
    php7-pdo \
    php7-mysqli \
    php7-mbstring \
    php7-gd \
    php7-dom \
    php7-xml \
    php7-posix \
    php7-intl \
    php7-apcu \
    php7-phar \
    php7-zlib \
    php7-fileinfo \
    php7-simplexml \
    php7-tokenizer \
    php7-xmlwriter \
    php7-bz2 \
    php7-ctype \
    php7-session \
    php7-pdo_mysql \
    php7-zip \
    php7-iconv \
    php7-imagick \
    grep \
    gettext

FROM composer as vendor

COPY composer.json /app/composer.json
COPY composer.lock /app/composer.lock

RUN cd /app && composer install --ignore-platform-reqs --no-scripts

FROM base

COPY opt/docker/php/php.ini /etc/php7/php.ini
COPY opt/docker/php/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

COPY --from=vendor /usr/bin/composer /usr/bin/composer
COPY opt/docker/php/www.conf /etc/php7/php-fpm.d/www.conf
COPY / /var/www/html
COPY --from=vendor /app/vendor /var/www/html/vendor

WORKDIR /var/www/html

EXPOSE 9000

ENTRYPOINT ["/bin/sh", "/entrypoint.sh"]

CMD ["/usr/sbin/php-fpm7", "--nodaemonize"]