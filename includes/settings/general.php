<?php
/**
 * Manages general settings
 *
 * Here general settings are defined and managed.
 *
 * @version		1.1.4
 * @package		ecommerce-product-catalog/functions
 * @author 		Norbert Dreszer
 */
function general_menu() { ?>
	<a id="general-settings" href="./edit.php?post_type=al_product&page=product-settings.php&tab=product-settings"><?php _e('Product settings', 'al-ecommerce-product-catalog'); ?></a>
<?php }

add_action('settings-menu','general_menu');
 
function general_settings() {
	register_setting('product_settings', 'default_product_thumbnail');
	register_setting('product_settings', 'product_listing_url');
	register_setting('product_settings', 'product_currency');
	register_setting('product_settings', 'product_archive');
	register_setting('product_settings', 'enable_product_listing');
}
add_action('product-settings-list','general_settings');

function general_settings_content() { ?>
	<script>
	jQuery('.settings-submenu a').removeClass('current');
	jQuery('.settings-submenu a#general-settings').addClass('current');
	</script>
	<?php $submenu = $_GET['submenu'];?>
	<div class="overall-product-settings" style="clear:both;">
		<div class="settings-submenu">
			<h3>
				<a id="general-settings" class="element current" href="./edit.php?post_type=al_product&page=product-settings.php&tab=product-settings&submenu=general-settings"><?php _e('General Settings', 'al-ecommerce-product-catalog'); ?></a>
				<?php do_action('general_submenu'); ?>
			</h3>
		</div>
		
	<?php if ($submenu == 'general-settings' OR $submenu == '') { ?>
		<div class="setting-content submenu">
		<h2><?php _e('General Settings', 'al-ecommerce-product-catalog'); ?></h2>
			<form method="post" action="options.php">
				<?php settings_fields('product_settings'); 
				$product_currency = get_option('product_currency', DEF_CURRENCY);
				$enable_product_listing = get_option('enable_product_listing', 1);
				$product_listing_url = get_option('product_listing_url', __('products', 'al-ecommerce-product-catalog'));
				$product_archive_created = get_option('product_archive_page_id','0');
				$product_archive = get_option('product_archive', $product_archive_created);
				$page_get = get_page_by_path( $product_listing_url );
				if ($product_archive != '') {
					$new_product_listing_url = get_page_uri( $product_archive ); 
					if ($new_product_listing_url != '') {
						update_option( 'product_listing_url', $new_product_listing_url ); }
					else { update_option( 'product_listing_url', __('products', 'al-ecommerce-product-catalog') ); }
				}
				else if (!empty($page_get->ID)) {
					update_option( 'product_archive', $page_get->ID );
					$product_archive = get_option('product_archive');
				} ?>
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
						<td>
							<?php _e('Enable Product Listing Page', 'al-ecommerce-product-catalog'); ?>: 
						</td>
						<td>
							<input type="checkbox" name="enable_product_listing" value="1"<?php checked( 1 == $enable_product_listing ); ?> />
						</td>
					</tr>
					<tr>
						<td>
							<?php $args = array(
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
							$pages = get_pages($args);  ?>
							<?php _e('Choose Product Listing Page', 'al-ecommerce-product-catalog'); ?>: </td><td>
							<select id="product_archive" name="product_archive">
								<option value="noid"><?php _e( 'Default', 'al-ecommerce-product-catalog' ); ?></option>
								<?php foreach ($pages as $page) {?>
									<option name="product_archive[<?php echo $page->ID; ?>]" value="<?php echo $page->ID; ?>"<?php selected( $page->ID == $product_archive); ?>><?php echo $page->post_title; ?></option>
								<?php }  ?>
							</select>
						</td>
					</tr>
					<tr>
						<td><?php _e('Product listing URL', 'al-ecommerce-product-catalog'); ?>:</td>
						<td><a target="_blank" class="archive-url" href="<?php echo product_listing_url() ?>"><?php echo product_listing_url(); ?></a></td>
					</tr>
				</table>
				<h3><?php _e('Payment and currency', 'al-ecommerce-product-catalog'); ?></h3>
				<?php _e('Your currency', 'al-ecommerce-product-catalog'); ?> 
				<select id="product_currency" name="product_currency"> 
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
		</div> 
	<?php } 
	do_action('general_settings'); ?>
	</div>

<?php }