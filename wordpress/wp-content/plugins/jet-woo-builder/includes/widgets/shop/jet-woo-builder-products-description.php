<?php
/**
 * Class: Jet_Woo_Builder_Products_Description
 * Name: Products Description
 * Slug: jet-woo-builder-products-description
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

class Jet_Woo_Builder_Products_Description extends Jet_Woo_Builder_Base {

	public function get_name() {
		return 'jet-woo-builder-products-description';
	}

	public function get_title() {
		return esc_html__( 'Products Description', 'jet-woo-builder' );
	}

	public function get_icon() {
		return 'jetwoobuilder-icon-26';
	}

	public function get_script_depends() {
		return array();
	}

	public function get_categories() {
		return array( 'jet-woo-builder' );
	}

	protected function _register_controls() {

		$css_scheme = apply_filters(
			'jet-woo-builder/products-result-count/css-scheme',
			array(
				'term_description'    => '.elementor-jet-woo-builder-products-description .term-description',
				'archive_description' => '.elementor-jet-woo-builder-products-description .page-description',
			)
		);

		$this->start_controls_section(
			'section_products_description_style',
			array(
				'label' => __( 'Products Description', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'products_description_text_color',
			array(
				'label'     => __( 'Text Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['term_description']    => 'color: {{VALUE}};',
					'{{WRAPPER}} ' . $css_scheme['archive_description'] => 'color: {{VALUE}};',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'products_description_typography',
				'selector' => '{{WRAPPER}} ' . $css_scheme['term_description'] . ',' . '{{WRAPPER}} ' . $css_scheme['archive_description'],
			)
		);
		$this->add_responsive_control(
			'products_description_align',
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
					'{{WRAPPER}} ' . $css_scheme['term_description']    => 'text-align: {{VALUE}};',
					'{{WRAPPER}} ' . $css_scheme['archive_description'] => 'text-align: {{VALUE}};',
				],
			)
		);

	}

	protected function render() {

		$this->__context = 'render';

		$this->__open_wrap();

		woocommerce_taxonomy_archive_description();
		woocommerce_product_archive_description();

		$this->__close_wrap();

	}
}
