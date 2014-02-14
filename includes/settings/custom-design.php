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

// add_action('settings-menu','design_menu');

function design_settings() {
 	register_setting('product_design', 'archive_theme');
}
add_action('product-settings-list','design_settings');

function custom_design_content() { ?>
<div class="design-product-settings">
		<form method="post" action="options.php">
		<?php settings_fields('product_design'); $archive_template = get_option( 'archive_template', 'default'); ?>

		<div class="settings-submenu">
			<h3>
				<a id="archive-design" class="element current" href="./edit.php?post_type=al_product&page=product-settings.php&tab=design-settings&submenu=archive-design"><?php _e('Product Listing', 'al-ecommerce-product-catalog'); ?></a>
			</h3>
		</div>
		<div class="setting-content submenu">
		<h2><?php _e('Design Settings', 'al-ecommerce-product-catalog'); ?></h2>
		<h3><?php _e('Product Listing', 'al-ecommerce-product-catalog'); ?></h3>
			<table class="design-table">
			<thead></thead><tbody>
			<tr id="default-theme">
			<td><input type="radio" name="archive_template" value="default"<?php checked( 'default' == $archive_template ); ?>><?php _e('Modern Grid', 'al-ecommerce-product-catalog'); ?></td>
			<td class="theme-example"><?php example_default_archive_theme(); ?></td>
			</tr>
			<tr id="list-theme">
			<td><input type="radio" name="archive_template" value="list"<?php checked( 'list' == $archive_template ); ?>><?php _e('Classic List', 'al-ecommerce-product-catalog'); ?></td>
			<td class="theme-example"><?php example_list_archive_theme(); ?></td>
			</tr>
			<tr id="grid-theme">
			<td><input type="radio" name="archive_template" value="grid"<?php checked( 'grid' == $archive_template ); ?>><?php _e('Classic Grid', 'al-ecommerce-product-catalog'); ?></td>
			<td class="theme-example"><?php example_grid_archive_theme(); ?></td>
			</tr>
			</tbody>
			</table>
		</div>
		</form>
		</div> 
<?php }