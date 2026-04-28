FROM php:8.3-apache

ENV APP_ENV=production \
    APP_DEBUG=false \
    APACHE_DOCUMENT_ROOT=/var/www/html/public \
    COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_NO_INTERACTION=1

RUN apt-get update && apt-get install -y --no-install-recommends \
    git curl unzip libpq-dev libzip-dev libonig-dev libpng-dev libjpeg-dev libfreetype6-dev \
    libicu-dev libxml2-dev sqlite3 libsqlite3-dev ca-certificates gnupg \
 && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
 && apt-get install -y nodejs \
 && docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install -j"$(nproc)" pdo_pgsql pdo_mysql pdo_sqlite zip gd intl bcmath opcache \
 && a2enmod rewrite headers \
 && rm -rf /var/lib/apt/lists/*

# Apache: serve Laravel from /var/www/html/public, listen on $PORT.
RUN printf '<VirtualHost *:${PORT}>\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        Options -Indexes +FollowSymLinks\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
    ErrorLog ${APACHE_LOG_DIR}/error.log\n\
    CustomLog ${APACHE_LOG_DIR}/access.log combined\n\
</VirtualHost>\n' > /etc/apache2/sites-available/000-default.conf \
 && sed -ri -e 's!Listen 80!Listen ${PORT}!g' /etc/apache2/ports.conf \
 && echo "ServerName localhost" > /etc/apache2/conf-available/servername.conf \
 && a2enconf servername

ENV PORT=8080

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/html

# Install PHP deps first (better Docker layer cache)
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --prefer-dist --no-progress

# Install Node deps + build assets
COPY package.json package-lock.json ./
RUN npm ci

# Copy app, then build frontend + finalize composer
COPY . .
RUN npm run build \
 && composer dump-autoload --optimize --classmap-authoritative \
 && chown -R www-data:www-data storage bootstrap/cache \
 && rm -rf node_modules

COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 8080
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["apache2-foreground"]
