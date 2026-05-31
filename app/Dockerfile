FROM php:8.2-apache

# Instalar la extensión PDO MySQL para que PHP pueda hablar con la BD
RUN docker-php-ext-install pdo pdo_mysql

# COPIAR todo el contenido de la carpeta app dentro del servidor Apache (Corregido)
COPY . /var/www/html/

# Indicar que el contenedor escuchará en el puerto 80
EXPOSE 80
