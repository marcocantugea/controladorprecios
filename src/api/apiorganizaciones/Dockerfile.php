FROM php:8.1-apache

RUN cp /etc/apache2/mods-available/rewrite.load /etc/apache2/mods-enabled/

RUN mkdir /var/www/html/organizations
COPY . /var/www/html/organizations

RUN apt-get update && apt-get install -y nano
RUN docker-php-ext-install pdo_mysql
RUN apt-get update && apt-get install  -y default-mysql-client
RUN pecl install xdebug && docker-php-ext-enable xdebug

ENV APP_NAME=APIControladorPrecios
ENV APP_ENV=local
ENV APP_KEY=Rjdjri1030#29dDls#lsdlsk
ENV APP_DEBUG=true
ENV APP_URL=http://localhost
ENV APP_TIMEZONE=UTC
ENV LOG_CHANNEL=stack
ENV LOG_SLACK_WEBHOOK_URL=
 
ENV CACHE_DRIVER=file
ENV QUEUE_CONNECTION=sync
 
ENV DB_CONNECTION_ORG=mysql
ENV DB_HOST_ORG=mysql-ctrlprecios-service
ENV DB_PORT_ORG=3306
ENV DB_DATABASE_ORG=db_productosprecios
ENV DB_USERNAME_ORG=root
ENV DB_PASSWORD_ORG=Bank1234#

ENV DB_CONNECTION_USERS=users
ENV DB_HOST_USERS=mysql-usrauth-service
ENV DB_PORT_USERS=3306
ENV DB_DATABASE_USERS=mysql-usrauth-service
ENV DB_USERNAME_USERS=db_users
ENV DB_PASSWORD_USERS=Bank1234#
 
ENV APP_AUTHUSER_HOST=http://apiuserauth-php/
ENV APP_AUTHUSER_APIVERSION=usrauth/public/

WORKDIR /var/www/html/organizations
RUN /etc/init.d/apache2 restart
RUN echo "xdebug.mode = off" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
    echo "xdebug.start_with_request  = yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
    echo "xdebug.client_host = host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
    echo "xdebug.idekey =""VSCODE""" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
    echo "xdebug.discover_client_host = 1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
    echo "xdebug.client_port = 9103" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini 


EXPOSE 80
CMD ["apache2-foreground"]