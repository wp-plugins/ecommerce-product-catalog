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

require_once('product-categories.php');
// require_once('product-types.php');

add_action( 'init', 'create_product' );
function create_product() {
global $wp_version;
if ( $wp_version < 3.8 ) {
	$reg_settings = array(
			'labels' => array(
				'name' => __('Products', 'al-ecommerce-product-catalog'),
				'singular_name' => __('Product', 'al-ecommerce-product-catalog'),
				'add_new'            => __( 'Add New Product','al-ecommerce-product-catalog'),
				'add_new_item'       => __( 'Add New Product','al-ecommerce-product-catalog'),
				'edit_item'          => __( 'Edit Product','al-ecommerce-product-catalog'),
				'new_item'           => __( 'Add New Product','al-ecommerce-product-catalog'),
				'view_item'          => __( 'View Product','al-ecommerce-product-catalog'),
				'search_items'       => __( 'Search Products','al-ecommerce-product-catalog'),
				'not_found'          => __( 'No Products found','al-ecommerce-product-catalog'),
				'not_found_in_trash' => __( 'No Products found in trash','al-ecommerce-product-catalog')
			),
		'public' => true,
		'has_archive' => true,
		'rewrite' => array('slug' => get_option('product_listing_url', __('products', 'al-ecommerce-product-catalog'))),
		'supports' => array( 'title', 'thumbnail'),
		'extras' => array('enter_title_here'=>__('Enter product name here', 'al-ecommerce-product-catalog')),
		'register_meta_box_cb' => 'add_product_metaboxes',
		'taxonomies' => array('al_product_cat'),
		'menu_icon' => plugins_url() . '/ecommerce-product-catalog/img/product.png',
		'capability_type' => 'product',
		'capabilities' => array(
				'publish_posts' => 'publish_products',
				'edit_posts' => 'edit_products',
				'edit_others_posts' => 'edit_others_products',
				'edit_published_posts' => 'edit_published_products',
				'edit_private_posts' => 'edit_private_products',
				'delete_posts' => 'delete_products',
				'delete_others_posts' => 'delete_others_products',
				'delete_private_posts' => 'delete_private_products',
				'delete_published_posts' => 'delete_published_products',
				'read_private_posts' => 'read_private_products',
				'edit_post' => 'edit_product',
				'delete_post' => 'delete_product',
				'read_post' => 'read_product',
			),
		); }
	else {
	$reg_settings = array(
			'labels' => array(
				'name' => __('Products', 'al-ecommerce-product-catalog'),
				'singular_name' => __('Product', 'al-ecommerce-product-catalog'),
				'add_new'            => __( 'Add New Product','al-ecommerce-product-catalog'),
				'add_new_item'       => __( 'Add New Product','al-ecommerce-product-catalog'),
				'edit_item'          => __( 'Edit Product','al-ecommerce-product-catalog'),
				'new_item'           => __( 'Add New Product','al-ecommerce-product-catalog'),
				'view_item'          => __( 'View Product','al-ecommerce-product-catalog'),
				'search_items'       => __( 'Search Products','al-ecommerce-product-catalog'),
				'not_found'          => __( 'No Products found','al-ecommerce-product-catalog'),
				'not_found_in_trash' => __( 'No Products found in trash','al-ecommerce-product-catalog')
			),
		'public' => true,
		'has_archive' => true,
		'rewrite' => array('slug' => get_option('product_listing_url', __('products', 'al-ecommerce-product-catalog'))),
		'supports' => array( 'title', 'thumbnail'),
		'extras' => array('enter_title_here'=>__('Enter product name here', 'al-ecommerce-product-catalog')),
		'register_meta_box_cb' => 'add_product_metaboxes',
		'taxonomies' => array('al_product_cat'),
		'capability_type' => 'product',
		'capabilities' => array(
				'publish_posts' => 'publish_products',
				'edit_posts' => 'edit_products',
				'edit_others_posts' => 'edit_others_products',
				'edit_published_posts' => 'edit_published_products',
				'edit_private_posts' => 'edit_private_products',
				'delete_posts' => 'delete_products',
				'delete_others_posts' => 'delete_others_products',
				'delete_private_posts' => 'delete_private_products',
				'delete_published_posts' => 'delete_published_products',
				'read_private_posts' => 'read_private_products',
				'edit_post' => 'edit_product',
				'delete_post' => 'delete_product',
				'read_post' => 'read_product',
			),
		);
	}

	register_post_type( 'al_product', $reg_settings);
	flush_rewrite_rules();
}



add_action('admin_head', 'product_icons');
function product_icons() {
        global $post_type;
    ?>
    <style>
    <?php if (isset($_GET['post_type']) == 'al_product') : ?>
    #icon-edit { background:transparent url('<?php echo plugins_url() . '/ecommerce-product-catalog/img/product-32.png';?>') no-repeat; }     
    <?php endif; ?>
        </style>
        <?php
}

