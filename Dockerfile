FROM php:8.2-fpm

RUN curl -sS https://getcomposer.org/installer | php -- \
     --install-dir=/usr/local/bin --filename=composer

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN apt-get update && apt-get install -y zlib1g-dev \
    libzip-dev \
    unzip \
    default-mysql-client

RUN docker-php-ext-install pdo pdo_mysql sockets zip


WORKDIR /var/www

ADD . /var/www
RUN touch /var/www/storage/logs/laravel.log

RUN composer install --ignore-platform-req=ext-gd

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory contents
COPY . /var/www

# Copy existing application directory permissions
COPY --chown=www:www . /var/www

# Change ownership of the application directory to www user and group
RUN chown -R www:www /var/www

# Make storage/logs writable by the www user
RUN chmod -R 775 /var/www/storage/logs

# Change current user to www
USER www

CMD ["php-fpm"]
EXPOSE 9000
