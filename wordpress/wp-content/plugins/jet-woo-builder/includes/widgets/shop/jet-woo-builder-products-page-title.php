<?php
/**
 * Class: Jet_Woo_Builder_Products_Page_Title
 * Name: Page Title
 * Slug: jet-woo-builder-products-page-title
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

class Jet_Woo_Builder_Products_Page_Title extends Jet_Woo_Builder_Base {

	public function get_name() {
		return 'jet-woo-builder-products-page-title';
	}

	public function get_title() {
		return esc_html__( 'Products Page Title', 'jet-woo-builder' );
	}

	public function get_icon() {
		return 'jetwoobuilder-icon-32';
	}

	public function get_script_depends() {
		return array();
	}

	public function get_categories() {
		return array( 'jet-woo-builder' );
	}

	protected function _register_controls() {

		$css_scheme = apply_filters(
			'jet-woo-builder/products-page-title/css-scheme',
			array(
				'page_title' => '.woocommerce-products-header__title.page-title',
			)
		);

		$this->start_controls_section(
			'section_page_title_content',
			array(
				'label' => __( 'Page Title', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'page_title_tag',
			array(
				'label'   => esc_html__( 'Tag', 'jet-woo-builder' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h1',
				'options' => array(
					'div'  => esc_html__( 'DIV', 'jet-woo-builder' ),
					'h1'   => esc_html__( 'H1', 'jet-woo-builder' ),
					'h2'   => esc_html__( 'H2', 'jet-woo-builder' ),
					'h3'   => esc_html__( 'H3', 'jet-woo-builder' ),
					'h4'   => esc_html__( 'H4', 'jet-woo-builder' ),
					'h5'   => esc_html__( 'H5', 'jet-woo-builder' ),
					'h6'   => esc_html__( 'H6', 'jet-woo-builder' ),
					'span' => esc_html__( 'SPAN', 'jet-woo-builder' ),
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_page_title_style',
			array(
				'label' => __( 'Page Title', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'page_title_text_color',
			array(
				'label'     => __( 'Text Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['page_title'] => 'color: {{VALUE}};',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'page_title_typography',
				'selector' => '{{WRAPPER}} ' . $css_scheme['page_title'],
			)
		);
		$this->add_responsive_control(
			'page_title_align',
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
					'{{WRAPPER}} ' . $css_scheme['page_title'] => 'text-align: {{VALUE}};',
				],
			)
		);

	}

	protected function render() {

		$this->__context = 'render';

		$settings = $this->get_settings();

		$tag = $settings['page_title_tag'];

		$this->__open_wrap();

		echo '<' . $tag . ' class="woocommerce-products-header__title page-title">';
		woocommerce_page_title();
		echo '</' . $tag . '>';

		$this->__close_wrap();

	}
}
