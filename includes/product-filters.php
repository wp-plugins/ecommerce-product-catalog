<?php

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Manages product search widget
 *
 * Here product search widget is defined.
 *
 * @version		1.4.0
 * @package		ecommerce-product-catalog/includes
 * @author 		Norbert Dreszer
 */
add_action( 'init', 'register_product_catalog_session' );

/**
 * Registers session if not registered already
 */
function register_product_catalog_session() {
	if ( !session_id() ) {
		session_start();
	}
}

function product_filter_element( $id, $what, $label, $class = null ) {
	$class = isset( $class ) ? 'filter-url ' . $class : 'filter-url';
	if ( is_product_filter_active( $what ) ) {
		if ( is_product_filter_active( $what, $id ) ) {
			$class .= ' active-filter';
			$id = 'clear';
		} else {
			$class .= ' not-active-filter';
		}
	}
	return '<a class="' . $class . '" href="' . esc_url( add_query_arg( array( $what => $id ) ) ) . '">' . $label . '</a>';
}

function get_product_category_filter_element( $category ) {
	$count	 = total_product_category_count( $category->term_id );
	$name	 = $category->name . ' (' . $count . ')';
	return product_filter_element( $category->term_id, 'product_category', $name );
}

add_action( 'wp_loaded', 'set_product_filter' );

/*
 * Sets up active filters
 *
 */

function set_product_filter() {
	if ( isset( $_GET[ 'product_category' ] ) ) {
		$filter_value = intval( $_GET[ 'product_category' ] );
		if ( !empty( $filter_value ) ) {
			$_SESSION[ 'filters' ][ 'product_category' ] = $filter_value;
		} else {
			unset( $_SESSION[ 'filters' ][ 'product_category' ] );
		}
	}
	if ( isset( $_GET[ 'min-price' ] ) ) {
		$filter_value = floatval( $_GET[ 'min-price' ] );
		if ( !empty( $filter_value ) ) {
			$_SESSION[ 'filters' ][ 'min-price' ] = $filter_value;
		} else {
			unset( $_SESSION[ 'filters' ][ 'min-price' ] );
		}
	}
	if ( isset( $_GET[ 'max-price' ] ) ) {
		$filter_value = floatval( $_GET[ 'max-price' ] );
		if ( !empty( $filter_value ) ) {
			$_SESSION[ 'filters' ][ 'max-price' ] = $filter_value;
		} else {
			unset( $_SESSION[ 'filters' ][ 'max-price' ] );
		}
	}
}

add_action( 'pre_get_posts', 'delete_product_filters', 2 );

/**
 * Clears current filters if there is a page reload without new filter assignment
 *
 */
function delete_product_filters( $query ) {
	if ( !is_search() && !is_admin() && $query->is_main_query() ) {
		$active_filters	 = get_active_product_filters();
		$out			 = false;
		foreach ( $active_filters as $filter ) {
			if ( isset( $_GET[ $filter ] ) ) {
				$out = true;
			}
		}
		if ( !$out ) {
			unset( $_SESSION[ 'filters' ] );
		}
	}
}

/**
 * Defines active product filters
 *
 * @return array
 */
function get_active_product_filters() {
	return apply_filters( 'active_product_filters', array( 'product_category', 'min-price', 'max-price' ) );
}

function get_product_filter_value( $filter_name ) {
	if ( is_product_filter_active( $filter_name ) ) {
		return $_SESSION[ 'filters' ][ $filter_name ];
	}
	return '';
}

add_action( 'pre_get_posts', 'apply_product_filters' );

/**
 * Applies current filters to the query
 *
 * @param object $query
 */
function apply_product_filters( $query ) {
	if ( !is_admin() && !is_home_archive( $query ) && $query->is_main_query() && is_product_filters_active() && (is_ic_product_listing( $query ) || is_ic_taxonomy_page()) ) {
		if ( is_product_filter_active( 'product_category' ) ) {
			$category_id = get_product_filter_value( 'product_category' );
			$taxquery	 = array(
				array(
					'taxonomy'	 => 'al_product-cat',
					'terms'		 => $category_id,
				)
			);
			$query->set( 'tax_query', $taxquery );
		}
		if ( is_product_filter_active( 'min-price' ) || is_product_filter_active( 'max-price' ) ) {
			$metaquery	 = array();
			$min_price	 = get_product_filter_value( 'min-price' );
			if ( !empty( $min_price ) ) {
				$metaquery[] = array(
					'key'		 => '_price',
					'compare'	 => '>=',
					'value'		 => $min_price,
					'type'		 => 'NUMERIC'
				);
			}
			$max_price = get_product_filter_value( 'max-price' );
			if ( !empty( $max_price ) ) {
				$metaquery[] = array(
					'key'		 => '_price',
					'compare'	 => '<=',
					'value'		 => $max_price,
					'type'		 => 'NUMERIC'
				);
			}
			$query->set( 'meta_query', $metaquery );
		}
		do_action( 'apply_product_filters', $query );
	}
}

add_filter( 'shortcode_query', 'apply_product_shortcode_filters' );
add_filter( 'home_product_listing_query', 'apply_product_shortcode_filters' );

/**
 * Applies product filters to shortcode query
 *
 * @param type $shortcode_query
 * @return type
 */
function apply_product_shortcode_filters( $shortcode_query ) {
	if ( is_product_filter_active( 'product_category' ) ) {
		$category_id					 = get_product_filter_value( 'product_category' );
		$taxquery						 = array(
			array(
				'taxonomy'	 => 'al_product-cat',
				'terms'		 => $category_id,
			)
		);
		$shortcode_query[ 'tax_query' ]	 = $taxquery;
	}
	if ( is_product_filter_active( 'min-price' ) || is_product_filter_active( 'max-price' ) ) {
		$metaquery	 = array();
		$min_price	 = get_product_filter_value( 'min-price' );
		if ( !empty( $min_price ) ) {
			$metaquery[] = array(
				'key'		 => '_price',
				'compare'	 => '>=',
				'value'		 => $min_price,
				'type'		 => 'NUMERIC'
			);
		}
		$max_price = get_product_filter_value( 'max-price' );
		if ( !empty( $max_price ) ) {
			$metaquery[] = array(
				'key'		 => '_price',
				'compare'	 => '<=',
				'value'		 => $max_price,
				'type'		 => 'NUMERIC'
			);
		}
		$shortcode_query[ 'meta_query' ] = $metaquery;
	}
	return $shortcode_query;
}

/**
 * Returns category product count with product in child categories
 *
 * @param type $cat_id
 * @return type
 */
function total_product_category_count( $cat_id ) {
	$q = new WP_Query( array(
		'nopaging'	 => true,
		'tax_query'	 => array(
			array(
				'taxonomy'			 => 'al_product-cat',
				'terms'				 => $cat_id,
				'include_children'	 => true,
			),
		),
		'fields'	 => 'ids',
	) );
	return $q->post_count;
}

add_filter( 'product_search_button_text', 'modify_search_widget_filter' );

/**
 * Deletes search button text in filter bar
 *
 * @param string $text
 * @return string
 */
function modify_search_widget_filter( $text ) {
	if ( is_filter_bar() ) {
		$text = '';
	}
	return $text;
}
