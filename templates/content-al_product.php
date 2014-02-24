<?php
/**
 * The template for displaying products content.
 *
 * 
 *
 * @version		1.1.2
 * @package		ecommerce-product-catalog/templates
 * @author 		Norbert Dreszer
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $post; 
$default_single_names = default_single_names();
$single_names = get_option( 'single_names', $default_single_names);
$product_currency = get_option('product_currency',DEF_CURRENCY);
$enable_catalog_lightbox = get_option('catalog_lightbox', 1);
if ($enable_catalog_lightbox == 1) { ?>
<script>
jQuery(document).ready(function(){
				jQuery(".a-product-image").colorbox({transition: 'elastic', initialWidth: 200});
});
</script>
<?php } ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title product-name"><?php the_title(); ?></h1>
	</header>
	<div class="entry-content product-entry">
		<div class="entry-thumbnail product-image">
			<?php if (has_post_thumbnail()) { 
				if ($enable_catalog_lightbox == 1) {
					$img_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large'); ?>
					<a class="a-product-image" href="<?php echo $img_url[0];?>"><?php the_post_thumbnail('medium');?></a> <?php } 
				else {
				the_post_thumbnail('medium'); }
			} 
			else { echo default_product_thumbnail();}?>
		</div>
		<div class="product-details">
			<?php do_action('product_details', $post, $single_names, $product_currency); ?>
		</div>
		<div class="entry-meta">
			<?php edit_post_link( __( 'Edit Product', 'al-ecommerce-product-catalog' ), '<span class="edit-link">', '</span>' ); ?>
		</div>
		<?php do_action("after_product_details", $post, $single_names); ?>
		<div class="after-product-description">
			<?php  do_action('single_product_end', $post, $single_names); ?>
		</div>
	
		<?php $enable_product_listing = get_option('enable_product_listing', 1);
		if ($enable_product_listing == 1) { ?>
			<a href="<?php echo product_listing_url(); ?>"><?php echo $single_names['return_to_archive']; ?></a>
		<?php } ?>
	</div>
</article>