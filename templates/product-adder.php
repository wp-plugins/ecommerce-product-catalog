<?php
/** 
* Template Name:  Product Template
*
 * @version		1.0.0
 * @package		ecommerce-product-catalog/templates
 * @author 		Norbert Dreszer
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header(); ?>

<div id="container" class="content-area">
		<div id="content" class="site-content" role="main">
			 
			<?php content_product_adder(); ?>
				

		</div><!-- #content -->
</div>
 
<?php get_sidebar(); ?>

<?php get_footer(); ?>
