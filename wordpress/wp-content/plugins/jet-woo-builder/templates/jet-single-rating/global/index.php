<?php
/**
 * Single rating template
 */

$settings = $this->get_settings();

global $product;

if ( 'no' === get_option( 'woocommerce_enable_review_rating' ) ) {
	return;
}

$rating_count = $product->get_rating_count();
$review_count = $product->get_review_count();
$average      = $product->get_average_rating();

if ( ! isset( $settings['rating_icon'] ) ) {
	$settings['rating_icon'] = 'jetwoo-front-icon-rating-1';
}

$rating = jet_woo_builder_template_functions()->get_product_custom_rating( $settings['rating_icon'] );

if ( $rating_count > 0 ) : ?>

	<div class="woocommerce-product-rating">
		<?php echo $rating; ?>
		<?php if ( comments_open() ) : ?><a href="#reviews" class="woocommerce-review-link" rel="nofollow">(<?php printf( _n( '%s customer review', '%s customer reviews', $review_count, 'jet-woo-builder' ), '<span class="count">' . esc_html( $review_count ) . '</span>' ); ?>)</a><?php endif ?>
	</div>

<?php endif; ?>