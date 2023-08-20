FROM php:8.1.12-fpm

RUN apt-get update \
    && apt-get -y install \
        cron \
        bash \
        procps \
        git \
        zip \
        unzip \
        wget \
        zsh \
        ffmpeg

# install php extension
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions gd xdebug-3.2.0 zip ssh2 pdo_mysql pdo_pgsql redis intl opcache @composer-2

RUN curl -OL https://www.phing.info/get/phing-2.16.4.phar \
    && mv ./phing-2.16.4.phar /usr/bin/phing \
    && chmod +x /usr/bin/phing

RUN echo "user = $LINUX_USER_ID" > /usr/local/etc/php-fpm.d/www.conf \
    && echo "group = $LINUX_USER_ID" >> /usr/local/etc/php-fpm.d/www.conf \
    && echo 'listen = 127.0.0.1:9000' >> /usr/local/etc/php-fpm.d/www.conf \
    && echo 'pm = dynamic' >> /usr/local/etc/php-fpm.d/www.conf \
    && echo 'pm.max_children = 5' >> /usr/local/etc/php-fpm.d/www.conf \
    && echo 'pm.start_servers = 2' >> /usr/local/etc/php-fpm.d/www.conf \
    && echo 'pm.min_spare_servers = 1' >> /usr/local/etc/php-fpm.d/www.conf \
    && echo 'pm.max_spare_servers = 3' >> /usr/local/etc/php-fpm.d/www.conf

ARG LINUX_USER_ID
RUN addgroup --gid $LINUX_USER_ID docker && \
    adduser --uid $LINUX_USER_ID --ingroup docker --home /home/docker --shell /bin/zsh --disabled-password --gecos "" docker

USER $LINUX_USER_ID

WORKDIR /var/www/test_task
