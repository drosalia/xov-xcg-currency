<?php

// Load WordPress environment
define('WP_USE_THEMES', false);
require '/var/www/html/wp-load.php';

// Make sure WooCommerce is active
if (!in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    exit("WooCommerce is not active. Please activate it before running the tests.\n");
}
