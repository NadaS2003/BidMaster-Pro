FROM php:8.4-apache

# تثبيت المتطلبات الأساسية ومكتبات النظام
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libpq-dev \
    gnupg

# تثبيت Node.js (مطلوب لبناء Vite)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# تثبيت ملحقات PHP
RUN docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd fileinfo xml curl

# تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . /var/www/html

# تثبيت حزم PHP
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts --verbose

# تثبيت حزم الواجهات وبناء الـ Vite تلقائياً
RUN npm install && npm run build

# صلاحيات ومجلدات Apache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf
RUN a2enmod rewrite
