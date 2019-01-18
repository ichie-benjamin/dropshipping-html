<?php
/**
 * Loop item title
 */

$title = $category->name;

if ( 'yes' !== $this->get_attr( 'show_title' ) ) {
	return;
}
?>

<div class="jet-woo-category-title">
	<a href="<?php echo jet_woo_builder_tools()->get_term_permalink( $category->term_id ) ?>" class="jet-woo-category-title__link"><?php echo $title; ?></a>
</div>