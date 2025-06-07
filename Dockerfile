# 1. Image de base : PHP 8.3 avec Apache intégré
FROM php:8.3-apache

# 2. Installation des extensions PHP nécessaires (PDO pour MySQL)
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Install MongoDB extension
RUN pecl install mongodb && docker-php-ext-enable mongodb

# 3. Active le module mod_rewrite d'Apache (nécessaire pour certaines URL réécrites)
RUN a2enmod rewrite

# 4. Copie les fichiers frontend dans le dossier web d’Apache
COPY ./public /var/www/html

# 5. Copie les dossiers PHP backend dans le conteneur, sans les exposer publiquement
COPY ./config /var/www/config
COPY ./controllers /var/www/controllers
COPY ./helpers /var/www/helpers
COPY ./views /var/www/views
COPY ./scripts /var/www/scripts
COPY ./src /var/www/src
COPY ./vendor /var/www/vendor

# 6. Donne les droits au serveur web (parfois utile sur Windows/Mac)
RUN chown -R www-data:www-data /var/www

# Ajout de la variable d’environnement pour Apache/PHP
RUN echo "SetEnv APP_ENV local" >> /etc/apache2/apache2.conf
