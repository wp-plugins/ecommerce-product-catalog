<?php
/**
 * Manages custom design settings
 *
 * Here custom design settings are defined and managed.
 *
 * @version		1.1.4
 * @package		ecommerce-product-catalog/functions
 * @author 		Norbert Dreszer
 */
function design_menu() { ?>
	<a id="design-settings" href="./edit.php?post_type=al_product&page=product-settings.php&tab=design-settings&submenu=archive-design"><?php _e('Catalog Design', 'al-ecommerce-product-catalog'); ?></a>
<?php }

add_action('settings-menu','design_menu');

function design_settings() {
 	register_setting('product_design', 'archive_template');
	register_setting('product_design', 'modern_grid_settings');
	register_setting('single_design', 'catalog_lightbox');
}
add_action('product-settings-list','design_settings');

function custom_design_content() { ?>
<div class="design-product-settings">
		

		<div class="settings-submenu">
			<h3>
				<a id="archive-design" class="element current" href="./edit.php?post_type=al_product&page=product-settings.php&tab=design-settings&submenu=archive-design"><?php _e('Product Listing', 'al-ecommerce-product-catalog'); ?></a>
				<a id="single-design" class="element" href="./edit.php?post_type=al_product&page=product-settings.php&tab=design-settings&submenu=single-design"><?php _e('Single Product', 'al-ecommerce-product-catalog'); ?></a>
				<?php do_action('custom-design-submenu'); ?>
			</h3>
		</div>
		<div class="setting-content submenu">
		<?php do_action('custom-design-settings');?>
		
		</div> </div>
<?php }

function archive_custom_design() { 
$tab = $_GET['tab'];
$submenu = $_GET['submenu']; 
if ($submenu == 'archive-design') { ?>
<script>
	jQuery('.settings-submenu a').removeClass('current');
	jQuery('.settings-submenu a#archive-design').addClass('current');
</script>
<form method="post" action="options.php">
	<?php settings_fields('product_design'); 
	$archive_template = get_option( 'archive_template', 'default');
	$default_modern_grid_settings = array (
	'attributes' => 1,
	);
	$modern_grid_settings = get_option( 'modern_grid_settings', $default_modern_grid_settings);?>
	<h2><?php _e('Design Settings', 'al-ecommerce-product-catalog'); ?></h2>
	<h3><?php _e('Product Listing', 'al-ecommerce-product-catalog'); ?></h3>
		<table class="design-table">
			<thead></thead>
			<tbody>
				<tr id="default-theme">
					<td class="with-additional-styling"><input type="radio" name="archive_template" value="default"<?php checked( 'default' == $archive_template ); ?>><?php _e('Modern Grid', 'al-ecommerce-product-catalog'); ?></td>
					<td rowspan="2" class="theme-example"><?php example_default_archive_theme(); ?></td>
				</tr>
				<tr><td class="additional-styling"><strong><?php _e('Additional Settings', 'al-ecommerce-product-catalog'); ?></strong><br><input type="checkbox" name="modern_grid_settings[attributes]" value="1"<?php checked( 1 == $modern_grid_settings['attributes'] ); ?>><?php _e('Show Attributes', 'al-ecommerce-product-catalog'); ?></td></tr>
				<tr id="list-theme">
					<td class="with-additional-styling"><input type="radio" name="archive_template" value="list"<?php checked( 'list' == $archive_template ); ?>><?php _e('Classic List', 'al-ecommerce-product-catalog'); ?></td>
					<td class="theme-example"><?php example_list_archive_theme(); ?></td>
				</tr>
				<tr id="grid-theme">
					<td class="with-additional-styling"><input type="radio" name="archive_template" value="grid"<?php checked( 'grid' == $archive_template ); ?>><?php _e('Classic Grid', 'al-ecommerce-product-catalog'); ?></td>
					<td class="theme-example"><?php example_grid_archive_theme(); ?></td>
				</tr>
			</tbody>
		</table>
	<p class="submit">
		<input type="submit" class="button-primary" value="<?php _e('Save changes', 'al-ecommerce-product-catalog'); ?>" />
	</p>	
</form>
<?php } }

add_action('custom-design-settings','archive_custom_design');

function single_custom_design() { 
$tab = $_GET['tab'];
$submenu = $_GET['submenu']; 
if ($submenu == 'single-design') { ?>
<script>
	jQuery('.settings-submenu a').removeClass('current');
	jQuery('.settings-submenu a#single-design').addClass('current');
</script>
<form method="post" action="options.php">
	<?php settings_fields('single_design'); $enable_catalog_lightbox = get_option('catalog_lightbox', 1); ?>
	<h2><?php _e('Design Settings', 'al-ecommerce-product-catalog'); ?></h2>
	<h3><?php _e('Single Product', 'al-ecommerce-product-catalog'); ?></h3>
		<input type="checkbox" name="catalog_lightbox" value="1"<?php checked( 1, $enable_catalog_lightbox ); ?> /><?php _e('Enable lightbox on product image', 'al-ecommerce-product-catalog'); ?>
	<p class="submit">
		<input type="submit" class="button-primary" value="<?php _e('Save changes', 'al-ecommerce-product-catalog'); ?>" />
	</p>
</form>
<?php } }

add_action('custom-design-settings','single_custom_design');