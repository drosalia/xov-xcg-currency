# Use the official WordPress image as the base image
FROM wordpress:latest

# Install required dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    mariadb-client \
    curl \
    unzip \
    less \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy the plugin files to the WordPress plugins directory
COPY ./xov-xcg-currency-plugin /var/www/html/wp-content/plugins/xov-xcg-currency-plugin

# Change working directory to the plugin folder
WORKDIR /var/www/html/wp-content/plugins/xov-xcg-currency-plugin

# Install Composer dependencies for PHPUnit
RUN composer install

# Copy custom PHP configuration file
COPY php.ini /usr/local/etc/php/conf.d/99-custom.ini

# Ensure proper permissions
RUN chown -R www-data:www-data /var/www/html/wp-content/plugins

# Install WP-CLI
RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar \
    && chmod +x wp-cli.phar \
    && mv wp-cli.phar /usr/local/bin/wp

# Copy entrypoint script
COPY ./docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Expose port 80 for the WordPress container
EXPOSE 80

# Use the custom entrypoint script
ENTRYPOINT ["/entrypoint.sh"]
