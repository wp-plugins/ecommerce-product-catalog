<?php
/**
 * WP Product template functions
 *
 * Here all plugin template functions are defined.
 *
 * @version		1.1.3
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

function content_product_adder_archive_before() {
$page_id = get_option('product_archive');
$page = get_post($page_id);
return '<div class="entry-summary">'.$page->post_content.'</div>';
}

function content_product_adder_archive_before_title() {
$page_id = get_option('product_archive');
$page = get_post($page_id);
echo '<h1 class="entry-title">'.$page->post_title.'</h1>';
}
?>