<?php
/**
 * Class: Jet_Woo_Builder_Single_Reviews_Form
 * Name: Single Reviews Form
 * Slug: jet-single-reviews-form
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

class Jet_Woo_Builder_Single_Reviews_Form extends Jet_Woo_Builder_Base {

	public function get_name() {
		return 'jet-single-reviews-form';
	}

	public function get_title() {
		return esc_html__( 'Single Reviews Form', 'jet-woo-builder' );
	}

	public function get_icon() {
		return 'jetwoobuilder-icon-10';
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

			$elementor    = Plugin::instance();
			$is_edit_mode = $elementor->editor->is_edit_mode();

			if ( $is_edit_mode ) {
				add_filter( 'comments_template', array( 'WC_Template_Loader', 'comments_template_loader' ) );
			}

			include $this->__get_global_template( 'index' );
			$this->__close_wrap();
			$this->__reset_editor_product();
		}

	}

}
