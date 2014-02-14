<?php
/**
 * Manages attributes settings
 *
 * Here attributes settings are defined and managed.
 *
 * @version		1.1.4
 * @package		ecommerce-product-catalog/functions
 * @author 		Norbert Dreszer
 */
function attributes_menu() { ?>
 <a id="attributes-settings" class="element"  href="./edit.php?post_type=al_product&page=product-settings.php&tab=attributes-settings&submenu=attributes"><?php _e('Product attributes', 'al-ecommerce-product-catalog'); ?></a>
<?php }

// add_action('general_submenu','attributes_menu'); // UNCOMMENT TO INSERT IN FIRST TAB and change url above
add_action('settings-menu','attributes_menu');

function attributes_settings() {
 	register_setting('product_attributes', 'product_attributes_number');
	register_setting('product_attributes', 'al_display_attributes');
	register_setting('product_attributes', 'product_attribute');
	register_setting('product_attributes', 'product_attribute_label');
	register_setting('product_attributes', 'product_attribute_unit');
}
add_action('product-settings-list','attributes_settings');

function attributes_settings_content() { 
$submenu = $_GET['submenu'];
if ($submenu == 'attributes') { ?>
<script>
jQuery('.settings-submenu a').removeClass('current');
jQuery('.settings-submenu a#attributes-settings').addClass('current');
</script>
<div class="attributes-product-settings setting-content submenu">
	<h2><?php _e('Attributes Settings', 'al-ecommerce-product-catalog'); ?></h2>
		<form method="post" action="options.php">
		<?php settings_fields('product_attributes'); ?>
		<h3><?php _e('Product attributes options', 'al-ecommerce-product-catalog'); ?></h3>
		<table>
			<tr>
				<td colspan="2"><?php _e('Number of product attributes', 'al-ecommerce-product-catalog'); ?> <input size="30" type="number" step="1" min="0" name="product_attributes_number" id="admin-number-field" value="<?php echo get_option('product_attributes_number', DEF_ATTRIBUTES_OPTIONS_NUMBER); ?>" /><input type="submit" class="button" value="<?php _e('Update', 'al-ecommerce-product-catalog'); ?>" /></td>
				
				</tr>
		</table>
		
		<?php $attributes_count = get_option('product_attributes_number', DEF_ATTRIBUTES_OPTIONS_NUMBER);
	if ($attributes_count > 0) { ?>
		<div class="al-box info"><p><?php _e("If you fill out the fields below, system will automatically pre-fill the fields on product pages so you doesn't have to fill them every time you add product.</p><p>When every product in your catalogue is different you can leave all or a part of these field empty.", 'al-ecommerce-product-catalog'); ?></p><p><?php _e('You can change these default values on every product page.', 'al-ecommerce-product-catalog'); ?></p></div>
		<table  class="wp-list-table widefat product-settings-table dragable">
		<thead><tr><th class="title"></th><th class="title"><b><?php _e('Attribute default name', 'al-ecommerce-product-catalog'); ?></b></th><th></th><th class="title"><b><?php _e('Attribute default value', 'al-ecommerce-product-catalog'); ?></b></th><th class="title"><b><?php _e('Attribute default unit', 'al-ecommerce-product-catalog'); ?></b></th></tr></thead><tbody>
	<?php for ($i = 1; $i <= get_option('product_attributes_number', '3'); $i++) {
	// Get the attributes data if its already been entered
	$attribute = get_option('product_attribute');
	$attribute_label = get_option('product_attribute_label');
	$attribute_unit = get_option('product_attribute_unit');
	// Echo out the field
	echo '<tr><td class="lp-column lp'.$i.'">'. $i .'.</td><td class="product-attribute-label-column"><input class="product-attribute-label" type="text" name="product_attribute_label['.$i.']" value="' . $attribute_label[$i] . '" /></td><td class="lp-column">:</td><td><input id="admin-number-field" class="product-attribute" type="number" min="0" name="product_attribute['.$i.']" value="' . $attribute[$i] . '" /></td><td><input id="admin-number-field" class="product-attribute-unit" type="text" name="product_attribute_unit['.$i.']" value="' . $attribute_unit[$i] . '" /></td></tr>'; } ?>
	
	</tbody></table>
	<?php do_action('product-attributes'); ?>
		<p class="submit">
                <input type="submit" class="button-primary" value="<?php _e('Save changes', 'al-ecommerce-product-catalog'); ?>" />
            </p>
	
	<?php } else { ?>
	<table>
	<tr><td colspan="2">	
	<div class="al-box warning"><?php _e('Attributes disabled. To enable set minimum 1 attribute.', 'al-ecommerce-product-catalog'); ?></div>
	</td></tr>
	</table>
	<?php } ?>
			
		
		</form>
		</div> 
<?php } }

add_action('general_settings', 'attributes_settings_content');
