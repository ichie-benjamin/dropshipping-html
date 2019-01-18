<?php
/**
 * Class: Jet_Woo_Builder_Single_Tabs
 * Name: Single Tabs
 * Slug: jet-single-tabs
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

class Jet_Woo_Builder_Single_Tabs extends Jet_Woo_Builder_Base {

	public function get_name() {
		return 'jet-single-tabs';
	}

	public function get_title() {
		return esc_html__( 'Single Tabs', 'jet-woo-builder' );
	}

	public function get_icon() {
		return 'jetwoobuilder-icon-23';
	}

	public function get_script_depends() {
		return array( 'wc-single-product' );
	}

	public function get_categories() {
		return array( 'jet-woo-builder' );
	}

	protected function _register_controls() {

		$css_scheme = apply_filters(
			'jet-woo-builder/jet-single-tabs/tabs/css-scheme',
			array(
				'control_wrapper'  => '.jet-woo-builder > .jet-single-tabs__wrap ul.wc-tabs',
				'content_wrapper'  => '.jet-woo-builder > .jet-single-tabs__wrap .wc-tab',
				'tabs_list_item'   => '.jet-woo-builder > .jet-single-tabs__wrap .tabs > li',
				'tabs_item'        => '.jet-woo-builder > .jet-single-tabs__wrap .tabs > li > a',
				'tabs_item_active' => '.jet-woo-builder > .jet-single-tabs__wrap .tabs > li.active > a',
			)
		);

		$this->start_controls_section(
			'section_single_tabs_style',
			array(
				'label' => esc_html__( 'General', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'single_tabs_position',
			array(
				'label'        => esc_html__( 'Tabs Position', 'jet-woo-builder' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'top',
				'prefix_class' => 'elementor-tabs-view-',
				'options'      => array(
					'left'  => esc_html__( 'Left', 'jet-woo-builder' ),
					'top'   => esc_html__( 'Top', 'jet-woo-builder' ),
					'right' => esc_html__( 'Right', 'jet-woo-builder' ),
				),
			)
		);

		$this->add_control(
			'single_tabs_items_display',
			array(
				'label'     => esc_html__( 'Tabs Items Display', 'jet-woo-builder' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'row',
				'options'   => array(
					'row'    => esc_html__( 'Inline', 'jet-woo-builder' ),
					'column' => esc_html__( 'Block', 'jet-woo-builder' ),
				),
				'condition' => array(
					'single_tabs_position' => 'top',
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['control_wrapper'] => 'flex-direction: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'single_tabs_control_wrapper_width',
			array(
				'label'      => esc_html__( 'Tabs Control Width', 'jet-woo-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
					'%',
				),
				'range'      => array(
					'%'  => array(
						'min' => 10,
						'max' => 50,
					),
					'px' => array(
						'min' => 100,
						'max' => 500,
					),
				),
				'condition'  => array(
					'single_tabs_position' => array( 'left', 'right' ),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['control_wrapper'] => 'width: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} ' . $css_scheme['content_wrapper'] => 'width: calc(100% - {{SIZE}}{{UNIT}})',
				),
			)
		);

		$this->add_responsive_control(
			'single_tabs_controls_alignment',
			array(
				'label'        => esc_html__( 'Tabs Alignment', 'jet-woo-builder' ),
				'type'         => Controls_Manager::CHOOSE,
				'default'      => 'left',
				'options'      => array(
					'left'    => array(
						'title' => esc_html__( 'Left', 'jet-woo-builder' ),
						'icon'  => 'fa fa-arrow-left',
					),
					'center'  => array(
						'title' => esc_html__( 'Center', 'jet-woo-builder' ),
						'icon'  => 'fa fa-align-center',
					),
					'stretch' => array(
						'title' => esc_html__( 'Stretch', 'jet-woo-builder' ),
						'icon'  => 'fa fa-align-justify',
					),
					'right'   => array(
						'title' => esc_html__( 'Right', 'jet-woo-builder' ),
						'icon'  => 'fa fa-arrow-right',
					),
				),
				'prefix_class' => 'elementor-tabs-controls-',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_single_tabs_control_style',
			array(
				'label' => esc_html__( 'Tabs Nav', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'single_tabs_control_background',
				'selector' => '{{WRAPPER}} ' . $css_scheme['control_wrapper'],
			)
		);

		$this->add_responsive_control(
			'single_tabs_control_padding',
			array(
				'label'      => __( 'Padding', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['control_wrapper'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'single_tabs_control_border',
				'label'       => esc_html__( 'Border', 'jet-woo-builder' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['control_wrapper'],
			)
		);

		$this->add_responsive_control(
			'single_tabs_control_border_radius',
			array(
				'label'      => __( 'Border Radius', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['control_wrapper'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_single_tabs_item_style',
			array(
				'label' => esc_html__( 'Tabs Nav Item', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'single_tabs_item_width',
			array(
				'label'      => esc_html__( 'Tabs Item Width', 'jet-woo-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
					'%',
				),
				'range'      => array(
					'%'  => array(
						'min' => 10,
						'max' => 100,
					),
					'px' => array(
						'min' => 100,
						'max' => 500,
					),
				),
				'condition'  => array(
					'single_tabs_position'      => 'top',
					'single_tabs_items_display' => 'column',
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['tabs_list_item'] => 'max-width: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'single_tabs_item_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} ' . $css_scheme['tabs_item'],
			)
		);

		$this->add_responsive_control(
			'single_tabs_item_alignment',
			array(
				'label'     => esc_html__( 'Item Text Alignment', 'jet-woo-builder' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'left',
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'jet-woo-builder' ),
						'icon'  => 'fa fa-arrow-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'jet-woo-builder' ),
						'icon'  => 'fa fa-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'jet-woo-builder' ),
						'icon'  => 'fa fa-arrow-right',
					),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['tabs_item'] => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'single_tabs_item_padding',
			array(
				'label'      => __( 'Padding', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['tabs_item'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'single_tabs_item_margin',
			array(
				'label'      => __( 'Margin', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['tabs_item'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'single_tabs_item_border',
				'label'       => esc_html__( 'Border', 'jet-woo-builder' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['tabs_item'],
			)
		);

		$this->add_responsive_control(
			'single_tabs_item_border_radius',
			array(
				'label'      => __( 'Border Radius', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['tabs_item'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs( 'single_tabs_item_styles' );

		$this->start_controls_tab(
			'single_tabs_item_normal',
			array(
				'label' => esc_html__( 'Normal', 'jet-woo-builder' ),
			)
		);

		$this->add_control(
			'single_tabs_item_color_normal',
			array(
				'label'     => esc_html__( 'Text Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['tabs_item'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'single_tabs_item_background_normal',
			array(
				'label'     => esc_html__( 'Background', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['tabs_item'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'single_tabs_item_box_shadow_normal',
				'selector' => '{{WRAPPER}} ' . $css_scheme['tabs_item'],
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'single_tabs_item_hover',
			array(
				'label' => esc_html__( 'Hover', 'jet-woo-builder' ),
			)
		);

		$this->add_control(
			'single_tabs_item_color_hover',
			array(
				'label'     => esc_html__( 'Text Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['tabs_item'] . ':hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'single_tabs_item_background_hover',
			array(
				'label'     => esc_html__( 'Background', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['tabs_item'] . ':hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'single_tabs_item_border_color_hover',
			array(
				'label'     => esc_html__( 'Border Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['tabs_item'] . ':hover' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'single_tabs_item_decoration_hover',
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
					'{{WRAPPER}} ' . $css_scheme['tabs_item'] . ':hover' => 'text-decoration: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'single_tabs_item_box_shadow_hover',
				'selector' => '{{WRAPPER}} ' . $css_scheme['tabs_item'] . ':hover',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'single_tabs_item_active',
			array(
				'label' => esc_html__( 'Active', 'jet-woo-builder' ),
			)
		);

		$this->add_control(
			'single_tabs_item_color_active',
			array(
				'label'     => esc_html__( 'Text Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['tabs_item_active'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'single_tabs_item_background_active',
			array(
				'label'     => esc_html__( 'Background', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['tabs_item_active'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'single_tabs_item_border_color_active',
			array(
				'label'     => esc_html__( 'Border Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['tabs_item_active'] => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'single_tabs_item_decoration_active',
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
					'{{WRAPPER}} ' . $css_scheme['tabs_item_active'] => 'text-decoration: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'single_tabs_item_box_shadow_active',
				'selector' => '{{WRAPPER}} ' . $css_scheme['tabs_item_active'],
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_single_tabs_content_style',
			array(
				'label' => esc_html__( 'Tabs Content', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'single_tabs_content_background',
				'selector' => '{{WRAPPER}} ' . $css_scheme['content_wrapper'],
			)
		);

		$this->add_responsive_control(
			'single_tabs_content_padding',
			array(
				'label'      => __( 'Padding', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['content_wrapper'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'single_tabs_content_border',
				'label'       => esc_html__( 'Border', 'jet-woo-builder' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['content_wrapper'],
			)
		);

		$this->add_responsive_control(
			'single_tabs_content_radius',
			array(
				'label'      => __( 'Border Radius', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['content_wrapper'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

	}

	protected function render() {

		$this->__context = 'render';

		if ( true === $this->__set_editor_product() ) {
			$this->__open_wrap();

			$this->fix_comments_template();

			include $this->__get_global_template( 'index' );
			$this->__close_wrap();
			$this->__reset_editor_product();
		}

	}

	public function fix_comments_template() {

		if ( ! jet_woo_builder_integration()->in_elementor() && ! wp_doing_ajax() ) {
			return;
		}

		add_filter( 'comments_template', array( $this, 'comments_template_loader' ) );

	}

	/**
	 * Load comments template
	 *
	 * @return string
	 */
	public function comments_template_loader( $template ) {

		$check_dirs = array(
			trailingslashit( get_stylesheet_directory() ) . WC()->template_path(),
			trailingslashit( get_template_directory() ) . WC()->template_path(),
			trailingslashit( get_stylesheet_directory() ),
			trailingslashit( get_template_directory() ),
			trailingslashit( WC()->plugin_path() ) . 'templates/',
		);

		if ( WC_TEMPLATE_DEBUG_MODE ) {
			$check_dirs = array( array_pop( $check_dirs ) );
		}

		foreach ( $check_dirs as $dir ) {
			if ( file_exists( trailingslashit( $dir ) . 'single-product-reviews.php' ) ) {
				return trailingslashit( $dir ) . 'single-product-reviews.php';
			}
		}
	}

}
