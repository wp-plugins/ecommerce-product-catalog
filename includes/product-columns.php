<?php 
/**
 * Manages licenses columns
 *
 * Here all license columns defined and managed.
 *
 * @version		1.0.0
 * @package		digital-products-licenses/includes
 * @author 		Norbert Dreszer
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_filter('manage_edit-al_product_columns', 'add_product_columns');

function add_product_columns($product_columns) { 
	$product_currency = get_currency_settings();
    $new_columns['cb'] = $product_columns['cb'];
	$new_columns['id'] = __('ID', 'al-ecommerce-product-catalog');
	$new_columns['image'] = __('Image', 'al-ecommerce-product-catalog');
	$new_columns['title'] = __('Product Name', 'al-ecommerce-product-catalog');
	if ($product_currency['price_enable'] == 'on') {
	$new_columns['price'] = __('Price', 'al-ecommerce-product-catalog');
	}
	$new_columns['shortcode'] = __('Shortcode', 'al-ecommerce-product-catalog');
	//unset($new_columns['taxonomy-al_product-cat']);
	$new_columns['taxonomy-al_product-cat'] = __('Product Categories', 'al-ecommerce-product-catalog');
	$new_columns['date'] = __('Date', 'al-ecommerce-product-catalog');
    return $new_columns;
}

add_action('manage_al_product_posts_custom_column', 'manage_product_columns', 10, 2);
 
function manage_product_columns($column_name, $product_id) {
$price_value = product_price($product_id);
switch ($column_name) {
	case 'id':
		echo $product_id;
	break;
	case 'shortcode':
		echo '[show_products product="'.$product_id.'"]';
	break;
	case 'price':
		if ($price_value != '') {
		echo price_format($price_value); }
	break;
	case 'image':
		echo the_post_thumbnail(array(40,40));
	break;
	case 'product_cat':
        echo get_the_term_list($product_id, 'al_product-cat', '', ', ', '');
    break;
	
	default:
	break;
}
}

add_filter( 'manage_edit-al_product_sortable_columns', 'product_sortable_columns' );
function product_sortable_columns( $columns ) {
    $columns['price'] = 'price';
	$columns['id'] = 'id';
	$columns['taxonomy-al_product-cat'] = 'taxonomy-al_product-cat';
 
    //To make a column 'un-sortable' remove it from the array
    //unset($columns['date']);
 
    return $columns;
}

function product_cat_sort_column($clauses, $wp_query){
global $wpdb;
    if(isset($wp_query->query['orderby']) && $wp_query->query['orderby'] == 'taxonomy-al_product-cat'){
        $clauses['join'] .= <<<SQL
LEFT OUTER JOIN {$wpdb->term_relationships} ON {$wpdb->posts}.ID={$wpdb->term_relationships}.object_id
LEFT OUTER JOIN {$wpdb->term_taxonomy} USING (term_taxonomy_id)
LEFT OUTER JOIN {$wpdb->terms} USING (term_id)
SQL;
        $clauses['where'] .= "AND (taxonomy = 'al_product-cat' OR taxonomy IS NULL)";
        $clauses['groupby'] = "object_id";
        $clauses['orderby'] = "GROUP_CONCAT({$wpdb->terms}.name ORDER BY name ASC)";
        if(strtoupper($wp_query->get('order')) == 'ASC'){
            $clauses['orderby'] .= 'ASC';
        } else{
            $clauses['orderby'] .= 'DESC';
        }
    }
    return $clauses;
}
//add_filter('posts_clauses', 'product_cat_sort_column', 10, 2);

function color_orderby( $orderby, $wp_query ) {
	global $wpdb;

	if ( isset( $wp_query->query['orderby'] ) && 'taxonomy-al_product-cat' == $wp_query->query['orderby'] ) {
		$orderby = "(
			SELECT GROUP_CONCAT(name ORDER BY name ASC)
			FROM $wpdb->term_relationships
			INNER JOIN $wpdb->term_taxonomy USING (term_taxonomy_id)
			INNER JOIN $wpdb->terms USING (term_id)
			WHERE $wpdb->posts.ID = object_id
			AND taxonomy = 'al_product-cat'
			GROUP BY object_id
		) ";
		$orderby .= ( 'ASC' == strtoupper( $wp_query->get('order') ) ) ? 'ASC' : 'DESC';
	}

	return $orderby;
}
add_filter( 'posts_orderby', 'color_orderby', 10, 2 );

add_action( 'pre_get_posts', 'column_orderby_price' );  
function column_orderby_price( $query ) {  
    if( ! is_admin() )  
        return;  

    $orderby = $query->get( 'orderby');  

    if( 'price' == $orderby ) {  
        $query->set('meta_key','_price');  
        $query->set('orderby','meta_value_num');  
    }  
}

function restrict_listings_by_product_cat() {
    global $typenow;
    global $wp_query;
    if ($typenow == 'al_product' ) {
        $taxonomy = 'al_product-cat';
        $current_taxonomy = get_taxonomy($taxonomy);
        $selected = isset($wp_query->query['al_product-cat']) ? $wp_query->query['al_product-cat'] : '';
        wp_dropdown_categories(
            array(
                'walker'=> new ic_walker_tax_slug_dropdown(),
                'value'=>'slug',
                'show_option_all' =>  __("All", "al-ecommerce-product-catalog").' '.$current_taxonomy->label,
                'taxonomy'        =>  $taxonomy,
                'name'            =>  'al_product-cat',
                'orderby'         =>  'name',
                'selected'        =>  $selected,
                'hierarchical'    =>  true,
                'depth'           =>  3,
                'show_count'      =>  true,
                'hide_empty'      =>  true,
            )
        );
    }
}
add_action('restrict_manage_posts','restrict_listings_by_product_cat');

class ic_walker_tax_slug_dropdown extends Walker_CategoryDropdown{

    function start_el(&$output, $category, $depth = 0, $args = array(), $id = 0) {
        $pad = str_repeat('&nbsp;', $depth * 3);
        $cat_name = apply_filters('list_cats', $category->name, $category);

        if( !isset($args['value']) ){
            $args['value'] = ( $category->taxonomy != 'category' ? 'slug' : 'id' );
        }

        $value = ($args['value']=='slug' ? $category->slug : $category->term_id );

        $output .= "\t<option class=\"level-$depth\" value=\"".$value."\"";
        if ( $value === (string) $args['selected'] ){
            $output .= ' selected="selected"';
        }
        $output .= '>';
        $output .= $pad.$cat_name;
        if ( $args['show_count'] )
            $output .= '&nbsp;&nbsp;('. $category->count .')';

        $output .= "</option>\n";
    }

}
