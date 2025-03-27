<?php

use PHPUnit\Framework\TestCase;

class PriceFormattingTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Ensure WooCommerce and WordPress are properly loaded
        if (!defined('ABSPATH')) {
            define('ABSPATH', '/var/www/html/');
        }
    }

    /** @test */
    public function it_applies_the_correct_currency_symbol_with_space()
    {
        // Test the woocommerce_currency_symbol filter
        $currency_symbol = apply_filters('woocommerce_currency_symbol', 'XCG', 'XCG');
        $this->assertEquals('Cg ', $currency_symbol, "Currency symbol should be 'Cg '");
    }

    /** @test */
    public function it_applies_the_correct_price_format()
    {
        // Test the woocommerce_price_format filter
        $price_format = apply_filters('woocommerce_price_format', '%1$s%2$s', 'left', 'XCG');
        $this->assertEquals('%1$s%2$s', $price_format, "Price format should be '%1$s%2$s'");
    }

    /** @test */
    public function it_applies_the_correct_conversion_rate()
    {
        // Simulate the stored conversion rate
        update_option('xov_xcg_currency_rate', '1.82');

        $price_in_usd = 10.00;
        $expected_price = round(10.00 * 1.82, 2);

        // Apply the conversion
        $converted_price = xov_xcg_convert_price($price_in_usd, null);

        $this->assertEquals($expected_price, $converted_price, "Converted price should be $expected_price");
    }

    /** @test */
    public function it_displays_price_correctly_as_html()
    {
        // Simulate the stored conversion rate
        update_option('xov_xcg_currency_rate', '1.82');

        $price_in_usd = 10.00;
        $expected_price = round(10.00 * 1.82, 2);
        $expected_price_html = wc_price($expected_price, ['currency' => 'XCG']);

        // Apply the conversion
        $price_html = xov_xcg_convert_price_html($expected_price_html, null);

        $this->assertEquals($expected_price_html, $price_html, "Displayed price HTML should be $expected_price_html");
    }
}
