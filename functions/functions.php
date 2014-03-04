<?php 
/**
 * Manages product functions
 *
 * Here all plugin functions are defined and managed.
 *
 * @version		1.0.0
 * @package		wp-messages-adder/includes
 * @author 		Norbert Dreszer
 */
 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
function default_product_thumbnail() {
 if (get_option('default_product_thumbnail')) {
 $url = get_option('default_product_thumbnail');
 }
 else {$url = AL_PLUGIN_BASE_PATH .'img/no-default-thumbnail.png';}

return '<img width="150px" src="'.$url.'"  />';
 }

function default_product_thumbnail_url() {
 if (get_option('default_product_thumbnail')) {
 $url = get_option('default_product_thumbnail');
 }
 else {$url = AL_PLUGIN_BASE_PATH .'img/no-default-thumbnail.png';}

return $url;
 }
 
function product_listing_url() {
	if ( get_option('permalink_structure') ) { 
			$listing_url = site_url(). '/' .get_option('product_listing_url', __('products', 'al-ecommerce-product-catalog')). '/'; }
	else {
			$listing_url = get_post_type_archive_link( 'al_product' ); }
	return $listing_url;
}
function upload_product_image($name, $button_value, $option_name) { 
global $name, $button_value, $option_name;
wp_enqueue_media(); 
if (get_option($option_name)) {
$src = get_option($option_name);}
else {$src = AL_PLUGIN_BASE_PATH .'img/no-default-thumbnail.png'; } ?>
 <div class="custom-uploader">
 <input hidden="hidden" type="text" id="default" value="<?php echo AL_PLUGIN_BASE_PATH .'img/no-default-thumbnail.png'; ?>" />
  <input hidden="hidden" type="text" name="<?php echo $name; ?>" id="<?php echo $name; ?>" value="<?php echo get_option($option_name); ?>" />
  <div class="admin-media-image"><img class="media-image" src="<?php echo $src; ?>" width="100%" height="100%" /></div>
  <a href="#" class="button insert-media add_media" name="<?php echo $name; ?>_button" id="button_<?php echo $name; ?>"><span class="wp-media-buttons-icon"></span> <?php echo $button_value; ?></a>
  <a class="button" id="reset-image-button" href="#"><?php _e('Reset image', 'al-ecommerce-product-catalog'); ?></a>
</div>
<script>
jQuery(document).ready(function()
{
jQuery('#button_<?php echo $name; ?>').click(function()
{
wp.media.editor.send.attachment = function(props, attachment)
{
jQuery('#<?php echo $name; ?>').val(attachment.url);
jQuery('.media-image').attr("src", attachment.url);
}

wp.media.editor.open(this);

return false;
});
});

jQuery('#reset-image-button').click(function() {
jQuery('#<?php echo $name; ?>').val('');
src = jQuery('#default').val();
jQuery('.media-image').attr("src", src);
});
</script>
<?php

}

function select_page($option_name,$first_option,$selected_value) {
$args = array(
		'sort_order' => 'ASC',
		'sort_column' => 'post_title',
		'hierarchical' => 1,
		'exclude' => '',
		'include' => '',
		'meta_key' => '',
		'meta_value' => '',
		'authors' => '',
		'child_of' => 0,
		'parent' => -1,
		'exclude_tree' => '',
		'number' => '',
		'offset' => 0,
		'post_type' => 'page',
		'post_status' => 'publish'
		); 
$pages = get_pages($args); 
$select_box = '<select id="'.$option_name.'" name="'.$option_name.'"><option value="noid">'.$first_option.'</option>';
foreach ($pages as $page) { 
	$select_box .= '<option name="' .$option_name. '[' .$page->ID. ']" value="' .$page->ID. '" ' .selected($page->ID, $selected_value, 0). '>' .$page->post_title. '</option>';
	}  
$select_box .= '</select>';

echo $select_box;
}

function show_page_link($page_id) {
$page_url = post_permalink( $page_id );
$page_link = '<a target="_blank" href='.$page_url.'>'.$page_url.'</a>';
echo $page_link;
}

function verify_page_status($page_id) {
$page_status = get_post_status( $page_id );
if ($page_status != 'publish' AND $page_status != '') {
echo '<div class="al-box warning">This page has wrong status: '.$page_status.'.<br>Don\'t forget to publish it before going live!</div>';
}
}

