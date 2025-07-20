FROM ubuntu:24.04

LABEL maintainer="ilyes"

ARG WWWGROUP=1001
ARG NODE_VERSION=22

WORKDIR /var/www/html

ENV DEBIAN_FRONTEND=noninteractive
ENV TZ=Europe/Paris

RUN ln -snf /usr/share/zoneinfo/Europe/Paris /etc/localtime && echo "Europe/Paris" > /etc/timezone

RUN apt-get update && apt-get install -y gnupg curl ca-certificates \
    && mkdir -p /etc/apt/keyrings \
    && curl -sS 'https://keyserver.ubuntu.com/pks/lookup?op=get&search=0xb8dc7e53946656efbce4c1dd71daeaab4ad4cab6' | gpg --dearmor | tee /etc/apt/keyrings/ppa_ondrej_php.gpg > /dev/null \
    && echo "deb [signed-by=/etc/apt/keyrings/ppa_ondrej_php.gpg] https://ppa.launchpadcontent.net/ondrej/php/ubuntu noble main" > /etc/apt/sources.list.d/ppa_ondrej_php.list

RUN apt-get update && apt-get install -y \
    php8.4-fpm php8.4-cli php8.4-mysql php8.4-opcache php8.4-xml php8.4-mbstring php8.4-gd \
    php8.4-curl php8.4-zip php8.4-bcmath php8.4-intl \
    supervisor git unzip nano

# Fix user/group setup - only modify www-data
RUN usermod -u 1001 www-data && groupmod -g 1001 www-data

# Create necessary directories and set permissions for PHP-FPM only
RUN mkdir -p /var/log/php /var/www/.npm /run/php \
    && chown -R 1001:1001 /var/log/php /var/www/.npm /run/php \
    && chmod -R 775 /var/log/php /var/www/.npm /run/php

RUN curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key | gpg --dearmor -o /etc/apt/keyrings/nodesource.gpg \
    && echo "deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_$NODE_VERSION.x nodistro main" > /etc/apt/sources.list.d/nodesource.list \
    && apt-get update \
    && apt-get install -y nodejs \
    && npm install -g npm yarn

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY php.ini /etc/php/8.4/fpm/conf.d/99-custom.ini
COPY php.ini /etc/php/8.4/cli/conf.d/99-custom.ini
COPY www.conf /etc/php/8.4/fpm/pool.d/www.conf
COPY php-fpm.conf /etc/php/8.4/fpm/php-fpm.conf
COPY start-container /usr/local/bin/start-container
RUN chmod +x /usr/local/bin/start-container

RUN mkdir -p /var/www/html/storage/logs /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 9000

ENTRYPOINT ["/usr/local/bin/start-container"]
