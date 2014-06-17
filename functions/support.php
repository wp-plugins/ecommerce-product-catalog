<?php
/**
 * Manages support settings
 *
 * Here support settings are defined and managed.
 *
 * @version		1.0.0
 * @package		holland-utrecht-from-implecode/includes
 * @author 		Norbert Dreszer
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( !function_exists('implecode_support_menu') ):

function implecode_custom_support_menu() { ?>
	<a id="support-settings" class="element" href="./edit.php?post_type=al_product&page=product-settings.php&tab=product-settings&submenu=support"><?php _e('Support', 'smart-multiple-catalogs'); ?></a>
<?php } 

add_action('general_submenu','implecode_custom_support_menu', 20);

function implecode_custom_support_settings_content() { ?>
	<?php $submenu = isset($_GET['submenu']) ? $_GET['submenu'] : ''; ?>
	<?php if ($submenu == 'support') { ?>
	<script>
	jQuery('.settings-submenu a').removeClass('current');
	jQuery('.settings-submenu a#support-settings').addClass('current');
	</script>
		<div class="setting-content submenu support-tab">
			<h2><?php _e('impleCode Support', 'al-ecommerce-product-catalog'); ?></h2>
			<p><?php _e('<b>eCommerce Product Catalog is free to use</b> - life is wonderful and lovely! However, it is required a great deal of time and effort to develop  such a software. If you found eCommerce Product Catalog useful or it saved you some amount of time you can support its development by making a small donation. This will act as an incentive for me to carry on developing. You get some useful software and I get to carry on making it. Everybody wins.','al-ecommerce-product-catalog'); ?></p>
			<p><?php _e('This awesome plugin is developed under impleCode brand which is a legally operating company. It means that <b>you can get even more value</b> if you prefer to. Choose between:', 'al-ecommerce-product-catalog') ?></p>
			<table>
			<tr>
			<td>
				<?php _e('<b>Donation</b> (which is just a donation, it means you do not get any more value than the free plugin and its continuous development)','al-ecommerce-product-catalog') ?>
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
				<input type="hidden" name="cmd" value="_s-xclick">
				<input type="hidden" name="hosted_button_id" value="JWBN4VA7EDJKY">
				<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
				<img alt="" border="0" src="https://www.paypalobjects.com/pl_PL/i/scr/pixel.gif" width="1" height="1">
			</form>
			</td>
			<td>
				<?php _e('<b>One year</b> of high quality and speedy email', 'al-ecommerce-product-catalog') ?> <a target="_blank" href="http://implecode.com/wordpress/plugins/premium-support/#cam=catalog-support-tab&key=support-link">Premium Support</a> <?php _e('from impleCode support team for just','al-ecommerce-product-catalog') ?> $19.99.
				<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
					<input type="hidden" name="cmd" value="_s-xclick">
					<input type="hidden" name="hosted_button_id" value="LCRGR95EST66S">
					<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
					<img alt="" border="0" src="https://www.paypalobjects.com/pl_PL/i/scr/pixel.gif" width="1" height="1">
				</form>
			</td>
			<td>
			<?php echo sprintf( __('<b>Extensions</b> provide additional useful features. They improve eCommerce Product Catalog in a field of <a target="_blank" href="%1$s">SEO</a>, <a target="_blank" href="%3$s">Productivity</a>, <a target="_blank" href="%2$s">Usability</a> and <a target="_blank" href="%4$s">Conversion</a>.','al-ecommerce-product-catalog'), esc_url( 'http://implecode.com/wordpress/plugins/?cam=catalog-support-tab&key=extensions-link-seo#seo_usability_boosters' ),  esc_url( 'http://implecode.com/wordpress/plugins/?cam=catalog-support-tab&key=extensions-link-usability#seo_usability_boosters' ), esc_url( 'http://implecode.com/wordpress/plugins/?cam=catalog-support-tab&key=extensions-link-productivity#productivity_boosters' ), esc_url( 'http://implecode.com/wordpress/plugins/?cam=catalog-support-tab&key=extensions-link-conversion#conversion_boosters' )) ?>
			<p><a target="_blank" href="http://implecode.com/wordpress/plugins/?cam=catalog-support-tab&key=extensions-link#conversion_boosters"><input style="cursor:pointer;" class="classic-button" type="button" value="Check out the extensions &raquo;"></a></p>
			</td>
			</tr>
			</table>
			<h2><?php _e('Theme Integration', 'al-ecommerce-product-catalog') ?></h2>
			<p><?php echo sprintf( __('As you may already know some themes may need Theme Integration to fully support eCommerce Product Catalog. I wrote this <a target="_blank" href="%1$s">theme integrations guide</a>, however to make it even easier you will get <a target="_blank" href="%2$s">Advanced Theme Integration</a> service for free* if you choose <a target="_blank" href="%3$s">Premium Support</a> service.','al-ecommerce-product-catalog'), esc_url( 'http://implecode.com/wordpress/product-catalog/theme-integration-guide/#cam=catalog-support-tab&key=integration-link' ),  esc_url( 'http://implecode.com/wordpress/plugins/advanced-theme-integration/#cam=catalog-support-tab&key=integration-service-link' ), esc_url( 'http://implecode.com/wordpress/plugins/premium-support/#cam=catalog-support-tab&key=support-link-2' )) ?></p>
			
			<p>*this is valid until this information is available on Advanced Theme Integration page</p>
			<h2><?php _e('eCommerce Product Catalog documentation', 'al-ecommerce-product-catalog') ?></h2>
			<p><?php echo sprintf( __('<b>eCommerce Product Catalog</b> documentation is being developed <a target="_blank" href="%1$s">here</a>. For questions about eCommerce Product Catalog please use <a target="_blank" href="%2$s">support forum</a> or <a target="_blank" href="%3$s">Premium Support service</a>.','al-ecommerce-product-catalog'), esc_url( 'http://implecode.com/wordpress/product-catalog/#cam=catalog-support-tab&key=docs-link' ),  esc_url( 'http://wordpress.org/support/plugin/ecommerce-product-catalog' ), esc_url( 'http://implecode.com/wordpress/plugins/premium-support/#cam=catalog-support-tab&key=support-link-3' )) ?></p>
			<h2><?php _e('Plugin Extensions', 'al-ecommerce-product-catalog') ?></h2>
			<p><?php _e('For many users eCommerce Product Catalog standard features is more than enough. However for more specialized needs there are some extensions available. eCommerce Product Catalog extensions are divided into:', 'al-ecommerce-product-catalog') ?></p>
			<table class="wp-list-table widefat">
				<thead>
					<th>
						<b>SEO & USABILITY EXTENSIONS</b>
					</th>
					<th>
						<b>PRODUCTIVITY EXTENSIONS</b>
					</th>
					<th>
						<b>CONVERSION EXTENSIONS</b>
					</th>
				<thead>
				<tbody>
					<tr>
						<td>
							<ul class="support-ul">
								<li><a target="_blank" href="http://implecode.com/wordpress/plugins/custom-product-order/#cam=catalog-support-tab&key=custom-product-order-link">Custom Product Order</a></li>
								<li><a target="_blank" href="http://implecode.com/wordpress/plugins/upload-pdf/#cam=catalog-support-tab&key=upload-pdf-link">Upload PDF</a></li>
								<li><a target="_blank" href="http://implecode.com/wordpress/plugins/product-search-pro/#cam=catalog-support-tab&key=product-search-pro-link">Product Search PRO</a></li>
								<li><a target="_blank" href="http://implecode.com/wordpress/plugins/smarter-product-urls/#cam=catalog-support-tab&key=smarter-product-urls-link">Smarter Product URLs</a></li>
								<li><a target="_blank" href="http://implecode.com/wordpress/plugins/product-gallery-advanced/#cam=catalog-support-tab&key=gallery-advanced-link">Product Gallery Advanced</a></li>
								<li><a target="_blank" href="http://implecode.com/wordpress/plugins/smart-multiple-catalogs/#cam=catalog-support-tab&key=smart-multiple-catalogs-link">Smart Multiple Catalogs</a></li>
							</ul>
						</td>
						<td>
							<ul class="support-ul">
								<li><a target="_blank" href="http://implecode.com/wordpress/plugins/drop-attributes/#cam=catalog-support-tab&key=drop-down-attributes-link">Drop-down Attributes</a></li>
							</ul>
						</td>
						<td>
							<ul class="support-ul">
								<li><a target="_blank" href="http://implecode.com/wordpress/plugins/quote-form/#cam=catalog-support-tab&key=quote-form-link">Quote Form</a></li>
								<li><a target="_blank" href="http://implecode.com/wordpress/plugins/paypal-gateway/#cam=catalog-support-tab&key=paypal-gateway-link">PayPal Gateway</a></li>
								<li><a target="_blank" href="http://implecode.com/wordpress/plugins/order-form/#cam=catalog-support-tab&key=order-form-link">Order Form</a></li>
							</ul>
						</td>
					</tr>
				</tbody>
			</table>
		</div> <?php

	} 
}
add_action('product-settings','implecode_custom_support_settings_content');

endif;