function design_schemes($which = null, $echo = 1) {
$custom_design_schemes = unserialize (DEFAULT_DESIGN_SCHEMES);
$design_schemes = get_option('design_schemes', $custom_design_schemes);
if ($which == 'color') {
$output = $design_schemes['price-color'];
}
else if ($which == 'size') {
$output = $design_schemes['price-size'];
}
else if ($which == 'box') {
$output = $design_schemes['box-color'];
}
else {
$output = $design_schemes['price-color'].' '.$design_schemes['price-size'];
}
if ($echo == 1) {
echo $output; }
else if ($echo == 0) {
return $output; }
}

/* Single Product Functions */

function example_price() {
echo '2500.00 EUR';
}
add_action('example_price','example_price');

function show_price($post, $single_names, $product_currency) {
$price_value = get_post_meta($post->ID, "_price", true);
if (!empty($price_value)) { ?>
	<table class="price-table">
		<tr>
			<td><?php echo $single_names['product_price'] ?></td>
			<td class="price-value <?php design_schemes(); ?>"><?php echo $price_value; ?> <?php echo $product_currency; ?></td>
		</tr>
	</table>
<?php }
}
add_action('product_details','show_price', 7, 3);

function show_shipping_options($post, $single_names, $product_currency) {
$shipping_options = get_option('product_shipping_options_number',DEF_SHIPPING_OPTIONS_NUMBER);
$sh_val = '';
$any_shipping_value = '';
for ($i = 1; $i <= $shipping_options; $i++) {
	$sh_val = get_post_meta($post->ID, "_shipping".$i, true);
	if (! empty($sh_val)) {
		$any_shipping_value = $sh_val; }
}
if ($shipping_options > 0 AND ! empty($any_shipping_value)) { ?>
	<table>
		<tr>
			<td>
				<?php echo $single_names['product_shipping'] ?>
			</td>
			<td>
				<ul>
					<?php for ($i = 1; $i <= $shipping_options; $i++) { 
						$shipping_value = get_post_meta($post->ID, "_shipping".$i, true);
						if (! empty($shipping_value)) {
							echo '<li>'. get_post_meta($post->ID, "_shipping-label".$i, true) . ' : ' . $shipping_value . ' ' . $product_currency . '</li>'; 
						}
					}?>
				</ul>
			</td>
		</tr> 
	</table>
<?php }
}

add_action('product_details','show_shipping_options', 9, 3);

function show_short_desc($post, $single_names, $product_currency) { 
$shortdesc = get_post_meta($post->ID, "_shortdesc", true); ?>
<div class="shortdesc">
	<?php echo $shortdesc; ?>
</div>
<?php }
add_action('product_details','show_short_desc', 5, 3);

function show_product_attributes($post, $single_names) {
$attributes_number = get_option('product_attributes_number', DEF_ATTRIBUTES_OPTIONS_NUMBER);
$at_val = '';
$any_attribute_value = '';
for ($i = 1; $i <= $attributes_number; $i++) {
	$at_val = get_post_meta($post->ID, "_attribute".$i, true);
	if (! empty($at_val)) {
		$any_attribute_value = $at_val; 
	}
}
if ($attributes_number > 0 AND ! empty($any_attribute_value)) { ?>
	<div class="product-features">
		<h3><?php echo $single_names['product_features']; ?></h3>
		<table class="features-table">
			<?php for ($i = 1; $i <= $attributes_number; $i++) { 
				$attribute_value = get_post_meta($post->ID, "_attribute".$i, true);
				if (! empty($attribute_value)) {
					echo '<tr><td class="attribute-label-single">'. get_post_meta($post->ID, "_attribute-label".$i, true) . '</td><td>' . get_post_meta($post->ID, "_attribute".$i, true). ' '. get_post_meta($post->ID, "_attribute-unit".$i, true) .'</td></tr>'; 
				} 
			} ?>
		</table>
	</div>
<?php }
}

add_action('after_product_details','show_product_attributes', 10, 2);

function show_product_description($post, $single_names) {
$product_description = get_post_meta($post->ID, "_desc", true);
if (! empty($product_description)) { ?>
	<div class="product-description">
		<?php echo apply_filters( 'the_content',$product_description);  ?>
	</div>
<?php }
}

add_action('after_product_details','show_product_description', 10, 2);

