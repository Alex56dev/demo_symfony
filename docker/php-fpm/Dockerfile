FROM php:7.4.12-fpm

RUN apt update
RUN apt install -y git

RUN echo "$(curl -sS https://composer.github.io/installer.sig) -" > composer-setup.php.sig \
        && curl -sS https://getcomposer.org/installer | tee composer-setup.php | sha384sum -c composer-setup.php.sig \
        && php composer-setup.php && rm composer-setup.php* \
        && chmod +x composer.phar && mv composer.phar /usr/bin/composer

COPY symfony.ini /usr/local/etc/php/conf.d/
COPY symfony.ini /usr/local/etc/php/conf.d/
# COPY xdebug.ini  /usr/local/etc/php/conf.d/

COPY symfony.pool.conf /usr/local/etc/php-fpm.d/

RUN groupadd --gid 1000 app \
  && useradd --uid 1000 --gid app --shell /bin/bash --create-home app

USER app

WORKDIR /var/www/symfony
EXPOSE 9001

CMD ["php-fpm", "-F"]
