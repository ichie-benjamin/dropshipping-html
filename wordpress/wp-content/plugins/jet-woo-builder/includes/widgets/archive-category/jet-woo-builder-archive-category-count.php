<?php
/**
 * Class: Jet_Woo_Builder_Archive_Category_Count
 * Name: Count
 * Slug: jet-woo-builder-archive-category-count
 */

namespace Elementor;

use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class Jet_Woo_Builder_Archive_Category_Count extends Widget_Base {

	private $source = false;

	public function get_name() {
		return 'jet-woo-builder-archive-category-count';
	}

	public function get_title() {
		return esc_html__( 'Count', 'jet-woo-builder' );
	}

	public function get_icon() {
		return 'jetwoobuilder-icon-36';
	}

	public function get_categories() {
		return array( 'jet-woo-builder' );
	}

	protected function _register_controls() {

		$css_scheme = apply_filters(
			'jet-woo-builder/jet-archive-category-count/css-scheme',
			array(
				'count' => '.jet-woo-builder-archive-category-count'
			)
		);

		$this->start_controls_section(
			'section_general',
			array(
				'label' => __( 'Content', 'jet-woo-builder' ),
			)
		);

		$this->add_control(
			'archive_category_count_before_text',
			array(
				'label'     => esc_html__( 'Count Before Text', 'jet-woo-builder' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '(',
			)
		);

		$this->add_control(
			'archive_category_count_after_text',
			array(
				'label'     => esc_html__( 'Count After Text', 'jet-woo-builder' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => ')',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_archive_category_count_style',
			array(
				'label'      => esc_html__( 'Count', 'jet-woo-builder' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'archive_category_count_display',
			array(
				'label'   => esc_html__( 'Count Position', 'jet-woo-builder' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'block',
				'options' => array(
					'block'    => esc_html__( 'Block', 'jet-woo-builder' ),
					'inline-block' => esc_html__( 'Inline', 'jet-woo-builder' ),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['count'] => 'display: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'archive_category_count_typography',
				'selector' => '{{WRAPPER}} ' . $css_scheme['count'],
			)
		);

		$this->add_control(
			'archive_category_count_color',
			array(
				'label'     => esc_html__( 'Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['count'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'archive_category_count_bg',
			array(
				'label' => esc_html__( 'Background Color', 'jet-woo-builder' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['count'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'archive_category_count_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['count'],
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'archive_category_count_border',
				'label'       => esc_html__( 'Border', 'jet-woo-builder' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['count'],
			)
		);

		$this->add_control(
			'archive_category_count_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['count'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;',
				),
			)
		);

		$this->add_responsive_control(
			'archive_category_count_padding',
			array(
				'label'      => esc_html__( 'Padding', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['count'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'archive_category_count_margin',
			array(
				'label'      => esc_html__( 'Margin', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['count'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'archive_category_count_alignment',
			array(
				'label'     => esc_html__( 'Alignment', 'jet-woo-builder' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'left',
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'jet-woo-builder' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'jet-woo-builder' ),
						'icon'  => 'fa fa-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'jet-woo-builder' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors' => array(
					'{{WRAPPER}} ' => 'text-align: {{VALUE}};',
					'{{WRAPPER}} ' . $css_scheme['count'] => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

	}

	/**
	 * Returns CSS selector for nested element
	 *
	 * @param  [type] $el [description]
	 *
	 * @return [type]     [description]
	 */
	public function css_selector( $el = null ) {
		return sprintf( '{{WRAPPER}} .%1$s %2$s', $this->get_name(), $el );
	}

	public static function render_callback( $settings = array(), $args ) {

		$category = ! empty( $args ) ? $args['category'] : get_queried_object();

		$count  = $category->count;
		$before = $settings['count_before_text'];
		$after  = $settings['count_after_text'];

		echo '<div class="jet-woo-builder-archive-category-count">';
		echo sprintf( '<span class="jet-woo-category-count">%2$s%1$s%3$s</span>', $count, $before, $after );
		echo '</div>';

	}

	protected function render() {

		$settings = $this->get_settings();

		$macros_settings = array(
			'count_before_text' => $settings['archive_category_count_before_text'],
			'count_after_text' => $settings['archive_category_count_after_text'],
		);

		if ( jet_woo_builder_tools()->is_builder_content_save() ) {
			echo jet_woo_builder()->parser->get_macros_string( $this->get_name(), $macros_settings );
		} else {
			echo self::render_callback(
				$macros_settings,
				jet_woo_builder_integration_woocommerce()->get_current_args()
			);
		}

	}

}
