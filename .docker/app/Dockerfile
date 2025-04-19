FROM php:8.4-fpm

WORKDIR /var/www

# Установка системных зависимостей (Debian/Ubuntu использует apt)
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    libpq-dev

# Установка PHP расширений
RUN docker-php-ext-install pdo pdo_pgsql gd zip

# Установка Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin \
    --filename=composer

# Установка Node.js 18.x (через NodeSource)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm@latest \
    && rm -rf /var/lib/apt/lists/*
