<?php
/**
 * Class: Jet_Woo_Builder_Products_Loop
 * Name: Products Loop
 * Slug: jet-woo-builder-products-loop
 */

namespace Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Scheme_Typography;
use Elementor\Widget_Base;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class Jet_Woo_Builder_Products_Loop extends Jet_Woo_Builder_Base {

	public function get_name() {
		return 'jet-woo-builder-products-loop';
	}

	public function get_title() {
		return esc_html__( 'Products Loop', 'jet-woo-builder' );
	}

	public function get_icon() {
		return 'jetwoobuilder-icon-27';
	}

	public function get_script_depends() {
		return array();
	}

	public function get_categories() {
		return array( 'jet-woo-builder' );
	}

	protected function _register_controls() {
	}

	public static function products_loop() {

		if ( woocommerce_product_loop() ) {

			woocommerce_product_loop_start();

			if ( wc_get_loop_prop( 'total' ) ) {
				while ( have_posts() ) {
					the_post();

					/**
					 * Hook: woocommerce_shop_loop.
					 *
					 * @hooked WC_Structured_Data::generate_product_data() - 10
					 */
					do_action( 'woocommerce_shop_loop' );

					wc_get_template_part( 'content', 'product' );
				}
			}

			woocommerce_product_loop_end();

		} else {
			do_action( 'woocommerce_no_products_found' );
		}

	}

	protected function render() {

		$this->__context = 'render';

		$this->__open_wrap();

		self::products_loop();

		$this->__close_wrap();

	}
}
