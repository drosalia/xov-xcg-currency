<?php
/**
 * Plugin Name: XOV XCG Currency
 * Description: Adds the Caribbean Guilder (XCG) as a currency with manual conversion rates for WooCommerce.
 * Version: 1.0.0
 * Author: Ten-O-5 B.V.
 * Text Domain: xov-xcg-currency-plugin
 */

if (!defined('ABSPATH')) exit;

define('XOV_XCG_CURRENCY_PLUGIN_VERSION', '1.0.0');
define('XOV_XCG_CURRENCY_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('XOV_XCG_CURRENCY_OPTION_NAME', 'xov_xcg_currency_rate');

// Activation Hook - Set Default Conversion Rate
function xov_xcg_activate() {
    if (!get_option(XOV_XCG_CURRENCY_OPTION_NAME)) {
        update_option(XOV_XCG_CURRENCY_OPTION_NAME, '1.82'); // Default conversion rate updated to 1.82
    }
}
register_activation_hook(__FILE__, 'xov_xcg_activate');

// Add XCG Currency to WooCommerce
add_filter('woocommerce_currencies', function ($currencies) {
    $currencies['XCG'] = __('Caribbean Guilder', 'xov-xcg-currency-plugin');
    return $currencies;
});

// Add Currency Symbol Before the Price
add_filter('woocommerce_currency_symbol', 'xov_xcg_add_currency_symbol', 10, 2);
function xov_xcg_add_currency_symbol($currency_symbol, $currency) {
    if ($currency === 'XCG') {
        $currency_symbol = 'Cg';
    }
    return $currency_symbol;
}

// Customize Price Format to Ensure Space Is Applied Everywhere
add_filter('woocommerce_price_format', 'xov_xcg_customize_price_format', 10, 3);
function xov_xcg_customize_price_format($format, $currency_pos = '', $currency = '') {
    if ($currency === 'XCG') {
        return '%1$s %2$s';  // Ensures space between currency symbol and amount
    }
    return $format;
}

// Convert Price Only If Current Currency Is Not XCG
add_filter('woocommerce_get_price', 'xov_xcg_convert_price', 10, 2);
add_filter('woocommerce_get_price_html', 'xov_xcg_convert_price_html', 10, 2);

function xov_xcg_convert_price($price, $product) {
    $current_currency = get_woocommerce_currency();

    if ($current_currency !== 'XCG') {  // Only convert if currency is NOT XCG
        $rate = (float) get_option(XOV_XCG_CURRENCY_OPTION_NAME, 1.82);
        $price = round($price * $rate, 2);
    }
    return $price;
}

function xov_xcg_convert_price_html($price_html, $product) {
    $current_currency = get_woocommerce_currency();

    if ($current_currency !== 'XCG') {  // Only convert if currency is NOT XCG
        $rate = (float) get_option(XOV_XCG_CURRENCY_OPTION_NAME, 1.82);
        $price = round((float) $product->get_price() * $rate, 2);
        $price_html = wc_price($price, ['currency' => 'XCG']);
    }
    return $price_html;
}

// Add Settings Page
require_once XOV_XCG_CURRENCY_PLUGIN_DIR . 'includes/settings-page.php';
