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

function show_products_outside_loop($atts) {
extract(shortcode_atts(array( 
		'post_type' => 'al_product',
		'category' => 2,
		'product' => 0,
    ), $atts));

if ($product != 0) {
	$product_array = explode(',', $product);
	$query = new WP_Query( array (
		'post_type' => 'al_product',
		'post__in' => $product_array,
		));
}
else {
	$category_array = explode(',', $category);
	$query = new WP_Query( array (
		'post_type' => 'al_product',
		'tax_query' => array(
			array(
				'taxonomy' => 'al_product-cat',
				'field' => 'term_id',
				'terms' => $category_array,
			),
		),
		));
}
$inside = '';
$archive_template = get_option( 'archive_template', 'default');
if ($archive_template == 'default') {
	while ( $query->have_posts() ) : $query->the_post(); global $post;
		$inside .= default_archive_theme($post);
	endwhile; wp_reset_postdata();
}
else if ($archive_template == 'list') {
	while ( $query->have_posts() ) : $query->the_post(); global $post;
		$inside .= list_archive_theme($post);
	endwhile; wp_reset_postdata();
}
else {
	while ( $query->have_posts() ) : $query->the_post(); global $post;
		$inside .= grid_archive_theme($post);
	endwhile; wp_reset_postdata();
}
return $inside;
}

add_shortcode('show_products', 'show_products_outside_loop');

function single_scripts(){
$enable_catalog_lightbox = get_option('catalog_lightbox', 1);
if ($enable_catalog_lightbox == 1) {
wp_enqueue_script('colorbox');
wp_enqueue_style('colorbox');
}}
add_action( 'wp_enqueue_scripts', 'single_scripts' );
?>