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

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application source code to the /var/www/html directory
COPY . /var/www/html/

# Set permissions for Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Enable Apache rewrite module
RUN a2enmod rewrite

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
