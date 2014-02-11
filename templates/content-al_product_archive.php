<?php
/**
 * The template for displaying products archive content.
 *
 * 
 *
 * @version		1.1.3
 * @package		ecommerce-product-catalog/templates
 * @author 		Norbert Dreszer
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 global $post; ?>
<? if (is_tax()) { $the_tax = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); $page_title = __( 'All', 'al-ecommerce-product-catalog' ) .' '.$the_tax->name; }
else {$page_title = __( 'All Products', 'al-ecommerce-product-catalog' ); } ?>
				<header class="entry-header">
				<?php 
				if (! is_tax()) {
				content_product_adder_archive_before(); } ?>
				<h2 class="archive-title"><?php
					
						echo $page_title;
					
				?></h2>
				
				<?php if (is_tax()) {
				echo '<div class="entry-content">'.term_description().'</div>';
				$term = get_queried_object()->term_id; 
				$taxonomy_name = 'al_product-cat'; 
				$product_subcategories = wp_list_categories('show_option_none=No_cat&echo=0&title_li=&taxonomy='.$taxonomy_name.'&child_of='.$term); 
				if (!strpos($product_subcategories,'No_cat') ){ ?>
				<div class="product-subcategories"><?php 
				
				 echo $product_subcategories;
				?> 
				</div>
				
				<?php } }
				if ( is_post_type_archive() ) {
				$page_id = 51;
				$page = get_post($page_id);
				$content = apply_filters ("the_content", $page->post_content);
				echo "<p>$content</p>"; } ?>
				</header> 
			
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>><div class="entry-content">
			
			<?php while ( have_posts() ) : the_post(); ?>
				
				<a href="<?php the_permalink(); ?>"><div class="al_archive" style='background-image:url(" <?php 
				if (wp_get_attachment_url( get_post_thumbnail_id($post->ID) )) {
				$url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); } 
				else {
				$url = default_product_thumbnail_url();
				}
				echo $url; ?>"); background-position:center; '>
		
		<div class="product-name"><?php the_title(); ?></div>
		<?php
		$attributes_number = get_option('product_attributes_number', DEF_ATTRIBUTES_OPTIONS_NUMBER);
		$at_val = '';
		$any_attribute_value = '';
		for ($i = 1; $i <= $attributes_number; $i++) {
		$at_val = get_post_meta($post->ID, "_attribute".$i, true);
		if (! empty($at_val)) {
		$any_attribute_value = $at_val.$i; }
		}
		if ($attributes_number > 0 AND ! empty($any_attribute_value)) { ?>
		<div class="product-attributes">
		<table class="attributes-table">
		<?php 
		
		for ($i = 1; $i <= $attributes_number; $i++) { 
		$attribute_value = get_post_meta($post->ID, "_attribute".$i, true);
		if (! empty($attribute_value)) {
		echo '<tr><td>'. get_post_meta($post->ID, "_attribute-label".$i, true) . '</td><td>' . get_post_meta($post->ID, "_attribute".$i, true). ' '. get_post_meta($post->ID, "_attribute-unit".$i, true) .'</td></tr>'; } } ?>
		
		</table>
		</div> <?php } 
		$price_value = get_post_meta($post->ID, "_price", true);
		if (!empty($price_value)) {
		?>
		<div class="product-price"><?php echo get_post_meta($post->ID, "_price", true); ?> <?php echo get_option('product_currency',DEF_CURRENCY); ?></div>
		<?php } ?>
		</div></a>		

			<?php endwhile; ?></div></article>
	
			 <?php echo paginate_links( $args ); ?>
	