// Add the Events Meta Boxes
function add_product_metaboxes() {

	add_meta_box('al_product_short_desc', __('Product short description', 'al-ecommerce-product-catalog'), 'al_product_short_desc', 'al_product', 'normal', 'default');
	add_meta_box('al_product_desc', __('Product description', 'al-ecommerce-product-catalog'), 'al_product_desc', 'al_product', 'normal', 'default');
	add_meta_box('al_product_price', __('Product Price', 'al-ecommerce-product-catalog'), 'al_product_price', 'al_product', 'side', 'default');
	if (get_option('product_shipping_options_number',DEF_SHIPPING_OPTIONS_NUMBER) > 0) {
	add_meta_box('al_product_shipping', __('Product Shipping', 'al-ecommerce-product-catalog'), 'al_product_shipping', 'al_product', 'side', 'default'); }
	if (get_option('product_attributes_number',DEF_ATTRIBUTES_OPTIONS_NUMBER) > 0) {
	add_meta_box('al_product_attributes', __('Product attributes', 'al-ecommerce-product-catalog'), 'al_product_attributes', 'al_product', 'side', 'default'); }
	do_action('add_product_metaboxes');
}

// The Product Price Metabox
function al_product_price() {
	global $post;
	// Noncename needed to verify where the data originated
	echo '<input type="hidden" name="pricemeta_noncename" id="pricemeta_noncename" value="' .
	wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
	// Get the price data if its already been entered
	$price = get_post_meta($post->ID, '_price', true);
	$currency = get_option('product_currency', DEF_CURRENCY);
	// Echo out the field
	echo '<table><tr><td class="price-column"><input type="number" min="0" name="_price" value="' . $price  . '" class="widefat" /></td><td>'. $currency .'</td></tr></table>';
}

// The Product Shipping Metabox
function al_product_shipping() {
	global $post;
	// Noncename needed to verify where the data originated
	echo '<input type="hidden" name="shippingmeta_noncename" id="shippingmeta_noncename" value="' .
	wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
	$currency = get_option('product_currency', DEF_CURRENCY);
	echo '<table>';
	for ($i = 1; $i <= get_option('product_shipping_options_number', DEF_SHIPPING_OPTIONS_NUMBER); $i++) {
	// Get the shipping data if its already been entered
	$shipping_option = get_option('product_shipping_cost');
	$shipping_label_option = get_option('product_shipping_label');
	$shipping_option_field = get_post_meta($post->ID, '_shipping'.$i, true);
	$shipping_label_field = get_post_meta($post->ID, '_shipping-label'.$i, true);
	if (! empty($shipping_option_field)) {
	$shipping = $shipping_option_field; }
	else { $shipping = $shipping_option[$i]; }
	if (! empty($shipping_label_field)) {
	$shipping_label = $shipping_label_field; }
	else { $shipping_label = $shipping_label_option[$i]; }
	// Echo out the fields
	echo '<tr><td class="shipping-label-column"><input class="shipping-label" type="text" name="_shipping-label'.$i.'" value="' . $shipping_label  . '" /></td><td><input class="shipping-value" type="number" min="0" name="_shipping'.$i.'" value="' . $shipping  . '" />'. $currency .'</td></tr>'; }
	echo '</table>';
}

// The Product attributes Metabox
function al_product_attributes() {
	global $post;
	// Noncename needed to verify where the data originated
	echo '<input type="hidden" name="attributesmeta_noncename" id="attributesmeta_noncename" value="' .
	wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
	echo '<table>';
	echo '<div class="al-box info">'. __('Only attributes with values set will be shown on product page.', 'al-ecommerce-product-catalog') .'</div>';
	for ($i = 1; $i <= get_option('product_attributes_number', DEF_ATTRIBUTES_OPTIONS_NUMBER); $i++) {
	// Get the attributes data if its already been entered
	$attributes_option = get_option('product_attribute');
	$attributes_label_option = get_option('product_attribute_label');
	$attributes_unit_option = get_option('product_attribute_unit');
	$attributes_option_field = get_post_meta($post->ID, '_attribute'.$i, true);
	$attributes_label_option_field = get_post_meta($post->ID, '_attribute-label'.$i, true);
	$attributes_unit_option_field = get_post_meta($post->ID, '_attribute-unit'.$i, true);
	if (! empty($attributes_option_field)) {
	$attributes = $attributes_option_field; }
	else { $attributes = $attributes_option[$i]; }
	if (! empty($attributes_label_option_field)) {
	$attributes_label = $attributes_label_option_field; }
	else { $attributes_label = $attributes_label_option[$i]; }
	if (! empty($attributes_unit_option_field)) {
	$attributes_unit = $attributes_unit_option_field; }
	else { $attributes_unit = $attributes_unit_option[$i]; }
	// Echo out the field
	echo '<tr><td class="attributes-label-column"><input class="attribute-label" type="text" name="_attribute-label'.$i.'" value="' . $attributes_label  . '" /></td><td> : <input class="attribute-value" type="text" name="_attribute'.$i.'" value="' . $attributes  . '" /></td><td><input class="attribute-unit" type="text" name="_attribute-unit'.$i.'" value="' . $attributes_unit  . '" /></td></tr>'; }
	echo '</table>';
}

