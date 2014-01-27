<?php
/**
 * Manages product post type
 *
 * Here all product fields are defined.
 *
 * @version		1.0.0
 * @package		ecommerce-product-catalog/includes
 * @author 		Norbert Dreszer
 */
 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
 require_once('category-widget.php');
// hook into the init action and call create_book_taxonomies when it fires
add_action( 'init', 'create_product_categories', 0 );

// create two taxonomies, genres and writers for the post type "book"
function create_product_categories() {
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => __( 'Product Categories', 'al-ecommerce-product-catalog' ),
		'singular_name'     => __( 'Product Category', 'al-ecommerce-product-catalog' ),
		'search_items'      => __( 'Search Product Categories', 'al-ecommerce-product-catalog' ),
		'all_items'         => __( 'All Product Categories', 'al-ecommerce-product-catalog' ),
		'parent_item'       => __( 'Parent Product Category', 'al-ecommerce-product-catalog' ),
		'parent_item_colon' => __( 'Parent Product Category:', 'al-ecommerce-product-catalog' ),
		'edit_item'         => __( 'Edit Product Category', 'al-ecommerce-product-catalog' ),
		'update_item'       => __( 'Update Product Category', 'al-ecommerce-product-catalog' ),
		'add_new_item'      => __( 'Add New Product Category', 'al-ecommerce-product-catalog' ),
		'new_item_name'     => __( 'New Product Category', 'al-ecommerce-product-catalog' ),
		'menu_name'         => __( 'Product Categories', 'al-ecommerce-product-catalog' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'product-category' ),
		'capabilities' => array (
            'manage_terms' => 'manage_product_categories', 
            'edit_terms' => 'edit_product_categories',
            'delete_terms' => 'delete_product_categories',
            'assign_terms' => 'assign_product_categories' 
            )
	);

	register_taxonomy( 'al_product-cat', array( 'al_product' ), $args );
}

?>
