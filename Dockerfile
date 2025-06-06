FROM php:8.2-apache

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Ativa mod_rewrite (caso necessário futuramente)
RUN a2enmod rewrite

# Copia os arquivos HTML/PHP para o Apache
WORKDIR /var/www/html
