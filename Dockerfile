FROM php:8.2-apache

# Instaliraj potrebne PHP ekstenzije
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Kopiraj sve fajlove u web root
COPY . /var/www/html/

# Uključi mod_rewrite ako koristiš .htaccess
RUN a2enmod rewrite

# Promijeni prava ako zatreba
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
