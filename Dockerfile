FROM php:8.2.12-apache

RUN docker-php-ext-install pdo_mysql

# code récupéré sur internet permettant de faire fonctionner les .htaccess et changeant une ligne du fichier de configuration d'apache AllowOverride en All, commande expliquée avec l'aide d'un assitant IA
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Installation de l'extension PHP pour MongoDB
RUN apt-get update && apt-get install -y libssl-dev pkg-config unzip git \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb

# Récupération de Composer depuis son image officielle
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer