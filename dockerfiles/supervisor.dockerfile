FROM php:8.0-cli


RUN mkdir -p /var/www/html

WORKDIR /var/www/html
#ENV APP_ROOT=/var/www/html QUEUE_DRIVER=database NUM_PROCS=4 OPTIONS=

ADD ./supervisor/laravel-worker.conf /etc/supervisor/conf.d/

RUN docker-php-ext-install pdo_mysql \
    && docker-php-ext-install bcmath \
    && apt-get update \
    && apt-get install -y --no-install-recommends supervisor

CMD ["supervisord", "-n", "-c", "/etc/supervisor/supervisord.conf"]
