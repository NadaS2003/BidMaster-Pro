FROM php:8.2-apache

# تثبيت المتطلبات الأساسية ومكتبات النظام اللازمة للاراول وقاعدة البيانات
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libpq-dev

# تنظيف الكاش لتقليل حجم الـ Image
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# تثبيت ملحقات PHP الضرورية لـ Laravel و MySQL/PostgreSQL
RUN docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd

# تثبيت Composer (مدير حزم PHP)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# إعداد المجلد الرئيسي للعمل داخل الحاوية
WORKDIR /var/www/html

# نسخ ملفات المشروع إلى الحاوية
COPY . /var/www/html

# تعيين صلاحيات مجلدات التخزين والكاش
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# تغيير مسار الـ Apache DocumentRoot ليشير إلى مجلد public في لاراول
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# تفعيل Module الـ Rewrite الخاص بـ Apache ليعمل نظام مسارات لاراول بشكل صحيح
RUN a2enmod rewrite

# تثبيت حزم المشروع عبر Composer
RUN composer install --no-dev --optimize-autoloader --no-interaction --verbose