// The Product Short Description Metabox
function al_product_short_desc() {
	global $post;
	// Noncename needed to verify where the data originated
	echo '<input type="hidden" name="shortdescmeta_noncename" id="shortdescmeta_noncename" value="' .
	wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
	// Get short description data if its already been entered
	$shortdesc = get_post_meta($post->ID, '_shortdesc', true);
	// Echo out the field
	// echo '<textarea name="_shortdesc" value="' . $shortdesc  . '" class="widefat" ></textarea>';
	$short_desc_settings = array('media_buttons' => false, 'textarea_rows' => 5, 'teeny' => true);
	wp_editor($shortdesc,'_shortdesc', $short_desc_settings);
}
function al_product_desc() {
	global $post;
	echo '<input type="hidden" name="descmeta_noncename" id="descmeta_noncename" value="' .
	wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
	$desc = get_post_meta($post->ID, '_desc', true);
	$desc_settings = array('textarea_rows' => 30);
	wp_editor($desc,'_desc', $desc_settings);
}

// Save the Metabox Data
function wpt_save_products_meta($post_id, $post) {
	// verify this came from the our screen and with proper authorization,
	// because save_post can be triggered at other times
	if ( !wp_verify_nonce( $_POST['pricemeta_noncename'], plugin_basename(__FILE__) )) {
	return $post->ID;
	}
	// Is the user allowed to edit the post or page?
	if ( !current_user_can( 'edit_post', $post->ID ))
		return $post->ID;
	// OK, we're authenticated: we need to find and save the data
	// We'll put it into an array to make it easier to loop though.
	$product_meta['_price'] = $_POST['_price'];
	$product_meta['_shortdesc'] = $_POST['_shortdesc'];
	$product_meta['_desc'] = $_POST['_desc'];
	for ($i = 1; $i <= get_option('product_shipping_options_number',DEF_SHIPPING_OPTIONS_NUMBER); $i++) {
	$product_meta['_shipping'.$i] = $_POST['_shipping'.$i];
	$product_meta['_shipping-label'.$i] = $_POST['_shipping-label'.$i];	}
	for ($i = 1; $i <= get_option('product_attributes_number',DEF_ATTRIBUTES_OPTIONS_NUMBER); $i++) {
	$product_meta['_attribute'.$i] = $_POST['_attribute'.$i];
	$product_meta['_attribute-label'.$i] = $_POST['_attribute-label'.$i];
	$product_meta['_attribute-unit'.$i] = $_POST['_attribute-unit'.$i];}
	// Add values of $events_meta as custom fields
	foreach ($product_meta as $key => $value) { // Cycle through the $events_meta array!
		if(! $post->post_type == 'al_product' ) return; // Don't store custom data twice
		$value = implode(',', (array)$value); // If $value is an array, make it a CSV (unlikely)
		if(get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value
			update_post_meta($post->ID, $key, $value);
			
		} // else if ($value == 0) {update_post_meta($post->ID, $key, '0'); }
		else { // If the custom field doesn't have a value
			add_post_meta($post->ID, $key, $value);
		}
		// if(!$value) delete_post_meta($post->ID, $key); // Delete if blank
	}
}


add_action('save_post', 'wpt_save_products_meta', 1, 2); // save the custom fields

add_action('do_meta_boxes', 'change_image_box');
function change_image_box()
{
    remove_meta_box( 'postimagediv', 'al_product', 'side' );
    add_meta_box('postimagediv', __('Product Image','al-ecommerce-product-catalog'), 'post_thumbnail_meta_box', 'al_product', 'side', 'high');
}	

add_action('admin_head-post-new.php',change_thumbnail_html);
add_action('admin_head-post.php',change_thumbnail_html);
function change_thumbnail_html( $content ) {
    if ('al_product' == $GLOBALS['post_type'])
      add_filter('admin_post_thumbnail_html',do_thumb);
	  add_filter('admin_post_thumbnail_html',do_thumb_1);
}
function do_thumb($content){
	 return str_replace(__('Set featured image'), __('Set product image', 'al-ecommerce-product-catalog'),$content);
}

function do_thumb_1($content){
	 return str_replace(__('Remove featured image'), __('Remove product image', 'al-ecommerce-product-catalog'),$content);
}



?>