# # Use the official PHP image with Apache
# FROM php:8.2-apache

# # Set the working directory
# WORKDIR /var/www/html

# # Install PHP extensions and dependencies
# RUN apt-get update && apt-get install -y \
#     libpng-dev \
#     libjpeg-dev \
#     libfreetype6-dev \
#     locales \
#     zip \
#     git \
#     unzip \
#     curl \
#     && docker-php-ext-configure gd --with-freetype --with-jpeg \
#     && docker-php-ext-install pdo pdo_mysql gd

# # Install Composer
# COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# # Copy application source code
# COPY . /var/www/html

# # Set permissions for Laravel
# RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# # Enable Apache rewrite module
# RUN a2enmod rewrite

# # Copy custom Apache config
# COPY apache-config.conf /etc/apache2/conf-available/
# RUN a2enconf apache-config

# # Expose port 80
# EXPOSE 80

# # Start Apache
# CMD ["apache2-foreground"]


# # Use the official PHP image with Apache
# FROM php:8.2-apache

# # Set the working directory
# WORKDIR /var/www/html

# # Install PHP extensions and dependencies
# RUN apt-get update && apt-get install -y \
#     libpng-dev \
#     libjpeg-dev \
#     libfreetype6-dev \
#     locales \
#     zip \
#     git \
#     unzip \
#     curl \
#     && docker-php-ext-configure gd --with-freetype --with-jpeg \
#     && docker-php-ext-install pdo pdo_mysql gd

# # Install Composer
# COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# # Copy application source code to the /var/www/html directory
# COPY . /var/www/html/

# # Set permissions for Laravel
# RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# # Enable Apache rewrite module
# RUN a2enmod rewrite

# # Expose port 80
# EXPOSE 80

# # Start Apache
# CMD ["apache2-foreground"]




# Use the official PHP image with Apache
FROM php:8.2-apache

# Set the working directory
WORKDIR /var/www/html

# Install PHP extensions and dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    locales \
    zip \
    git \
    unzip \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql gd

# Install Composer (latest version)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application source code to the /var/www/html directory
COPY . /var/www/html/

# Ubah DocumentRoot ke folder /public dari Laravel
RUN sed -i 's#/var/www/html#/var/www/html/public#' /etc/apache2/sites-available/000-default.conf

# Set permissions for Laravel's storage and cache directories
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Enable Apache rewrite module
RUN a2enmod rewrite

# Install additional dependencies for the locale
RUN echo "en_US.UTF-8 UTF-8" > /etc/locale.gen && \
    locale-gen

# Ensure that the correct permissions for Apache are set on the Laravel app
RUN chown -R www-data:www-data /var/www/html

# Expose port 80 to the outside world
EXPOSE 80

# Start Apache service
CMD ["apache2-foreground"]

