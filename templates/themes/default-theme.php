<?php
/**
 * Manages catalog default theme
 *
 * Here default theme is defined and managed.
 *
 * @version		1.1.4
 * @package		ecommerce-product-catalog/templates/themes
 * @author 		Norbert Dreszer
 */
 
 function example_default_archive_theme() { ?>
 <div id="content">
 <a href="#default-theme"><div class="al_archive" style="background-image:url('<?php echo AL_PLUGIN_BASE_PATH .'templates/themes/img/example-product.jpg'; ?>'); background-position:center; ">
				<div class="product-name">White Lamp</div>
				<div class="product-attributes">
				<table class="attributes-table">
				<tbody><tr><td>Height</td><td>20 </td></tr><tr><td>Color</td><td>White </td></tr>		
				</tbody></table>
				</div><div class="product-price">10 USD</div>
				</div></a> 
</div>
<?php }

function example_list_archive_theme() { ?>
<div class="archive-listing list example"><a href="#list-theme"><span class="div-link"></span></a><div class="product-image" style="background-image:url('<?php echo AL_PLUGIN_BASE_PATH .'templates/themes/img/example-product.jpg'; ?>'); background-size: 150px; background-position: center;"></div><div class="product-name">White Lamp</div><div class="product-short-descr"><p>Fusce vestibulum augue ac quam tincidunt ullamcorper. Vestibulum scelerisque fermentum congue. Proin convallis dolor ac ipsum congue tincidunt. Donec ullamcorper ipsum id risus feugiat volutpat. Curabitur cursus mattis dui sit amet scelerisque. [...]</p>
</div></div>
<?php } 

function example_grid_archive_theme() { ?>
<div class="archive-listing grid example">
		<a href="#grid-theme">
		<div style="background-image:url('<?php echo AL_PLUGIN_BASE_PATH .'templates/themes/img/example-product.jpg'; ?>'); background-size: 200px; background-position: center; width:200px; height:200px;"></div>
		<div class="product-name">White Lamp</div>
		<div class="product-price">10 USD</div>
		</a>
</div>
<?php } 