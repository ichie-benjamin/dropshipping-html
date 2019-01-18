<?php
/**
 * Class: Jet_Woo_Builder_Products_Notices
 * Name: Products Notices
 * Slug: jet-woo-builder-products-notices
 */

namespace Elementor;

use Elementor\Widget_Base;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class Jet_Woo_Builder_Products_Notices extends Jet_Woo_Builder_Base {

	public function get_name() {
		return 'jet-woo-builder-products-notices';
	}

	public function get_title() {
		return esc_html__( 'Products Notices', 'jet-woo-builder' );
	}

	public function get_icon() {
		return 'jetwoobuilder-icon-30';
	}

	public function get_script_depends() {
		return array();
	}

	public function get_categories() {
		return array( 'jet-woo-builder' );
	}

	protected function render() {

		$this->__context = 'render';

		$this->__open_wrap();

		if ( !jet_woo_builder_integration()->in_elementor() ) {
			wc_print_notices();
		}

		$this->__close_wrap();

	}
}
