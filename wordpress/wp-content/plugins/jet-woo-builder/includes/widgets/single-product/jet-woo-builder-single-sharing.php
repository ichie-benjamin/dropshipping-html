<?php
/**
 * Class: Jet_Woo_Builder_Single_Sharing
 * Name: Single Sharing
 * Slug: jet-single-sharing
 */

namespace Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Widget_Base;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class Jet_Woo_Builder_Single_Sharing extends Jet_Woo_Builder_Base {

	public function get_name() {
		return 'jet-single-sharing';
	}

	public function get_title() {
		return esc_html__( 'Single Sharing', 'jet-woo-builder' );
	}

	public function get_icon() {
		return 'jetwoobuilder-icon-12';
	}

	public function get_script_depends() {
		return array();
	}

	public function get_categories() {
		return array( 'jet-woo-builder' );
	}

	protected function _register_controls() {
	}

	protected function render() {

		$this->__context = 'render';

		if ( true === $this->__set_editor_product() ) {
			$this->__open_wrap();
			include $this->__get_global_template( 'index' );
			$this->__close_wrap();
			$this->__reset_editor_product();
		}

	}
}
