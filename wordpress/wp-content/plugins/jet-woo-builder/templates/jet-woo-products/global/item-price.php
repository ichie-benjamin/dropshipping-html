<?php
/**
 * Loop item price
 */

$price = jet_woo_builder_template_functions()->get_product_price();

if ( 'yes' !== $this->get_attr( 'show_price' ) || '' === $price ) {
	return;
}
?>

<div class="jet-woo-product-price"><?php echo $price; ?></div>