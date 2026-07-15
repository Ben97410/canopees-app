# Utilise une image PHP officielle
FROM php:8.2-apache

# Installe les dépendances nécessaires
RUN apt-get update && apt-get install -y libpng-dev libzip-dev zip unzip
RUN docker-php-ext-install pdo_mysql gd zip

# Copie votre code dans le dossier du serveur
COPY . /var/www/html

# Configure Apache pour Symfony
RUN a2enmod rewrite
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Donne les droits d'écriture au dossier var
RUN chown -R www-data:www-data /var/www/html/var