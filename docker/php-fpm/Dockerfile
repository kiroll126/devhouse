FROM bitnami/php-fpm:7.4

RUN install_packages build-essential gcc libzip-dev zip autoconf
RUN install_packages php-xml php-curl php-gd
RUN pecl install zip

RUN addgroup --gid 1000 kiroll \
    && adduser \
      --system \
      --uid 1000 \
      --gid 1000 \
      --disabled-password \
      --disabled-login \
      kiroll \
    # enable non-root user usage
    && chmod -R g+w /opt/bitnami/php/var /opt/bitnami/php/tmp \
    && chgrp -R kiroll \
      /opt/bitnami/php/var \
      /opt/bitnami/php/tmp \
    && ln -s /dev/stdout /opt/bitnami/php/logs/php-fpm.log

USER kiroll
