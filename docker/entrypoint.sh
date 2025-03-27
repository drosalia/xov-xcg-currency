#!/bin/bash
set -e

# Wait until MySQL is available
until mysql -h db -u"$WORDPRESS_DB_USER" -p"$WORDPRESS_DB_PASSWORD" -e 'SHOW DATABASES;' &> /dev/null; do
  echo "Waiting for database connection..."
  sleep 5
done

# Ensure WordPress core files are present
if [ ! -f /var/www/html/wp-config.php ]; then
    echo "Downloading WordPress core files..."
    wp core download --allow-root
fi

# Ensure WordPress is properly installed
if ! wp core is-installed --allow-root; then
    echo "Setting up WordPress installation..."
    wp config create --dbname="$WORDPRESS_DB_NAME" --dbuser="$WORDPRESS_DB_USER" --dbpass="$WORDPRESS_DB_PASSWORD" --dbhost="$WORDPRESS_DB_HOST" --allow-root
    wp core install --url="http://localhost:8080" --title="XOV Test Site" --admin_user="admin" --admin_password="password" --admin_email="admin@example.com" --skip-email --allow-root
fi

# Install and activate WooCommerce
if ! wp plugin is-installed woocommerce --allow-root; then
    echo "Installing WooCommerce..."
    wp plugin install woocommerce --activate --allow-root
fi

# Install and activate WooCommerce PDF Invoices & Packing Slips
if ! wp plugin is-installed 'woocommerce-pdf-invoices-packing-slips' --allow-root; then
    echo "Installing WooCommerce PDF Invoices & Packing Slips..."
    wp plugin install woocommerce-pdf-invoices-packing-slips --activate --allow-root
fi

# Activate the XOV XCG Currency plugin
if ! wp plugin is-active xov-xcg-currency-plugin --allow-root; then
    echo "Activating XOV XCG Currency Plugin..."
    wp plugin activate xov-xcg-currency-plugin --allow-root
fi

# Run Composer install to ensure dependencies are installed
cd /var/www/html/wp-content/plugins/xov-xcg-currency-plugin
composer install

# Start the original WordPress entrypoint
exec docker-entrypoint.sh apache2-foreground
