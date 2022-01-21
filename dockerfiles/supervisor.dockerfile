# FROM php:8.0-cli

# ARG UID
# ARG GID

# ENV UID=${UID}
# ENV GID=${GID}

# RUN mkdir -p /var/www/html

# WORKDIR /var/www/html

# # MacOS staff group's gid is 20, so is the dialout group in alpine linux. We're not using it, let's just remove it.
# RUN delgroup dialout

# RUN addgroup -g ${GID} --system laravel
# RUN adduser -G laravel --system -D -s /bin/sh -u ${UID} laravel

# RUN docker-php-ext-install pdo_mysql \
#     && docker-php-ext-install bcmath

# # RUN apk update && apk add supervisor
# RUN apt-get update && apt-get install -y --no-install-recommends supervisor
# RUN mkdir -p /etc/supervisor.d/

# ADD ./supervisor/laravel-worker.ini /etc/supervisor.d/

# CMD ["supervisord", "-c", "/etc/supervisord.conf"]

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
