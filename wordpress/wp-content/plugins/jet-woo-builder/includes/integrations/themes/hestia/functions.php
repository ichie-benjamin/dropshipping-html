<?php
/**
 * Hestia integration
 */

add_action( 'elementor/page_templates/canvas/before_content', 'jet_woo_hestia_open_canvas_wrap', -999 );
add_action( 'jet-woo-builder/blank-page/before-content',      'jet_woo_hestia_open_canvas_wrap', -999 );

add_action( 'elementor/page_templates/canvas/after_content', 'jet_woo_hestia_close_canvas_wrap', 999 );
add_action( 'jet-woo-builder/blank-page/after_content',      'jet_woo_hestia_close_canvas_wrap', 999 );

add_action( 'elementor/widgets/widgets_registered', 'jet_woo_hestia_fix_wc_hooks' );

add_action( 'wp_enqueue_scripts', 'jet_woo_hestia_enqueue_styles' );

/**
 * Fix WooCommerce hooks for hestia
 *
 * @return [type] [description]
 */
function jet_woo_hestia_fix_wc_hooks() {
	remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
	remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
}

/**
 * Open .site-main wrapper for products
 * @return [type] [description]
 */
function jet_woo_hestia_open_canvas_wrap() {
	if ( ! is_singular( array( jet_woo_builder_post_type()->slug(), 'product' ) ) ) {
		return;
	}

	echo '<div class="site-main">';
}

/**
 * Close .site-main wrapper for products
 * @return [type] [description]
 */
function jet_woo_hestia_close_canvas_wrap() {

	if ( ! is_singular( array( jet_woo_builder_post_type()->slug(), 'product' ) ) ) {
		return;
	}

	echo '</div>';
}

/**
 * Enqueue Hestia integration stylesheets.
 *
 * @since 1.0.0
 * @access public
 * @return void
 */
function jet_woo_hestia_enqueue_styles() {
	wp_enqueue_style(
		'jet-woo-builder-hestia',
		jet_woo_builder()->plugin_url( 'includes/integrations/themes/hestia/assets/css/style.css' ),
		false,
		jet_woo_builder()->get_version()
	);
}