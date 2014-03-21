<?php
/**
 * Manages catalog default theme
 *
 * Here default theme is defined and managed.
 *
 * @version		1.1.4
 * @package		ecommerce-product-catalog/templates/themes
 * @author 		Norbert Dreszer
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

 function example_default_archive_theme() { 
 $default_modern_grid_settings = array (
	'attributes' => 1,
	);
$modern_grid_settings = get_option( 'modern_grid_settings', $default_modern_grid_settings); 
$modern_grid_settings['attributes'] = isset($modern_grid_settings['attributes']) ? $modern_grid_settings['attributes'] : '' ?>
 <div id="content">
 <a href="#default-theme"><div class="al_archive" style="background-image:url('<?php echo AL_PLUGIN_BASE_PATH .'templates/themes/img/example-product.jpg'; ?>'); background-position:center; ">
				<div class="product-name">White Lamp</div>
				<?php if ($modern_grid_settings['attributes'] == 1) {?>
				<div class="product-attributes">
				<table class="attributes-table">
				<tbody><tr><td>Height</td><td>20 </td></tr><tr><td>Color</td><td>White </td></tr>		
				</tbody></table>
				</div> <?php } ?>
				<div class="product-price">10 USD</div>
				</div></a> 
</div>
<?php }

function default_archive_theme($post) { 
$default_modern_grid_settings = array (
	'attributes' => 1,
	);
$modern_grid_settings = get_option( 'modern_grid_settings', $default_modern_grid_settings); 
$modern_grid_settings['attributes'] = isset($modern_grid_settings['attributes']) ? $modern_grid_settings['attributes'] : '';
$price_value = get_post_meta($post->ID, "_price", true); ?>
			<a href="<?php the_permalink(); ?>"><div class="al_archive modern-grid-element" style='background-image:url(" <?php 
			if (wp_get_attachment_url( get_post_thumbnail_id($post->ID) )) {
				$url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); 
			} 
			else {
				$url = default_product_thumbnail_url(); 
			}
			echo $url; ?>");'>
		
			<div class="product-name <?php design_schemes('box'); ?>"><?php the_title(); ?></div>
			<?php $attributes_number = get_option('product_attributes_number', DEF_ATTRIBUTES_OPTIONS_NUMBER);
			$at_val = '';
			$any_attribute_value = '';
			for ($i = 1; $i <= $attributes_number; $i++) {
				$at_val = get_post_meta($post->ID, "_attribute".$i, true);
				if (! empty($at_val)) {
					$any_attribute_value = $at_val.$i; }
			}
			if ($attributes_number > 0 AND ! empty($any_attribute_value) AND $modern_grid_settings['attributes'] == 1) { ?>
				<div class="product-attributes">
					<table class="attributes-table">
					<?php for ($i = 1; $i <= $attributes_number; $i++) { 
						$attribute_value = get_post_meta($post->ID, "_attribute".$i, true);
						if (! empty($attribute_value)) {
							echo '<tr><td>'. get_post_meta($post->ID, "_attribute-label".$i, true) . '</td><td>' . get_post_meta($post->ID, "_attribute".$i, true). ' '. get_post_meta($post->ID, "_attribute-unit".$i, true) .'</td></tr>'; } } ?>
					</table>
				</div> 
			<?php } 
			do_action('archive_price', $price_value); ?>
			
			</div></a>		
<?php } 