function show_related_categories($post, $single_names, $taxonomy_name) { 
$terms = wp_get_post_terms($post->ID, $taxonomy_name, array("fields" => "ids"));
$term = $terms[0];				
$categories = wp_list_categories('title_li=&taxonomy='.$taxonomy_name.'&include='.$term.'&echo=0&hierarchical=0'); 
if ($categories != '<li class="cat-item-none">No categories</li>') { ?>
	<div class="product-subcategories">
		<table>
			<tr>
				<td>
					<?php echo $single_names['other_categories']; ?>
				</td>
				<td>
					<?php echo $categories; ?>
				</td>
			</tr>
		</table>
	</div> 
<?php }
}
add_action('single_product_end','show_related_categories', 10, 3);

/* Archive Functions */
function show_archive_price($price_value,$product_currency) {
if (!empty($price_value)) { ?>
	<div class="product-price <?php design_schemes('color'); ?>">
		<?php echo $price_value.' '.$product_currency; ?>
	</div>
<?php }
}

add_action('archive_price', 'show_archive_price',10,2);

function get_quasi_post_type() {
$post_type = get_post_type();
$quasi_post_type = substr($post_type,0,10);
return $quasi_post_type;
}

function current_currency($catalog_id = null) {
$currency = get_option('product_currency', DEF_CURRENCY);
return $currency;
}

function product_breadcrumbs() {
global $post;
$post_type = get_post_type();
$home_page = get_home_url();
if (function_exists('additional_product_listing_url') AND $post_type != 'al_product') {
$catalog_id = catalog_id($post_type);
$product_archives = additional_product_listing_url();
$product_archive = $product_archives[$catalog_id];
$archives_ids = get_option('additional_product_archive_id');
$breadcrumbs_options = get_option('product_breadcrumbs', unserialize (DEFAULT_PRODUCT_BREADCRUMBS));
if ($breadcrumbs_options['enable_product_breadcrumbs'][$catalog_id] != 1) {
return;
}
$product_archive_title_options = $breadcrumbs_options['breadcrumbs_title'][$catalog_id];
if ($product_archive_title_options != '') {
$product_archive_title = $product_archive_title_options;
}
else {
$product_archive_title = get_the_title($archives_ids[$catalog_id]);
}}
else {
$archive_multiple_settings = get_option('archive_multiple_settings', unserialize (DEFAULT_ARCHIVE_MULTIPLE_SETTINGS));
if ($archive_multiple_settings['enable_product_breadcrumbs'] != 1) {
return;
}

$product_archive = product_listing_url(); 
if ($archive_multiple_settings['breadcrumbs_title'] != '') {
$product_archive_title = $archive_multiple_settings['breadcrumbs_title'];
}
else {
$product_archive_title = get_the_title(get_option('product_archive', get_option('product_archive_page_id','0'))); } }
$current_product = get_the_title($post->ID);
if (is_single()) {
return '<p id="breadcrumbs">
<span xmlns:v="http://rdf.data-vocabulary.org/#">
	<span typeof="v:Breadcrumb">
		<a href="'.$home_page.'" rel="v:url" property="v:title">Home</a>
	</span> » 
	<span typeof="v:Breadcrumb">
		<a href="'.$product_archive.'" rel="v:url" property="v:title">'.$product_archive_title.'</a>
	</span> » 
	<span typeof="v:Breadcrumb">
		<span class="breadcrumb_last" property="v:title">'.$current_product.'</span>
	</span>
</span>
</p>'; }
else {
return '<p id="breadcrumbs">
<span xmlns:v="http://rdf.data-vocabulary.org/#">
	<span typeof="v:Breadcrumb">
		<a href="'.$home_page.'" rel="v:url" property="v:title">Home</a>
	</span> » 
	<span typeof="v:Breadcrumb">
		<span class="breadcrumb_last" property="v:title">'.$product_archive_title.'</span>
	</span>
</span>
</p>';
}
}

function al_product_register_widgets() {
	register_widget( 'product_cat_widget' );
	register_widget( 'product_widget_search' );
}

add_action( 'widgets_init', 'al_product_register_widgets' );

function permalink_options_update() {
update_option('al_permalink_options_update', 1);
}

function check_permalink_options_update() {
$options_update = get_option('al_permalink_options_update', 0);
if ($options_update == 1) {
flush_rewrite_rules(false);
update_option('al_permalink_options_update', 0);
}
}