FROM php:7.4-apache

MAINTAINER Jhonatan Morais <jhonatanvinicius@gmail.com>

# Update system
RUN apt-get update && \
    apt-get upgrade -y

# my stuffs
RUN apt-get install -y nano wget unzip git

# Composer install
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
	php composer-setup.php --install-dir=/usr/local/bin --filename=composer

#Instalação do php-zip
RUN apt-get install -y libzip-dev zip && \
    docker-php-ext-install zip

#Instalação do php-ldap
RUN apt-get install libldap2-dev -y && \
    docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/ && \
    docker-php-ext-install ldap

# Instalação do mysql
RUN docker-php-ext-install mysqli pdo_mysql

#Instalação laravel
RUN composer global require laravel/installer && \
	echo "alias laravel='~/.composer/vendor/bin/laravel'" >> ~/.bashrc && \
	alias laravel='~/.composer/vendor/bin/laravel' && \
    a2enmod rewrite

#Facilidades de uso
RUN sed -i 's+/var/www/html+/var/www/html/${DOCUMENT_ROOT_CONTEXT}+g' /etc/apache2/sites-available/000-default.conf && \
    sed -i 's+/var/www/html+/var/www/html/${DOCUMENT_ROOT_CONTEXT}+g' /etc/apache2/sites-available/default-ssl.conf && \
	sed -i 's+AllowOverride None+AllowOverride ${ALLOW_OVERRIDE_OPTION} \n SetEnv APPLICATION_ENV ${APPLICATION_ENV_OPTION}+g' /etc/apache2/apache2.conf

# Copy existing application directory contents
COPY ./ /var/www/html/

EXPOSE 80
CMD ["php-fpm"]
