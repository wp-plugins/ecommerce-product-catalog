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
global $post; 
$default_archive_names = default_archive_names();
$archive_names = get_option( 'archive_names', $default_archive_names);

if (is_tax()) { $the_tax = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); 
$page_title = $archive_names['all_prefix'] .' '.$the_tax->name; }
else if (is_search()) {
$page_title = __('Search Results for:','al-ecommerce-product-catalog').' '.$_GET['s'];
}
else {$page_title = $archive_names['all_products']; }
echo product_breadcrumbs(); ?>
				

			
<article id="product_listing" <?php post_class('al_product'); ?>>
<header <?php post_class('entry-header'); ?>>
	<?php if (! is_tax() && ! is_search()) { content_product_adder_archive_before_title(); }
		else {
		echo '<h1 class="entry-title">'.$page_title.'</h1>';
		}	?>
</header> 
	<div class="entry-content">
		<?php $before_archive = content_product_adder_archive_before();
		if (! is_tax() && !is_search()) {			
			if ( $before_archive != '<div class="entry-summary"></div>') {
				echo $before_archive; } 
			} 
		if (is_tax()) {
			echo '<div class="entry-content">'.term_description().'</div>';
			$term = get_queried_object()->term_id; 
			$taxonomy_name = 'al_product-cat'; 
			$product_subcategories = wp_list_categories('show_option_none=No_cat&echo=0&title_li=&taxonomy='.$taxonomy_name.'&child_of='.$term); 
			if (!strpos($product_subcategories,'No_cat') ){ ?>
				<div class="product-subcategories">
					<?php  echo $product_subcategories; ?> 
				</div>
			<?php } 
		} 
		$archive_template = get_option( 'archive_template', DEFAULT_ARCHIVE_TEMPLATE);
		if ($archive_template == 'default') {
			while ( have_posts() ) : the_post(); 
				default_archive_theme($post);
			endwhile; }
		else if ($archive_template == 'list') {
			while ( have_posts() ) : the_post(); 
				list_archive_theme($post);
			endwhile; }
		else {
			while ( have_posts() ) : the_post(); 
				echo get_grid_archive_theme($post);
			endwhile; 
		}
		?><span class="clear"></span>
	</div>
	
</article>
	<?php product_archive_pagination(); ?>