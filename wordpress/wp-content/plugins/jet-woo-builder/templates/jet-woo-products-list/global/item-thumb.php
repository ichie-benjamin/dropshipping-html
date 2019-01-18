<?php
/**
 * Loop item thumbnail
 */

$size = $this->get_attr( 'thumb_size' );
$thumbnail = jet_woo_builder_template_functions()->get_product_thumbnail( $size );

if ( 'yes' !== $this->get_attr( 'show_image' ) || null === $thumbnail ) {
	return;
}
?>

<div class="jet-woo-product-thumbnail"><?php echo $thumbnail; ?></div>