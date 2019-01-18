<?php
/**
 * Loop item description
 */

$description = jet_woo_builder_tools()->trim_text( $category->description, $this->get_attr( 'desc_length' ), 'word', $this->get_attr( 'desc_after_text' ) );

if ( '' === $description ) {
	return;
}
?>

<div class="jet-woo-category-excerpt"><?php echo $description; ?></div>