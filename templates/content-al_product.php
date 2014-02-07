<?php
/**
 * The template for displaying products content.
 *
 * 
 *
 * @version		1.0.0
 * @package		ecommerce-product-catalog/templates
 * @author 		Norbert Dreszer
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 global $post; ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
		<h1 class="entry-title product-name"><?php the_title(); ?></h1>
		</header>
		<div class="entry-content product-entry">
		<div class="entry-thumbnail product-image">
			<?php if (has_post_thumbnail()) {the_post_thumbnail('medium');} else { echo default_product_thumbnail();}?>
		</div>
		<div class="product-details">
		<table>
		<?php $price_value = get_post_meta($post->ID, "_price", true);
		if (!empty($price_value)) { ?>
			<tr><td><?php _e( 'Product Price','al-ecommerce-product-catalog') ?>:</td><td class="price-value"><?php echo get_post_meta($post->ID, "_price", true); ?> <?php echo get_option('product_currency',DEF_CURRENCY); ?></td>
			</tr>
			<?php }
			$shipping_options = get_option('product_shipping_options_number',DEF_SHIPPING_OPTIONS_NUMBER);
			$sh_val = '';
		$any_shipping_value = '';
		for ($i = 1; $i <= $shipping_options; $i++) {
		$sh_val = get_post_meta($post->ID, "_shipping".$i, true);
		if (! empty($sh_val)) {
		$any_shipping_value = $sh_val; }
		}
			if ($shipping_options > 0 AND ! empty($any_shipping_value)) { ?>
			<tr>
			<td>
			<?php _e( 'Product Shipping','al-ecommerce-product-catalog') ?>:</td><td><ul><?php for ($i = 1; $i <= $shipping_options; $i++) { 
			$shipping_value = get_post_meta($post->ID, "_shipping".$i, true);
			if (! empty($shipping_value)) {echo '<li>'. get_post_meta($post->ID, "_shipping-label".$i, true) . ' : ' . $shipping_value . ' ' . get_option('product_currency',DEF_CURRENCY) . '</li>'; } }?></td>
			</tr> <?php } ?>
			
			</table>
					<div class="shortdesc">
		<?php $shortdesc = get_post_meta($post->ID, "_shortdesc", true);
		echo $shortdesc; ?>
		</div>
		</div>
		<div class="after-product-shipping"><?php do_action('after-product-shipping'); ?></div>
		<div class="entry-meta">
			<?php edit_post_link( __( 'Edit Product', 'al-ecommerce-product-catalog' ), '<span class="edit-link">', '</span>' ); ?>
		</div><!-- .entry-meta -->
		
		<?php $attributes_number = get_option('product_attributes_number', DEF_ATTRIBUTES_OPTIONS_NUMBER);
		$at_val = '';
		$any_attribute_value = '';
		for ($i = 1; $i <= $attributes_number; $i++) {
		$at_val = get_post_meta($post->ID, "_attribute".$i, true);
		if (! empty($at_val)) {
		$any_attribute_value = $at_val; }
		}
		if ($attributes_number > 0 AND ! empty($any_attribute_value)) { ?>
		<div class="product-features">
		<h3><?php _e( 'Product Features', 'al-ecommerce-product-catalog' ); ?></h3>
		<table class="features-table">
		<?php 
		
		for ($i = 1; $i <= $attributes_number; $i++) { 
		$attribute_value = get_post_meta($post->ID, "_attribute".$i, true);
		if (! empty($attribute_value)) {
		echo '<tr><td>'. get_post_meta($post->ID, "_attribute-label".$i, true) . '</td><td>' . get_post_meta($post->ID, "_attribute".$i, true). ' '. get_post_meta($post->ID, "_attribute-unit".$i, true) .'</td></tr>'; } } ?>
		
		</table>
		
		</div> <?php } 
		$product_description = get_post_meta($post->ID, "_desc", true);
		if (! empty($product_description)) { ?>
		<div class="product-description">
		<?php echo apply_filters( 'the_content',$product_description);  ?></div>
		<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Products:', 'al-ecommerce-product-catalog' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); } ?>
	
	<div class="after-product-description">
	<div class="product-subcategories"><table><tr><td><?php _e( 'See also different', 'al-ecommerce-product-catalog' );?>:</td><td><?php 
				// $term = get_queried_object()->term_id; 
				$taxonomy_name = 'al_product-cat'; 
				$terms = wp_get_post_terms($post->ID, $taxonomy_name, array("fields" => "ids"));
				$term = $terms[0];
				wp_list_categories('title_li=&taxonomy='.$taxonomy_name.'&child_of='.$term); ?> 
				</td></tr></table></div>
	<a href="<?php product_listing_url(); ?>"><<	 <?php _e( 'return to products', 'al-ecommerce-product-catalog' ); ?></a>
	<?php  do_action('after-product-description'); ?></div>
	
	 
	</div></article><!-- .entry-content -->