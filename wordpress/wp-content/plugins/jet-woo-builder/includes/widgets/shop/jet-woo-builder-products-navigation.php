<?php
/**
 * Class: Jet_Woo_Builder_Products_Navigation
 * Name: Products Navigation
 * Slug: jet-woo-builder-products-navigation
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

class Jet_Woo_Builder_Products_Navigation extends Jet_Woo_Builder_Base {

	public function get_name() {
		return 'jet-woo-builder-products-navigation';
	}

	public function get_title() {
		return esc_html__( 'Products Navigation', 'jet-woo-builder' );
	}

	public function get_icon() {
		return 'jetwoobuilder-icon-28';
	}

	public function get_script_depends() {
		return array();
	}

	public function get_categories() {
		return array( 'jet-woo-builder' );
	}

	protected function _register_controls() {
		$arrows_prev_list = array( '' => esc_html__( 'None', 'jet-woo-builder' ) ) + jet_woo_builder_tools()->get_available_prev_arrows_list();
		$arrows_next_list = array( '' => esc_html__( 'None', 'jet-woo-builder' ) ) + jet_woo_builder_tools()->get_available_next_arrows_list();

		$this->start_controls_section(
			'section_general',
			array(
				'label' => esc_html__( 'Items', 'jet-woo-builder' ),
			)
		);
		$this->add_control(
			'info_notice',
			array(
				'type' => Controls_Manager::RAW_HTML,
				'raw'  => esc_html__( 'Works only with main Query object.', 'jet-woo-builder' )
			)
		);
		$this->add_control(
			'prev_text',
			array(
				'label'       => esc_html__( 'The previous page link text', 'jet-woo-builder' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Previous', 'jet-woo-builder' ),
			)
		);
		$this->add_control(
			'prev_icon',
			array(
				'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__( 'The previous page link icon', 'jet-woo-builder' ),
				'default' => 'fa fa-angle-left',
				'options' => $arrows_prev_list,
			)
		);
		$this->add_control(
			'next_text',
			array(
				'label'       => esc_html__( 'The next page link text', 'jet-woo-builder' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Next', 'jet-woo-builder' ),
			)
		);
		$this->add_control(
			'next_icon',
			array(
				'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__( 'The next page link icon', 'jet-woo-builder' ),
				'default' => 'fa fa-angle-right',
				'options' => $arrows_next_list,
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'general_style',
			array(
				'label'      => esc_html__( 'General', 'jet-woo-builder' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);
		$this->add_control(
			'general_background_color',
			array(
				'label'     => esc_html__( 'Background Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .jet-woo-builder-shop-navigation' => 'background-color: {{VALUE}};',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'general_border',
				'label'       => esc_html__( 'Border', 'jet-woo-builder' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .jet-woo-builder-shop-navigation',
			)
		);
		$this->add_control(
			'general_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .jet-woo-builder-shop-navigation' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'general_shadow',
				'selector' => '{{WRAPPER}} .jet-woo-builder-shop-navigation',
			)
		);
		$this->add_responsive_control(
			'general_padding',
			array(
				'label'      => esc_html__( 'Padding', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .jet-woo-builder-shop-navigation' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'general_margin',
			array(
				'label'      => esc_html__( 'Margin', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .jet-woo-builder-shop-navigation' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'items_style',
			array(
				'label'      => esc_html__( 'Items', 'jet-woo-builder' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);
		$this->add_control(
			'items_alignment',
			array(
				'label'     => esc_html__( 'Alignment', 'jet-woo-builder' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'flex-start',
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
						'title' => __( 'Justified', 'jet-woo-builder' ),
						'icon'  => 'fa fa-align-justify',
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .jet-woo-builder-shop-navigation' => 'justify-content: {{VALUE}}',
				),
			)
		);
		$this->start_controls_tabs( 'tabs_items_style' );
		$this->start_controls_tab(
			'items_normal',
			array(
				'label' => esc_html__( 'Normal', 'jet-woo-builder' ),
			)
		);
		$this->add_control(
			'items_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .jet-woo-builder-shop-navigation > a' => 'background-color: {{VALUE}}',
				),
			)
		);
		$this->add_control(
			'items_color',
			array(
				'label'     => esc_html__( 'Text Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .jet-woo-builder-shop-navigation > a' => 'color: {{VALUE}}',
				),
			)
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'items_hover',
			array(
				'label' => esc_html__( 'Hover', 'jet-woo-builder' ),
			)
		);
		$this->add_control(
			'items_bg_color_hover',
			array(
				'label'     => esc_html__( 'Background Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .jet-woo-builder-shop-navigation > a:hover' => 'background-color: {{VALUE}}',
				),
			)
		);
		$this->add_control(
			'items_color_hover',
			array(
				'label'     => esc_html__( 'Text Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .jet-woo-builder-shop-navigation > a:hover' => 'color: {{VALUE}}',
				),
			)
		);
		$this->add_control(
			'items_hover_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'items_border_border!' => '',
				),
				'selectors' => array(
					'{{WRAPPER}} .jet-woo-builder-shop-navigation > a:hover' => 'border-color: {{VALUE}};',
				),
			)
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'items_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .jet-woo-builder-shop-navigation > a',
				'exclude'  => array(
					'text_decoration'
				)
			)
		);
		$this->add_responsive_control(
			'items_min_width',
			array(
				'label'      => esc_html__( 'Item Min Width', 'jet-woo-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'default'    => array(
					'unit' => 'px',
					'size' => 20,
				),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 150,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .jet-woo-builder-shop-navigation > a' => 'min-width: {{SIZE}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'items_padding',
			array(
				'label'      => esc_html__( 'Padding', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'default'    => array(
					'top'      => 10,
					'right'    => 10,
					'bottom'   => 10,
					'left'     => 10,
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .jet-woo-builder-shop-navigation > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'items_margin',
			array(
				'label'      => esc_html__( 'Margin', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'default'    => array(
					'top'      => 10,
					'right'    => 10,
					'bottom'   => 10,
					'left'     => 10,
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .jet-woo-builder-shop-navigation > a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'items_border',
				'label'       => esc_html__( 'Border', 'jet-woo-builder' ),
				'placeholder' => '1px',
				'selector'    => '{{WRAPPER}} .jet-woo-builder-shop-navigation > a',
			)
		);
		$this->add_responsive_control(
			'items_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .jet-woo-builder-shop-navigation > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'icons_style',
			array(
				'label'      => esc_html__( 'Prev/Next Icons', 'jet-woo-builder' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);
		$this->start_controls_tabs( 'tabs_icons_style' );
		$this->start_controls_tab(
			'icons_normal',
			array(
				'label' => esc_html__( 'Normal', 'jet-woo-builder' ),
			)
		);
		$this->add_control(
			'icons_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .jet-woo-builder-shop-navigation .jet-woo-builder-shop-navigation__arrow' => 'background-color: {{VALUE}}',
				),
			)
		);
		$this->add_control(
			'icons_color',
			array(
				'label'     => esc_html__( 'Text Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .jet-woo-builder-shop-navigation .jet-woo-builder-shop-navigation__arrow' => 'color: {{VALUE}}',
				),
			)
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'icons_hover',
			array(
				'label' => esc_html__( 'Hover', 'jet-woo-builder' ),
			)
		);
		$this->add_control(
			'icons_bg_color_hover',
			array(
				'label'     => esc_html__( 'Background Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .jet-woo-builder-shop-navigation > a:hover .jet-woo-builder-shop-navigation__arrow' => 'background-color: {{VALUE}}',
				),
			)
		);
		$this->add_control(
			'icons_color_hover',
			array(
				'label'     => esc_html__( 'Text Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .jet-woo-builder-shop-navigation > a:hover .jet-woo-builder-shop-navigation__arrow' => 'color: {{VALUE}}',
				),
			)
		);
		$this->add_control(
			'icons_hover_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'items_border_border!' => '',
				),
				'selectors' => array(
					'{{WRAPPER}} .jet-woo-builder-shop-navigation > a:hover .jet-woo-builder-shop-navigation__arrow' => 'border-color: {{VALUE}};',
				),
			)
		);
		$this->end_controls_tab();
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_responsive_control(
			'items_icon_size',
			array(
				'label'      => esc_html__( 'Icon Size', 'jet-woo-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 10,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .jet-woo-builder-shop-navigation > a .jet-woo-builder-shop-navigation__arrow' => 'font-size: {{SIZE}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'icons_box_size',
			array(
				'label'      => esc_html__( 'Icon Box Size', 'jet-woo-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'default'    => array(
					'unit' => 'px',
					'size' => 18,
				),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 150,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .jet-woo-builder-shop-navigation > a .jet-woo-builder-shop-navigation__arrow' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'icons_border',
				'label'       => esc_html__( 'Border', 'jet-woo-builder' ),
				'placeholder' => '1px',
				'selector'    => '{{WRAPPER}} .jet-woo-builder-shop-navigation .jet-woo-builder-shop-navigation__arrow',
			)
		);
		$this->add_responsive_control(
			'icons_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .jet-woo-builder-shop-navigation .jet-woo-builder-shop-navigation__arrow' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'items_icon_gap',
			array(
				'label'      => esc_html__( 'Gap Between Text and Icon', 'jet-woo-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 20,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .jet-woo-builder-shop-navigation > a .jet-woo-builder-shop-navigation__arrow.jet-arrow-prev' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .jet-woo-builder-shop-navigation > a .jet-woo-builder-shop-navigation__arrow.jet-arrow-next' => 'margin-left: {{SIZE}}{{UNIT}};',
				),
			)
		);
		$this->end_controls_section();
	}

	protected function render() {

		$settings  = $this->get_settings();
		$prev_text = isset( $settings['prev_text'] ) ? $settings['prev_text'] : '';
		$next_text = isset( $settings['next_text'] ) ? $settings['next_text'] : '';

		if ( ! empty( $settings['prev_icon'] ) ) {
			$prev_text = $this->get_navigation_arrow( $settings['prev_icon'], 'prev' ) . $prev_text;
		}
		if ( ! empty( $settings['next_icon'] ) ) {
			$next_text = $next_text . $this->get_navigation_arrow( $settings['next_icon'], 'next' );
		}

		$this->__open_wrap();
		echo '<div class="jet-woo-builder-shop-navigation">';
		posts_nav_link( ' ', $prev_text, $next_text );
		echo '</div>';
		$this->__close_wrap();

	}

	/**
	 * Return html for arrows in navigation
	 *
	 * @param string $icon
	 * @param string $arrow
	 *
	 * @return string
	 */
	public function get_navigation_arrow( $icon = '', $arrow = 'next' ) {

		$format = apply_filters(
			'jet-woo-builder/shop-navigation/arrows-format',
			'<i class="%1$s jet-arrow-%2$s jet-woo-builder-shop-navigation__arrow"></i>'
		);

		return sprintf( $format, $icon, $arrow );

	}
}
