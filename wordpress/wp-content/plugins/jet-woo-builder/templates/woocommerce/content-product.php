<?php
/**
 * Archive item template
 */
?>
<li <?php wc_product_class(); ?>><?php
	$template = jet_woo_builder_integration_woocommerce()->get_current_archive_template();
	echo jet_woo_builder()->parser->get_template_content( $template );
?></li>