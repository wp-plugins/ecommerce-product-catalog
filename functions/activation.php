<?php

function create_products_page() {
$product_page = array(
	'post_title' => __('Products', 'al-ecommerce-product-catalog'),
	'post_content' => '',
	'post_status' => 'publish',
	'comment_status' => 'closed'
);
 
$post_id = wp_insert_post($product_page);
add_option('product_archive_page_id', $post_id);
}