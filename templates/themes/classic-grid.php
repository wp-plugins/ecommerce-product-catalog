<?php
/**
 * Manages catalog classic grid theme
 *
 * Here classic grid theme is defined and managed.
 *
 * @version		1.2.0
 * @package		ecommerce-product-catalog/templates/themes
 * @author 		Norbert Dreszer
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function example_grid_archive_theme() { ?>
<div class="archive-listing grid example">
		<a href="#grid-theme">
		<div style="background-image:url('<?php echo AL_PLUGIN_BASE_PATH .'templates/themes/img/example-product.jpg'; ?>'); background-size: 200px; background-position: center; width:200px; height:200px;"></div>
		<div class="product-name">White Lamp</div>
		<div class="product-price">10 USD</div>
		</a>
</div>
<?php }

function grid_archive_theme($post) { ?>
<div class="archive-listing grid">
		<a href="<?php the_permalink(); ?>">
		<div style="background-image:url('<?php 
			if (wp_get_attachment_url( get_post_thumbnail_id($post->ID) )) {
				$url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); 
			} 
			else {
				$url = default_product_thumbnail_url(); 
			}
			echo $url; ?>'); background-size: 200px; background-position: center; width:200px; height:200px;"></div>
		<div class="product-name"><?php the_title(); ?></div>
		<?php $price_value = get_post_meta($post->ID, "_price", true);
		if (!empty($price_value)) { ?>
		<div class="product-price"><?php echo get_post_meta($post->ID, "_price", true); ?> <?php echo get_option('product_currency',DEF_CURRENCY); ?></div> <?php } ?>
		</a>
</div>
<?php }