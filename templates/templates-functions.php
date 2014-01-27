<?php
/**
 * WP Product template functions
 *
 * Here all plugin template functions are defined.
 *
 * @version		1.0.0
 * @package		ecommerce-product-catalog/
 * @author 		Norbert Dreszer
 */
 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
function content_product_adder() {
if (is_archive()) {
content_product_adder_archive();
}
else  {
content_product_adder_single();
}
}

function content_product_adder_archive() {
include 'content-al_product_archive.php';
}

function content_product_adder_single() {
include 'content-al_product.php';
}
?>