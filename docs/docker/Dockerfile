# Usa l'immagine ufficiale di PHP con Apache
FROM php:8.2.26-apache

# Copia i file del progetto nella cartella di Apache
COPY . /var/www/html/
COPY php.ini /usr/local/etc/php/

# Abilita il modulo di riscrittura di Apache e mysqli
RUN a2enmod rewrite
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Espone la porta 80 (HTTP)
EXPOSE 80
