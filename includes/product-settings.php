<?php
/**
 * Manages product settings
 *
 * Here product settings are defined and managed.
 *
 * @version		1.0.0
 * @package		ecommerce-product-catalog/functions
 * @author 		Norbert Dreszer
 */
 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
add_action('admin_menu' , 'register_product_settings'); 
function register_product_settings() {
    add_submenu_page('edit.php?post_type=al_product', __('Product Settings', 'al-ecommerce-product-catalog'), __('Product Settings', 'al-ecommerce-product-catalog'), 'read_private_products', basename(__FILE__), 'product_settings');
    add_action('admin_init', 'product_settings_list');
}

 function product_settings_list() {
		register_setting('product_settings', 'default_product_thumbnail');
		register_setting('product_settings', 'product_listing_url');
		register_setting('product_shipping', 'product_shipping_options_number');
		register_setting('product_settings', 'product_currency');
		register_setting('product_attributes', 'product_attributes_number');
		register_setting('product_attributes', 'al_display_attributes');
		register_setting('product_attributes', 'product_attribute');
		register_setting('product_attributes', 'product_attribute_label');
		register_setting('product_attributes', 'product_attribute_unit');
		register_setting('product_shipping', 'display_shipping');
		register_setting('product_shipping', 'product_shipping_cost');
		register_setting('product_shipping', 'product_shipping_label');
		do_action('product-settings-list');
 } 

require_once(  AL_BASE_PATH . '/config/currencies.php' );

