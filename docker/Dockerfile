# Dockerfile

FROM php:8.3-fpm

# Installer les dépendances système
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libicu-dev \
    libonig-dev \
    libzip-dev \
    zlib1g-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libpq-dev \
    libxml2-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) intl opcache pdo pdo_mysql zip gd

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Installer Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

# Définir le répertoire de travail
WORKDIR /srv

# Copier les fichiers dans le conteneur
COPY . /srv

# Installer les dépendances PHP
RUN composer install --prefer-dist --no-scripts --no-progress --no-interaction

# Donner les permissions nécessaires au dossier var
RUN chown -R www-data:www-data /srv/var

# Exposer le port 9000 pour PHP-FPM
EXPOSE 9000

CMD ["php-fpm"]