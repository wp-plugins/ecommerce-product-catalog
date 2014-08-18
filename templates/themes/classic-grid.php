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
<div class="archive-listing classic-grid example">
		<a href="#grid-theme">
		<div style="background-image:url('<?php echo AL_PLUGIN_BASE_PATH .'templates/themes/img/example-product.jpg'; ?>');" class="classic-grid-element"></div>
		<div class="product-name">White Lamp</div>
		<div class="product-price">10 USD</div>
		</a>
</div>
<?php }

function grid_archive_theme($post) { ?>
<div class="archive-listing classic-grid">
		<a href="<?php the_permalink(); ?>">
		<div style="background-image:url('<?php 
			if (wp_get_attachment_url( get_post_thumbnail_id($post->ID) )) {
				$url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); 
			} 
			else {
				$url = default_product_thumbnail_url(); 
			}
			echo $url; ?>');" class="classic-grid-element"></div>
		<div class="product-name"><?php the_title(); ?></div>
		<?php do_action('archive_price', $post);  ?>
		</a>
</div>
<?php }

function get_grid_archive_theme($post) {
$archive_template = get_option( 'archive_template', 'default');
$archive_template = !empty($archive_template) ? $archive_template : 'default';
if ($archive_template == 'grid') {
if (wp_get_attachment_url( get_post_thumbnail_id($post->ID) )) {
	$url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); 
} 
else {
	$url = default_product_thumbnail_url(); 
}
$archive_price = apply_filters('archive_price_filter', '', $post);
$default_classic_grid_settings = array (
	'entries' => 3,
	);
$classic_grid_settings = get_option( 'classic_grid_settings', $default_classic_grid_settings);
$row_class = 'full';
if ($classic_grid_settings['entries'] != '') {
global $row;
if ($row > $classic_grid_settings['entries'] || !isset($row)) {$row = 1; }
$count = $row - $classic_grid_settings['entries'];
if ($row == 1) {
$row_class = 'first';
}
else if ($count == 0) {
$row_class = 'last';
}
else {
$row_class = 'middle';
}
if (more_products()) {
$row++; }
else {
$row = 1;
}
}
$return = '<div class="archive-listing classic-grid '.$row_class.'">';
$return .= '<a href="'.get_permalink().'">';
$return .= '<div style="background-image:url(\''.$url.'\');" class="classic-grid-element"></div>';
$return .= '<div class="product-name">'.get_the_title().'</div>'.$archive_price.'</a></div>';
return $return;
}
}