function product_settings() { ?>

    <div class="wrap">
        <h2><?php _e('Product Settings', 'al-ecommerce-product-catalog'); ?></h2>
		<h2 class="tab-menu">
		<a id="general-settings" href="/wp-admin/edit.php?post_type=al_product&page=product-settings.php&tab=general-settings"><?php _e('General settings', 'al-ecommerce-product-catalog'); ?></a>
		<a id="attributes-settings" href="/wp-admin/edit.php?post_type=al_product&page=product-settings.php&tab=attributes-settings"><?php _e('Product attributes', 'al-ecommerce-product-catalog'); ?></a>
		<a id="shipping-settings" href="/wp-admin/edit.php?post_type=al_product&page=product-settings.php&tab=shipping-settings"><?php _e('Product shipping', 'al-ecommerce-product-catalog'); ?></a>
		</h2>
		<?php $tab = $_GET['tab'];
		if ($tab == 'general-settings' OR $tab == '') { ?>
		<script>
		jQuery('.tab-menu a#attributes-settings').removeClass('current');
		jQuery('.tab-menu a#shipping-settings').removeClass('current');
		jQuery('.tab-menu a#general-settings').addClass('current');
		</script>
		<div class="overall-product-settings" style="clear:both;">
        <form method="post" action="options.php">

            <?php settings_fields('product_settings'); $product_currency = get_option('product_currency', DEF_CURRENCY); ?>
			<h3><?php _e('Product default image', 'al-ecommerce-product-catalog'); ?></h3>
				             
				<?php global $name, $button_value, $option_name; 
				$name = 'default_product_thumbnail'; 
				$button_value = __('Change default thumbnail', 'al-ecommerce-product-catalog'); 
				$option_name = 'default_product_thumbnail';
				upload_product_image($name, $button_value, $option_name); ?>
			<div style="clear:both"></div>
			<h3><?php _e('Product listing page', 'al-ecommerce-product-catalog'); ?></h3>	
			<table>
			<tr>
			<td><?php _e('Product listing URL', 'al-ecommerce-product-catalog'); ?>:</td>
			<td><?php echo site_url(); ?>/<input size="30" type="text" id="product_listing_url" name="product_listing_url" value="<?php echo get_option('product_listing_url', __('products', 'al-ecommerce-product-catalog')); ?>" />
			<a class="button" href="<?php echo site_url(); ?>/<?php echo get_option('product_listing_url', __('products', 'al-ecommerce-product-catalog')); ?>/"><?php _e('View Listing URL', 'al-ecommerce-product-catalog'); ?></a>
			</td>
			</tr>
			</table>
           
			<h3><?php _e('Payment and currency', 'al-ecommerce-product-catalog'); ?></h3>
				<?php _e('Your currency', 'al-ecommerce-product-catalog'); ?> <select id="product_currency" name="product_currency"> 
				<?php $currencies = available_currencies(); 
				foreach($currencies as $currency) : ?>
				<option name="product_currency[<?php echo $currency; ?>]" value="<?php echo $currency; ?>"<?php selected( $currency == $product_currency); ?>><?php echo $currency; ?></option>
				<?php endforeach; ?>
				</select>
			
<?php do_action('product-settings'); ?>
            <p class="submit">
                <input type="submit" class="button-primary" value="<?php _e('Save changes', 'al-ecommerce-product-catalog'); ?>" />
            </p>	
        </form>
		</div> <?php } else if ($tab == 'attributes-settings') {?>
		<script>
		jQuery('.tab-menu a#shipping-settings').removeClass('current');
		jQuery('.tab-menu a#general-settings').removeClass('current');
		jQuery('.tab-menu a#attributes-settings').addClass('current');
		</script>
		<div class="attributes-product-settings">
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
		<table  class="wp-list-table widefat product-settings-table">
		<tr><thead><th id="title"></th><th id="title"><b><?php _e('Attribute default name', 'al-ecommerce-product-catalog'); ?></b></th><th></th><th id="title"><b><?php _e('Attribute default value', 'al-ecommerce-product-catalog'); ?></b></th><th><b><?php _e('Attribute default unit', 'al-ecommerce-product-catalog'); ?></b></th></thead></tr>
	<?php for ($i = 1; $i <= get_option('product_attributes_number', '3'); $i++) {
	// Get the attributes data if its already been entered
	$attribute = get_option('product_attribute');
	$attribute_label = get_option('product_attribute_label');
	$attribute_unit = get_option('product_attribute_unit');
	// Echo out the field
	echo '<tr><td class="lp-column">'. $i .'.</td><td class="product-attribute-label-column"><input class="product-attribute-label" type="text" name="product_attribute_label['.$i.']" value="' . $attribute_label[$i] . '" /></td><td class="lp-column">:</td><td><input id="admin-number-field" class="product-attribute" type="number" min="0" name="product_attribute['.$i.']" value="' . $attribute[$i] . '" /></td><td><input id="admin-number-field" class="product-attribute-unit" type="text" name="product_attribute_unit['.$i.']" value="' . $attribute_unit[$i] . '" /></td></tr>'; } ?>
	<tfoot><th id="title"></th><th id="title">&nbsp;</th><th id="title">&nbsp;</th></tfoot>
	</table>
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
		</div> <?php } else if ($tab == 'shipping-settings') { ?>
		<script>
		jQuery('.tab-menu a#attributes-settings').removeClass('current');
		jQuery('.tab-menu a#general-settings').removeClass('current');
		jQuery('.tab-menu a#shipping-settings').addClass('current');
		</script>
		<div class="shipping-product-settings">
		<form method="post" action="options.php">
		<?php settings_fields('product_shipping'); ?>
		<h3><?php _e('Product shipping options', 'al-ecommerce-product-catalog'); ?></h3>
		 <table>
			<tr>
				<td colspan="2"><?php _e('Number of shipping options', 'al-ecommerce-product-catalog'); ?> <input size="30" type="number" step="1" min="0" name="product_shipping_options_number" id="admin-number-field" value="<?php echo get_option('product_shipping_options_number', DEF_SHIPPING_OPTIONS_NUMBER); ?>" /><input type="submit" class="button" value="<?php _e('Update', 'al-ecommerce-product-catalog'); ?>" /></td>
				</tr>
		</table>		
		<?php $shipping_count = get_option('product_shipping_options_number', DEF_SHIPPING_OPTIONS_NUMBER);
	if ($shipping_count > 0) { ?>
		<div class="al-box info"><p><?php _e("If you fill out the fields below, system will automatically pre-fill the fields on product pages so you doesn't have to fill them every time you add product.</p><p>When every product in your catalogue has different shipping options you can leave all or just a part of these fields empty.", 'al-ecommerce-product-catalog'); ?></p><p><?php _e('You can change these default values on every product page.', 'al-ecommerce-product-catalog'); ?></p></div>
		
		<table class="wp-list-table widefat product-settings-table">
		<tr><tr><thead><th id="title"></th><th id="title"><b><?php _e('Shipping default name', 'al-ecommerce-product-catalog'); ?></b></th><th></th><th id="title"><b><?php _e('Shipping default cost', 'al-ecommerce-product-catalog'); ?></b></th></thead></tr>
	<?php  for ($i = 1; $i <= $shipping_count; $i++) {
	// Get the attributes data if its already been entered
	$shipping_cost = get_option('product_shipping_cost', DEF_VALUE);
	$shipping_label = get_option('product_shipping_label');
	// Echo out the field
	echo '<tr><tr><td class="lp-column">'. $i .'.</td><td class="product-shipping-label-column"><input class="product-shipping-label" type="text" name="product_shipping_label['.$i.']" value="' . $shipping_label[$i] . '" /></td><td class="lp-column">:</td><td><input id="admin-number-field" class="product-shipping-cost" type="number" min="0" name="product_shipping_cost['.$i.']" value="' . $shipping_cost[$i] . '" /></td></tr>'; } ?>
	</table>		
		<?php do_action('product-attributes'); ?>
		<p class="submit">
                <input type="submit" class="button-primary" value="<?php _e('Save changes', 'al-ecommerce-product-catalog'); ?>" />
            </p>
	<?php } else { ?>
	<tr><td colspan="2">	
	<div class="al-box warning"><?php _e('Shipping disabled. To enable set minimum 1 shipping option.', 'al-ecommerce-product-catalog'); ?></div>
	</td></tr>
	</table>
	<?php } ?>
	
		</form>
		</div> <?php } ?>
    </div>

<?php }
