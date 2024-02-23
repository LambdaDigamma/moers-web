#FROM serversideup/php:beta-fpm-nginx as api
FROM serversideup/php:beta-8.2-fpm-nginx-alpine as api



WORKDIR /usr/src

ARG user
ARG uid
ARG GITHUB_ACCESS_TOKEN
ARG LF_GITHUB_ACCESS_TOKEN
ARG SPATIE_USERNAME
ARG SPATIE_PASSWORD

ENV COMPOSER_ALLOW_SUPERUSER=1
ENV APP_BASE_DIR="/usr/src"

RUN apk add --no-cache git
RUN install-php-extensions gd exif intl

RUN git config --global url."https://${GITHUB_ACCESS_TOKEN}@github.com".insteadOf "ssh://git@github.com"

#RUN mkdir -p /home/$user/.composer

COPY ./src/composer*.json /usr/src/
COPY ./deployment/config/php-fpm/php-prod.ini /usr/local/etc/php/conf.d/php.ini
COPY ./deployment/config/php-fpm/www.conf /usr/local/etc/php-fpm.d/www.conf
COPY ./deployment/bin/update.sh /usr/src/update.sh

RUN rm -rf vendor

COPY ./src .

# Setup Composer Packages

RUN composer config github-oauth.github.com $GITHUB_ACCESS_TOKEN \
    && composer config http-basic.satis.spatie.be $SPATIE_USERNAME $SPATIE_PASSWORD \
    && composer global config --no-plugins allow-plugins.franzl/studio true

RUN composer global require franzl/studio \
    && rm -rf studio.json

RUN composer install --no-scripts --optimize-autoloader

# Generate .npmrc
RUN echo "//npm.pkg.github.com/:_authToken=$LF_GITHUB_ACCESS_TOKEN" > .npmrc && \
    echo "@spatie:registry=https://npm.pkg.github.com" >> .npmrc
#
#RUN CI=1 pnpm install && \
#    pnpm run prod

RUN php artisan storage:link && \
    chmod +x ./update.sh && \
    chown -R $user:$user /usr/src && \
    chmod -R 775 ./storage ./bootstrap/cache

RUN curl "https://awscli.amazonaws.com/awscli-exe-linux-x86_64.zip" -o "awscliv2.zip" && \
    unzip awscliv2.zip && \
    ./aws/install

#USER $user

FROM api AS worker
COPY ./deployment/config/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisor.conf
CMD ["/bin/sh", "/usr/src/worker.sh"]

FROM api AS scheduler
CMD ["/bin/sh", "/usr/src/scheduler.sh"]
