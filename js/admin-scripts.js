/*!
	impleCode Admin scripts v1.0.0 - 2014-02-11
	Adds appropriate scripts to admin settings
	(c) 2014 Norbert Dreszer - http://implecode.com
*/

jQuery(document).ready(function() {
var fixHelper = function(e, ui) {
	ui.children().each(function() {
		jQuery(this).width(jQuery(this).width());
	});
	return ui;
};

jQuery('.sort-settings tbody').sortable({
	update: function(event, ui){  
              jQuery('.sort-settings tbody tr').each(function(){
			  var r = jQuery(this).index() + 1;
			  jQuery(this).find('td .attribute-label').attr('name', '_attribute-label'+r);
			  jQuery(this).find('td .attribute-value').attr('name', '_attribute'+r);
			  jQuery(this).find('td .attribute-unit').attr('name', '_attribute-unit'+r);
			  
			  jQuery(this).find('td .shipping-label').attr('name', '_shipping-label'+r);
			  jQuery(this).find('td .shipping-value').attr('name', '_shipping'+r);
              })
             },
	helper: fixHelper,
	placeholder: 'sort-settings-placeholder',	
});
//jQuery('.attributes .ui-sortable').height(jQuery('.attributes .ui-sortable').height());
//jQuery('.shipping .ui-sortable').height(jQuery('.shipping .ui-sortable').height());
var fields = new Array('input[name="enable_product_listing"]', 'input[name="archive_multiple_settings\[archive_products_limit\]"]', 'input[name="archive_multiple_settings\[category_archive_url\]"]', 'input[name="archive_multiple_settings\[seo_title\]"]','input[name="archive_multiple_settings\[seo_title_sep\]"]','input[name="archive_multiple_settings\[breadcrumbs_title\]"]','input[name="archive_multiple_settings\[enable_product_breadcrumbs\]"]', 'input[name="archive_multiple_settings\[product_listing_cats\]"]', 'input[name="archive_multiple_settings\[category_top_cats\]"]', 'input[name="archive_multiple_settings\[cat_template\]"]');
jQuery('input[name="archive_multiple_settings\[integration_type\]"]').change(function() {
	var disable = false;
	if (jQuery(this).is(':checked') && jQuery(this).val() == 'simple') {
	disable = true;
	}
	if (jQuery(this).is(':checked')) {
		jQuery.each(fields, function(index, element) {
			jQuery(element).prop( "disabled", disable );
		});
	}
});
jQuery('input[name="archive_multiple_settings\[integration_type\]"]').trigger("change");
jQuery(".overall-product-settings .submit .button-primary").click(function() {
	jQuery.each(fields, function(index, element) {
		jQuery(element).prop( "disabled", false );
	});
});

jQuery(".implecode-review .dashicons-no").click(function() {
	var data = {
			'action': 'hide_review_notice',
		};
	jQuery.post(ajaxurl, data, function(response) {
		jQuery(".implecode-review").hide("slow");
	});
});

jQuery(".implecode-review-thanks .dashicons-yes").click(function() {
	jQuery(".implecode-review-thanks").hide("slow");
});

jQuery(".implecode-review a").click(function() {
	var data = {
			'action': 'hide_review_notice',
			'forever': 'yes',
		};
	jQuery.post(ajaxurl, data, function(response) {
		jQuery(".implecode-review").hide("slow");
		jQuery(".implecode-review-thanks").show("slow");
	});
});

jQuery(function() {
		jQuery( ".setting-content input" ).tooltip({
			position: {
				my: "left-48 top+37",
				at: "right+48 bottom-37",
				collision: "flip",
			},
			track: true,
			show: {delay: 200},
		});
	});
});