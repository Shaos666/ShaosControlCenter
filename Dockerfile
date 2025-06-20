FROM php:8.2-apache

# Instala suporte ao MariaDB/MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Copia os arquivos do dashboard
COPY html/ /var/www/html/
