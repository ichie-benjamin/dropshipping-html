<?php
/**
 * Class: Jet_Woo_Builder_Single_Content
 * Name: Single Content
 * Slug: jet-single-content
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

class Jet_Woo_Builder_Single_Content extends Jet_Woo_Builder_Base {

	public function get_name() {
		return 'jet-single-content';
	}

	public function get_title() {
		return esc_html__( 'Single Content', 'jet-woo-builder' );
	}

	public function get_icon() {
		return 'jetwoobuilder-icon-3';
	}

	public function get_script_depends() {
		return array();
	}

	public function get_categories() {
		return array( 'jet-woo-builder' );
	}

	protected function _register_controls() {

		$css_scheme = apply_filters(
			'jet-woo-builder/jet-single-content/css-scheme',
			array(
				'content_wrapper'            => '.jet-woo-builder .jet-single-content'
			)
		);

		$this->start_controls_section(
			'section_single_content_style',
			array(
				'label' => __( 'General', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'single_content_text_color',
			array(
				'label'     => __( 'Text Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['content_wrapper'] => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'   => 'typography',
				'selector' => '{{WRAPPER}} ' . $css_scheme['content_wrapper'],
			)
		);

		$this->add_responsive_control(
			'single_content_align',
			array(
				'label'     => __( 'Alignment', 'jet-woo-builder' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'    => array(
						'title' => __( 'Left', 'jet-woo-builder' ),
						'icon'  => 'fa fa-align-left',
					),
					'center'  => array(
						'title' => __( 'Center', 'jet-woo-builder' ),
						'icon'  => 'fa fa-align-center',
					),
					'right'   => array(
						'title' => __( 'Right', 'jet-woo-builder' ),
						'icon'  => 'fa fa-align-right',
					),
					'justify' => array(
						'title' => __( 'Justified', 'jet-woo-builder' ),
						'icon'  => 'fa fa-align-justify',
					),
				),
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['content_wrapper'] => 'text-align: {{VALUE}};',
				],
			)
		);

		$this->end_controls_section();

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
