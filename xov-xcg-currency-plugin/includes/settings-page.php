<?php
if (!defined('ABSPATH')) exit;

// Add settings page to the admin menu
add_action('admin_menu', function() {
    add_options_page(
        'XCG Currency Settings',
        'XCG Currency',
        'manage_options',
        'xov-xcg-currency',
        'xov_xcg_settings_page'
    );
});

// Render settings page
function xov_xcg_settings_page() {
    if (isset($_POST['xov_xcg_currency_rate'])) {
        $rate = sanitize_text_field($_POST['xov_xcg_currency_rate']);

        if (is_numeric($rate) && floatval($rate) > 0) {
            update_option(XOV_XCG_CURRENCY_OPTION_NAME, $rate);
            echo '<div class="updated"><p>Conversion rate updated successfully!</p></div>';
        } else {
            echo '<div class="error"><p>Please enter a valid numeric conversion rate greater than 0.</p></div>';
        }
    }

    $current_rate = get_option(XOV_XCG_CURRENCY_OPTION_NAME, '1.82');
    $current_currency = get_woocommerce_currency(); // Get the current currency in WooCommerce

    ?>
    <div class="wrap">
        <h1>XCG Currency Settings</h1>
        <form method="POST">
            <table class="form-table">
                <tr>
                    <th scope="row">
                            Conversion Rate (1 <?php echo esc_html($current_currency); ?> = XCG):
                    </th>
                    <td>
                        <?php if ($current_currency !== 'XCG') : ?>
                            <div style="position: relative;">
                                <input type="text" name="xov_xcg_currency_rate" value="<?php echo esc_attr($current_rate); ?>" />
                            </div>
                        <?php endif; ?>
                        <p class="description">
                            <?php if ($current_currency === 'XCG') : ?>
                                Since your WooCommerce currency is set to <strong>XCG</strong>, no conversion is needed.
                            <?php else : ?>
                                Enter the conversion rate manually. The current WooCommerce currency is: <strong><?php echo esc_html($current_currency); ?></strong>.
                            <?php endif; ?>
                        </p>
                    </td>
                </tr>
            </table>
            <?php if ($current_currency !== 'XCG') : ?>
                <?php submit_button('Save Changes'); ?>
            <?php endif; ?>
        </form>
    </div>
    <?php
}
