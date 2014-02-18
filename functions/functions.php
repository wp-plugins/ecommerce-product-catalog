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

return '<img src="'.$url.'"  />';
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
$select_box	= '<select id="'.$option_name.'" name="'.$option_name.'"><option value="noid">'.$first_option.'</option>';
foreach ($pages as $page) { 
	$select_box .= '<option name="' .$option_name. '[' .$page->ID. ']" value="' .$page->ID. '" ' .selected($page->ID, $selected_value, 0). '>' .$page->post_title. '</option>';
	}  
$select_box .= '</s1elect>';

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