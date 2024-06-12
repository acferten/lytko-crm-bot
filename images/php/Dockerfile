FROM php:8.3-fpm-alpine

WORKDIR /var/www

#install packages
RUN apk update && apk add \
    build-base \
    vim \
    bash \
    curl \
    supervisor \
    busybox-suid

# Install extensions
RUN curl -sSLf \
            -o /usr/local/bin/install-php-extensions \
            https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions
RUN chmod +x /usr/local/bin/install-php-extensions
RUN install-php-extensions \
            pdo \
            pdo_pgsql

#install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add ini-files
COPY ./images/php/php.ini /usr/local/etc/php/conf.d/40-custom.ini
COPY ./images/supervisor/supervisor.ini /etc/supervisor.d/supervisor.ini

# Clean
RUN rm -rf /var/cache/apk/* && docker-php-source delete

RUN addgroup -g 1000 -S www && \
    adduser -u 1000 -S www -G www

RUN chown www /etc/supervisord.conf

# Change current user to non-root user
USER www

COPY ./images/crontab.txt /crontab.txt

RUN /usr/bin/crontab /crontab.txt

EXPOSE 9000
