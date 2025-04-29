# Usar imagen oficial de PHP con Apache
FROM php:8.1-apache

# Copiar todos los archivos de tu proyecto al servidor Apache
COPY . /var/www/html/

# Exponer el puerto 80
EXPOSE 80
