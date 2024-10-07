FROM php:8.1-apache

RUN cp /etc/apache2/mods-available/rewrite.load /etc/apache2/mods-enabled/

RUN mkdir /var/www/html/canalesventa
COPY . /var/www/html/canalesventa

RUN apt-get update && apt-get install -y nano
RUN docker-php-ext-install pdo_mysql
RUN apt-get update && apt-get install  -y default-mysql-client
RUN pecl install xdebug && docker-php-ext-enable xdebug

ENV APP_NAME=APICanalesVenta
ENV APP_ENV=local
ENV APP_KEY=Tp4@oeperRTDFkk%32
ENV APP_DEBUG=true
ENV APP_URL=http://localhost
ENV APP_TIMEZONE=UTC

ENV LOG_CHANNEL=stack
ENV LOG_SLACK_WEBHOOK_URL=
 
ENV DB_CONNECTION_CANALESVENTA=mysql
ENV DB_HOST_CANALESVENTA=apicanalesventa-mysql
ENV DB_PORT_CANALESVENTA=3306
ENV DB_DATABASE_CANALESVENTA=db_canalesventa
ENV DB_USERNAME_CANALESVENTA=root
ENV DB_PASSWORD_CANALESVENTA=Bank1234#

ENV CACHE_DRIVER=file
ENV QUEUE_CONNECTION=sync

ENV PRODUCTOS_API_HOST=http://apictrlprecios-php/controlprices/
ENV PRODUCTOS_API_VERSION=public/api/
 
ENV APP_AUTHUSER_HOST=http://apiuserauth-php/
ENV APP_AUTHUSER_APIVERSION=usrauth/public/

WORKDIR /var/www/html/canalesventa
RUN /etc/init.d/apache2 restart
RUN echo "xdebug.mode = off" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
    echo "xdebug.start_with_request  = yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
    echo "xdebug.client_host = host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
    echo "xdebug.idekey =""VSCODE""" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
    echo "xdebug.discover_client_host = 1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
    echo "xdebug.client_port = 9103" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini 


EXPOSE 80
CMD ["apache2-foreground"]