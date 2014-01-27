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
echo '../';
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