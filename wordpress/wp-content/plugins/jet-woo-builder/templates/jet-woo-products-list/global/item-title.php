<?php
/**
 * Loop item title
 */

$title = jet_woo_builder_tools()->trim_text( jet_woo_builder_template_functions()->get_product_title(), $this->get_attr( 'title_length' ) , 'word', '...' );
$title_link = jet_woo_builder_template_functions()->get_product_title_link();

if ( 'yes' !== $this->get_attr( 'show_title' ) || '' === $title ) {
	return;
}
?>

<div class="jet-woo-product-title"><a href="<?php echo $title_link; ?>" rel="bookmark"><?php echo $title; ?></a></div>
