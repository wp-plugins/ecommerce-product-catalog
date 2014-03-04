<?php
/**
 * Plugin Name: eCommerce Product Catalog by impleCode
 * Plugin URI: http://implecode.com
 * Description: Wordpress eCommerce easy to use, powerful and beautiful plugin from impleCode. Great choice if you want to sell easy and quick. Or just beautifully present your products on Wordpress website. Full Wordpress integration does great job not only for Merchants but also for Developers and Theme Constructors.
 * Version: 1.4.1
 * Author: Norbert Dreszer
 * Author URI: http://implecode.com
	
	Copyright: 2014 impleCode.
	License: GNU General Public License v3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html */
	
	 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

load_plugin_textdomain( 'al-ecommerce-product-catalog', false, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );

define('AL_BASE_PATH',dirname(__FILE__));
define('AL_PLUGIN_BASE_PATH',plugins_url( '/', __FILE__ ));
define('AL_PLUGIN_MAIN_FILE', __FILE__ );

require_once( 'includes/product.php' );
require_once( 'includes/product-settings.php' );
require_once( 'includes/settings-defaults.php' );
require_once( 'functions/base.php' );
require_once( 'functions/capabilities.php' );
require_once( 'functions/functions.php' );
require_once( 'templates.php' );
require_once( 'theme-product_adder_support.php' );
require_once( 'config/const.php' );
require_once( 'functions/shortcodes.php' );
require_once( 'functions/activation.php' );

register_activation_hook( __FILE__, 'add_product_caps' );
register_activation_hook( __FILE__, 'create_products_page' );

 wp_register_style( 'al_product', '/wp-content/plugins/' . dirname( plugin_basename( __FILE__ ) ) . '/css/al_product.css' );
 wp_enqueue_style( 'al_product' ); 
?>
