FROM php:8.1.30-apache

RUN cp /etc/apache2/mods-available/rewrite.load /etc/apache2/mods-enabled/

RUN mkdir /var/www/html/usrauth
COPY . /var/www/html/usrauth

RUN chown -R www-data:www-data /var/www/html/usrauth
RUN chmod -R 775 /var/www/html

RUN apt-get update && apt-get install -y nano
RUN docker-php-ext-install pdo_mysql
RUN apt-get update && apt-get install  -y default-mysql-client

# Actualiza los repositorios e instala Composer
RUN apt-get update && apt-get install -y curl git unzip \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html/usrauth

RUN composer update

# En tu Dockerfile
ENV APP_NAME=apiusuariosroles
ENV APP_ENV=local
ENV APP_KEY=
ENV APP_DEBUG=true
ENV APP_URL=http://localhost
ENV APP_TIMEZONE=UTC
ENV LOG_CHANNEL=stack
ENV LOG_SLACK_WEBHOOK_URL=
ENV DB_CONNECTION_USERS=users
ENV DB_HOST_USERS=mysql
ENV DB_PORT_USERS=3306
ENV DB_DATABASE_USERS=db_users
ENV DB_USERNAME_USERS=root
ENV DB_PASSWORD_USERS=Bank1234#
ENV CACHE_DRIVER=file
ENV QUEUE_CONNECTION=sync

RUN /etc/init.d/apache2 restart


EXPOSE 80
CMD ["apache2-foreground"]