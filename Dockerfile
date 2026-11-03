FROM php:8.2-apache

# Instala extensões PDO MySQL e utilitários
RUN docker-php-ext-install pdo pdo_mysql \
    && a2enmod rewrite

# Configuração do DocumentRoot
WORKDIR /var/www/html

EXPOSE 80
