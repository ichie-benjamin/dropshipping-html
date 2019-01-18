<?php
/**
 * Kava integration
 */

add_action( 'elementor/page_templates/canvas/before_content', 'jet_woo_kava_open_canvas_wrap', -999 );
add_action( 'jet-woo-builder/blank-page/before-content',      'jet_woo_kava_open_canvas_wrap', -999 );

add_action( 'elementor/page_templates/canvas/after_content', 'jet_woo_kava_close_canvas_wrap', 999 );
add_action( 'jet-woo-builder/blank-page/after_content',      'jet_woo_kava_close_canvas_wrap', 999 );

add_action( 'elementor/widgets/widgets_registered', 'jet_woo_kava_fix_wc_hooks' );

/**
 * Fix WooCommerce hooks for kava
 *
 * @return [type] [description]
 */
function jet_woo_kava_fix_wc_hooks() {
	remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 10 );
}

/**
 * Open .site-main wrapper for products
 * @return [type] [description]
 */
function jet_woo_kava_open_canvas_wrap() {
	if ( ! is_singular( array( jet_woo_builder_post_type()->slug(), 'product' ) ) ) {
		return;
	}

	echo '<div class="site-main">';
}

/**
 * Close .site-main wrapper for products
 * @return [type] [description]
 */
function jet_woo_kava_close_canvas_wrap() {

	if ( ! is_singular( array( jet_woo_builder_post_type()->slug(), 'product' ) ) ) {
		return;
	}

	echo '</div>';
}