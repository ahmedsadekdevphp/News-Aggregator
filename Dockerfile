# Set the base image
FROM php:8.1-apache

# Install system dependencies, PHP extensions, and cron
RUN apt-get update && apt-get install -y \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    git \
    cron \
    nano \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip

# Install PHP extensions
COPY ./apache2.conf /etc/apache2/sites-available/000-default.conf
RUN a2ensite 000-default.conf

# Install Composer globally
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set the working directory
WORKDIR /var/www/html

# Copy the existing application directory contents
COPY . /var/www/html

# Copy the application code
COPY . .

# Set permissions for the web directory
RUN chown -R www-data:www-data /var/www/html  \
    && chmod  -R 777 /var/www/html

# Install Composer dependencies
RUN composer install --no-interaction --optimize-autoloader

# Run migrations automatically (optional, use with caution in production)
RUN php artisan migrate --force

# Expose port 9000
EXPOSE 9000

# Add cron job to run Laravel scheduler
RUN echo "* * * * * cd /var/www && php artisan schedule:run >> /var/www/storage/logs/scheduler.log 2>&1" > /etc/cron.d/laravel-scheduler

# Apply cron job and start cron daemon
RUN chmod 0644 /etc/cron.d/laravel-scheduler && crontab /etc/cron.d/laravel-scheduler

# Start PHP-FPM and cron services
CMD service cron start && php-fpm
