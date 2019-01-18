<?php
/**
 * Class: Jet_Woo_Builder_Single_Rating
 * Name: Single Rating
 * Slug: jet-single-rating
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

class Jet_Woo_Builder_Single_Rating extends Jet_Woo_Builder_Base {

	public function get_name() {
		return 'jet-single-rating';
	}

	public function get_title() {
		return esc_html__( 'Single Rating', 'jet-woo-builder' );
	}

	public function get_icon() {
		return 'jetwoobuilder-icon-8';
	}

	public function get_script_depends() {
		return array();
	}

	public function get_categories() {
		return array( 'jet-woo-builder' );
	}

	protected function _register_controls() {

		$css_scheme = apply_filters(
			'jet-woo-builder/jet-single-rating/css-scheme',
			array(
				'rating_wrapper' => '.jet-woo-builder .woocommerce-product-rating',
				'stars'          => '.jet-woo-builder.elementor-jet-single-rating .product-rating__content',
				'reviews_link'   => '.jet-woo-builder .woocommerce-review-link',
			)
		);

		$this->start_controls_section(
			'section_rating_styles',
			array(
				'label'      => esc_html__( 'Rating', 'jet-woo-builder' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'rating_icon',
			array(
				'label'   => esc_html__( 'Rating Icon', 'jet-woo-builder' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'jetwoo-front-icon-rating-1',
				'options' => jet_woo_builder_tools()->get_available_rating_icons_list(),
			)
		);

		$this->add_control(
			'rating_direction',
			array(
				'label'     => esc_html__( 'Elements display', 'jet-woo-builder' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'row',
				'options'   => array(
					'column' => esc_html__( 'Block', 'jet-woo-builder' ),
					'row'    => esc_html__( 'Inline', 'jet-woo-builder' ),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['rating_wrapper'] => 'flex-direction: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'rating_alignment_horizontal',
			array(
				'label'     => esc_html__( 'Alignment', 'jet-woo-builder' ),
				'type'      => Controls_Manager::CHOOSE,
				'condition' => array(
					'rating_direction' => 'row',
				),
				'default'   => 'left',
				'options'   => array(
					'flex-start'    => array(
						'title' => esc_html__( 'Left', 'jet-woo-builder' ),
						'icon'  => 'fa fa-align-left',
					),
					'center'        => array(
						'title' => esc_html__( 'Center', 'jet-woo-builder' ),
						'icon'  => 'fa fa-align-center',
					),
					'flex-end'      => array(
						'title' => esc_html__( 'Right', 'jet-woo-builder' ),
						'icon'  => 'fa fa-align-right',
					),
					'space-between' => array(
						'title' => esc_html__( 'Justify', 'jet-woo-builder' ),
						'icon'  => 'fa fa-align-justify',
					),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['rating_wrapper'] => 'justify-content: {{VALUE}}; align-items: flex-start;',
				),
			)
		);

		$this->add_responsive_control(
			'rating_alignment_vertical',
			array(
				'label'     => esc_html__( 'Alignment', 'jet-woo-builder' ),
				'type'      => Controls_Manager::CHOOSE,
				'condition' => array(
					'rating_direction' => 'column',
				),
				'default'   => 'left',
				'options'   => array(
					'flex-start' => array(
						'title' => esc_html__( 'Left', 'jet-woo-builder' ),
						'icon'  => 'fa fa-align-left',
					),
					'center'     => array(
						'title' => esc_html__( 'Center', 'jet-woo-builder' ),
						'icon'  => 'fa fa-align-center',
					),
					'flex-end'   => array(
						'title' => esc_html__( 'Right', 'jet-woo-builder' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['rating_wrapper'] => 'align-items: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'heading_stars_styles',
			array(
				'label'     => esc_html__( 'Stars', 'jet-woo-builder' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->start_controls_tabs( 'tabs_stars_styles' );

		$this->start_controls_tab(
			'tab_stars_all',
			array(
				'label' => esc_html__( 'All', 'jet-woo-builder' ),
			)
		);

		$this->add_control(
			'stars_color_all',
			array(
				'label'     => esc_html__( 'Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e7e8e8',
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['stars'] . ' .product-rating__icon' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_stars_rated',
			array(
				'label' => esc_html__( 'Rated', 'jet-woo-builder' ),
			)
		);

		$this->add_control(
			'stars_color_rated',
			array(
				'label'     => esc_html__( 'Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fdbc32',
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['stars'] . ' .product-rating__icon.active' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'stars_font_size',
			array(
				'label'      => esc_html__( 'Font Size (px)', 'jet-woo-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 60,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 16,
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['stars'] . ' .product-rating__icon' => 'font-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'stars_space_between',
			array(
				'label'      => esc_html__( 'Space Between Stars (px)', 'jet-woo-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 20,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 2,
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['stars'] . ' .product-rating__icon + .product-rating__icon' => 'margin-left: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'stars_margin',
			array(
				'label'      => __( 'Margin', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['stars'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'heading_reviews_link_styles',
			array(
				'label'     => esc_html__( 'Reviews Link', 'jet-woo-builder' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'reviews_link_typography',
				'selector' => '{{WRAPPER}} ' . $css_scheme['reviews_link'],
			)
		);

		$this->start_controls_tabs( 'tabs_reviews_link_styles' );

		$this->start_controls_tab(
			'tab_reviews_link_normal',
			array(
				'label' => esc_html__( 'Normal', 'jet-woo-builder' ),
			)
		);

		$this->add_control(
			'reviews_link_color_normal',
			array(
				'label'     => esc_html__( 'Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['reviews_link'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_reviews_link_hover',
			array(
				'label' => esc_html__( 'Hover', 'jet-woo-builder' ),
			)
		);

		$this->add_control(
			'reviews_link_color_hover',
			array(
				'label'     => esc_html__( 'Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['reviews_link'] . ':hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'reviews_link_decoration',
			array(
				'label'     => esc_html__( 'Text Decoration', 'jet-woo-builder' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'none',
				'options'   => array(
					'none'         => esc_html__( 'None', 'jet-woo-builder' ),
					'line-through' => esc_html__( 'Line Through', 'jet-woo-builder' ),
					'underline'    => esc_html__( 'Underline', 'jet-woo-builder' ),
					'overline'     => esc_html__( 'Overline', 'jet-woo-builder' ),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['reviews_link'] . ':hover' => 'text-decoration: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'reviews_link_margin',
			array(
				'label'      => __( 'Margin', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['reviews_link'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
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
