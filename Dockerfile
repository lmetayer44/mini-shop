# Base image avec PHP 8.2 et FPM
FROM php:8.4-fpm

# Installer les dépendances nécessaires
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev

# Installer les extensions PHP requises par Laravel
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copier les fichiers de l'application dans le conteneur
COPY . ./

# Copier le fichier .env.example vers .env avant l'installation de Composer
RUN test -f .env || cp .env.example .env

# Installer les dépendances PHP avec Composer
RUN composer install --ignore-platform-reqs --no-scripts --prefer-dist

# Générer la clé de l'application après avoir copié le fichier .env
RUN php artisan key:generate

# Assurer les bonnes permissions pour Laravel
RUN chown -R www-data:www-data storage bootstrap/cache vendor
RUN chmod -R 775 storage bootstrap/cache vendor

# Exposer le port 9000 et démarrer le serveur php-fpm
EXPOSE 9000
CMD ["php-fpm"]
