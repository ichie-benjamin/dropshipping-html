<?php
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

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Bitunet_Crypto_Currency_Price_Widget extends Widget_Base {
	public function get_name() {
		return 'bitunet-cryptoticker';
	}

	public function get_icon() {
		return 'thin-icon-money';
	}

	public function get_title() {
		return esc_html__('Ticker', 'bitunet');
	}

	public function get_categories() {
		return array( 'bitunet' );
	}

	protected function _register_controls() {

		$css_scheme = array (
			'icon' => 'span.ccpw_icon',
			'name' => 'span.name',
			'price' => 'span.price',
			'changes' => 'span.changes',
			'container' => '.coin-container',
			'instance' => '.elementor-widget-container .tickercontainer .mask ul',
			'changes-up' => '.up',
			'changes-down' => '.down',
			'label-holder' => '.ccpw-price-label ul li',
		);

		$this->start_controls_section(
			'section_general',
			array(
				'label' => esc_html__( 'General', 'bitunet' ),
			)
		);
		if( $this->get_ccpw_posts() ) {
			$this->add_control(
				'post_id',
				array(
					'label'   => esc_html__( 'Select Ticker', 'bitunet' ),
					'type'    => Controls_Manager::SELECT,
					'options' => $this->get_ccpw_posts(),
				)
			);
		}
		else {
			$this->add_control(
				'no_post_id',
				array(
					'label' => false,
					'type'  => Controls_Manager::RAW_HTML,
					'raw'   => $this->empty_ccpw_post_message(),
				)
			);
			return;
		}

		$this->end_controls_section();

		$this->start_controls_section(
			'section_general_ticker_styles', array(
				'label' => esc_html__('General Styles', 'bitunet'),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'ticker_coin_container_alignment',
			array(
				'label'   => esc_html__( 'Horizontal Alignment', 'bitunet' ),
				'type'    => Controls_Manager::SELECT,
				'default' => false,
				'options' => array(
					'flex-start'    => esc_html__( 'Left', 'bitunet' ),
					'space-between'        => esc_html__( 'Space Between', 'bitunet' ),
					'space-around'        => esc_html__( 'Space Around', 'bitunet' ),
					'flex-end'      => esc_html__( 'Right', 'bitunet' ),
				),
				'selectors'  => array(
					'{{WRAPPER}} '. $css_scheme['container'] => 'display: flex; justify-content: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'ticker_coin_container_padding',
			array(
				'label'      => esc_html__( 'Coin Container Padding', 'bitunet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['container'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'ticker_coin_container_margin',
			array(
				'label'      => esc_html__( 'Coin Container Margin', 'bitunet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['container'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'ticker_coin_container_border',
				'label'       => esc_html__( 'Border', 'bitunet' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['container'],
			)
		);


		$this->add_control(
			'ticker_background_color',
			array(
				'label'  => esc_html__( 'Ticker Background color', 'bitunet' ),
				'type'   => Controls_Manager::COLOR,
				'scheme' => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				),
				'selectors' => array(
					'{{WRAPPER}} '. $css_scheme['instance'] => 'background: {{VALUE}}' . ' !important',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_ticker_icon_control_style',
			array(
				'label'      => esc_html__( 'Coin Icon Styles', 'bitunet' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_responsive_control(
			'ticker_coin_icon_width',
			array(
				'label'      => esc_html__( 'Ticker Icon Width', 'bitunet' ),
				'label_block' => true,
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%' ),
				'range'      => array(
					'%' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['icon'] => 'max-width: {{SIZE}}%; flex: 0 1 {{SIZE}}%; height: auto;',
				),
			)
		);

		$this->add_control(
			'ticker_coin_icon_background_color',
			array(
				'label'  => esc_html__( 'Ticker Icon Background Color', 'bitunet' ),
				'type'   => Controls_Manager::COLOR,
				'scheme' => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				),
				'selectors' => array(
					'{{WRAPPER}} '. $css_scheme['icon'] => 'background-color: {{VALUE}}' . ' !important',
				),
			)
		);

		$this->add_responsive_control(
			'ticker_coin_icon_align',
			array(
				'label'   => esc_html__( 'Alignment', 'bitunet' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => false,
				'options' => array(
					'left'    => array(
						'title' => esc_html__( 'Left', 'bitunet' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'bitunet' ),
						'icon'  => 'fa fa-align-center',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'bitunet' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['icon'] => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'ticker_coin_icon_padding',
			array(
				'label'      => esc_html__( 'Padding', 'bitunet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['icon'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'ticker_coin_icon_margin',
			array(
				'label'      => esc_html__( 'Margin', 'bitunet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['icon'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'ticker_coin_icon_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'bitunet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['icon'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'section_ticker_name_control_style',
			array(
				'label'      => esc_html__( 'Coin Name Styles', 'bitunet' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_responsive_control(
			'ticker_coin_name_width',
			array(
				'label'      => esc_html__( 'Ticker Name Width', 'bitunet' ),
				'label_block' => true,
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%' ),
				'range'      => array(
					'%' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['name'] => 'max-width: {{SIZE}}%; flex: 0 1 {{SIZE}}%;',
				),
			)
		);


		$this->add_control(
			'ticker_coin_name_color',
			array(
				'label'  => esc_html__( 'Ticker Name Text Color', 'bitunet' ),
				'type'   => Controls_Manager::COLOR,
				'scheme' => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				),
				'selectors' => array(
					'{{WRAPPER}} '. $css_scheme['name'] => 'color: {{VALUE}}' . ' !important',
				),
			)
		);

		$this->add_control(
			'ticker_coin_name_background_color',
			array(
				'label'  => esc_html__( 'Ticker Name Background Color', 'bitunet' ),
				'type'   => Controls_Manager::COLOR,
				'scheme' => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				),
				'selectors' => array(
					'{{WRAPPER}} '. $css_scheme['name'] => 'background-color: {{VALUE}}' . ' !important',
				),
			)
		);

		$this->add_responsive_control(
			'ticker_coin_name_align',
			array(
				'label'   => esc_html__( 'Alignment', 'bitunet' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => false,
				'options' => array(
					'left'    => array(
						'title' => esc_html__( 'Left', 'bitunet' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'bitunet' ),
						'icon'  => 'fa fa-align-center',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'bitunet' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['name'] => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'ticker_coin_name_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} ' . $css_scheme['name'],

			)
		);

		$this->add_responsive_control(
			'ticker_coin_name_padding',
			array(
				'label'      => esc_html__( 'Padding', 'bitunet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['name'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'ticker_coin_name_margin',
			array(
				'label'      => esc_html__( 'Margin', 'bitunet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['name'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'ticker_coin_name_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'bitunet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['name'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'section_ticker_price_control_style',
			array(
				'label'      => esc_html__( 'Coin Price Styles', 'bitunet' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_responsive_control(
			'ticker_coin_price_width',
			array(
				'label'      => esc_html__( 'Ticker coin price width', 'bitunet' ),
				'label_block' => true,
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%' ),
				'range'      => array(
					'%' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price'] => 'max-width: {{SIZE}}%; flex: 0 1 {{SIZE}}%;',
				),
			)
		);

		$this->add_control(
			'ticker_coin_price_color',
			array(
				'label'  => esc_html__( 'Ticker Price Text Color', 'bitunet' ),
				'type'   => Controls_Manager::COLOR,
				'scheme' => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				),
				'selectors' => array(
					'{{WRAPPER}} '. $css_scheme['price'] => 'color: {{VALUE}}' . ' !important',
				),
			)
		);

		$this->add_control(
			'ticker_coin_price_background_color',
			array(
				'label'  => esc_html__( 'Ticker Price Background Color', 'bitunet' ),
				'type'   => Controls_Manager::COLOR,
				'scheme' => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				),
				'selectors' => array(
					'{{WRAPPER}} '. $css_scheme['price'] => 'background-color: {{VALUE}}' . ' !important',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'ticker_coin_price_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} ' . $css_scheme['price'],

			)
		);

		$this->add_responsive_control(
			'tikcer_coin_price_align',
			array(
				'label'   => esc_html__( 'Alignment', 'bitunet' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => false,
				'options' => array(
					'left'    => array(
						'title' => esc_html__( 'Left', 'bitunet' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'bitunet' ),
						'icon'  => 'fa fa-align-center',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'bitunet' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['price'] => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'ticker_coin_price_padding',
			array(
				'label'      => esc_html__( 'Padding', 'bitunet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['price'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'ticker_coin_price_margin',
			array(
				'label'      => esc_html__( 'Margin', 'bitunet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['price'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'ticker_coin_price_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'bitunet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['price'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'section_ticker_changes_control_style',
			array(
				'label'      => esc_html__( 'Coin Changes Styles', 'bitunet' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_responsive_control(
			'ticker_coin_changes_width',
			array(
				'label'      => esc_html__( 'Ticker coin changes width', 'bitunet' ),
				'label_block' => true,
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%' ),
				'range'      => array(
					'%' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['changes'] => 'max-width: {{SIZE}}%; flex: 0 1 {{SIZE}}%;',
				),
			)
		);


		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'ticker_coin_changes_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} ' . $css_scheme['changes'],
			)
		);

		$this->add_responsive_control(
			'tikcer_coin_changes_align',
			array(
				'label'   => esc_html__( 'Alignment', 'bitunet' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => false,
				'options' => array(
					'left'    => array(
						'title' => esc_html__( 'Left', 'bitunet' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'bitunet' ),
						'icon'  => 'fa fa-align-center',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'bitunet' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['changes'] => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'ticker_coin_changes_padding',
			array(
				'label'      => esc_html__( 'Padding', 'bitunet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['changes'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'ticker_coin_changes_margin',
			array(
				'label'      => esc_html__( 'Margin', 'bitunet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['changes'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'ticker_coin_changes_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'bitunet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['changes'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'section_ticker_changes_states_control_style',
			array(
				'label'     => esc_html__( 'State Styles', 'bitunet' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->start_controls_tabs( 'section_ticker_changes_states_tabs' );

		$this->start_controls_tab(
			'section_ticker_up_state_tab', array(
				'label' => esc_html__('Up State' , 'bitunet' ),
			)
		);
		$this->add_control(
			'ticker_coin_up_changes_color',
			array(
				'label'  => esc_html__( 'Ticker Up Changes Text Color', 'bitunet' ),
				'type'   => Controls_Manager::COLOR,
				'scheme' => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				),
				'selectors' => array(
					'{{WRAPPER}} '. $css_scheme['changes'] . $css_scheme['changes-up']  => 'color: {{VALUE}}' . ' !important',
				),
			)
		);

		$this->add_control(
			'ticker_coin_up_changes_background_color',
			array(
				'label'  => esc_html__( 'Ticker Change Up Background Color', 'bitunet' ),
				'type'   => Controls_Manager::COLOR,
				'scheme' => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				),
				'selectors' => array(
					'{{WRAPPER}} '. $css_scheme['changes'] . $css_scheme['changes-up'] => 'background-color: {{VALUE}}' . ' !important',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'section_ticker_down_state_tab', array(
				'label' => esc_html__('Down State' , 'bitunet' ),
			)
		);

		$this->add_control(
			'ticker_coin_down_changes_color',
			array(
				'label'  => esc_html__( 'Ticker Down Changes Text Color', 'bitunet' ),
				'type'   => Controls_Manager::COLOR,
				'scheme' => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				),
				'selectors' => array(
					'{{WRAPPER}} '. $css_scheme['changes'] . $css_scheme['changes-down'] => 'color: {{VALUE}}' . ' !important',
				),
			)
		);

		$this->add_control(
			'ticker_coin_down_changes_background_color',
			array(
				'label'  => esc_html__( 'Ticker Change Down Background Color', 'bitunet' ),
				'type'   => Controls_Manager::COLOR,
				'scheme' => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				),
				'selectors' => array(
					'{{WRAPPER}} '. $css_scheme['changes'] . $css_scheme['changes-down'] => 'background-color: {{VALUE}}' . ' !important',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_ticker_ordering',
			array(
				'label'      => esc_html__( 'Ordering', 'bitunet' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'ticker_coin_icon_order',
			array(
				'label'   => esc_html__( 'Coin Icon Order', 'bitunet' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 1,
				'min'     => 1,
				'max'     => 4,
				'step'    => 1,
				'selectors' => array(
					'{{WRAPPER}} '. $css_scheme['icon'] => 'order: {{VALUE}};',
				),
			)
		);


		$this->add_control(
			'ticker_coin_name_order',
			array(
				'label'   => esc_html__( 'Coin Name Order', 'bitunet' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 2,
				'min'     => 1,
				'max'     => 4,
				'step'    => 1,
				'selectors' => array(
					'{{WRAPPER}} '. $css_scheme['name'] => 'order: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'ticker_coin_price_order',
			array(
				'label'   => esc_html__( 'Coin Price Order', 'bitunet' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 3,
				'min'     => 1,
				'max'     => 4,
				'step'    => 1,
				'selectors' => array(
					'{{WRAPPER}} '. $css_scheme['price'] => 'order: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'ticker_coin_changes_order',
			array(
				'label'   => esc_html__( 'Coin Changes Order', 'bitunet' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 4,
				'min'     => 1,
				'max'     => 4,
				'step'    => 1,
				'selectors' => array(
					'{{WRAPPER}} '. $css_scheme['changes'] => 'order: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
	}


	protected function render() {

		$settings = $this->get_settings();

		$this->__context = 'render';

		$this->get_ccpw_posts();

		echo do_shortcode( '[ccpw id="'. $settings['post_id'] . '"]' );

	}

	public function empty_ccpw_post_message() {
		return '<div id="elementor-widget-template-empty-templates">
				<div class="elementor-widget-template-empty-templates-icon"><i class="eicon-nerd"></i></div>
				<div class="elementor-widget-template-empty-templates-title">' . esc_html__( 'You Haven’t Any Crypto Currency Shortcode.', 'bitunet' ) . '</div>
				<div class="elementor-widget-template-empty-templates-footer"><a class="elementor-widget-template-empty-templates-footer-url" href="' . admin_url() . 'edit.php?post_type=ccpw' . ' " target="_blank" /a>' . esc_html__('Create New One','bitunet') . '</div>
				</div>';
	}


	protected function get_ccpw_posts(){
		$posts_ids = array();

		$args = array(
			'orderby'     => 'date',
			'order'       => 'DESC',
			'post_type'   => 'ccpw',
		);

		$posts = get_posts( $args );

		foreach($posts as $post){
			$posts_ids[$post->ID] = $post->post_title;
		}
		return $posts_ids;
	}

}