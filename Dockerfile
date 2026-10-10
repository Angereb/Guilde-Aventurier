FROM php:8.2.12-apache

RUN docker-php-ext-install pdo_mysql

# code récupéré sur internet permettant de faire fonctionner les .htaccess et changeant une ligne du fichier de configuration d'apache AllowOverride en All, commande expliquée avec l'aide d'un assitant IA
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf