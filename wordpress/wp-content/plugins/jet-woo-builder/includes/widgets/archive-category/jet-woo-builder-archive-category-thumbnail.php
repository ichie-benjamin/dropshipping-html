<?php
/**
 * Class: Jet_Woo_Builder_Archive_Category_Thumbnail
 * Name: Thumbnail
 * Slug: jet-woo-builder-archive-category-thumbnail
 */

namespace Elementor;

use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class Jet_Woo_Builder_Archive_Category_Thumbnail extends Widget_Base {

	private $source = false;

	public function get_name() {
		return 'jet-woo-builder-archive-category-thumbnail';
	}

	public function get_title() {
		return esc_html__( 'Thumbnail', 'jet-woo-builder' );
	}

	public function get_icon() {
		return 'jetwoobuilder-icon-37';
	}

	public function get_categories() {
		return array( 'jet-woo-builder' );
	}

	protected function _register_controls() {

		$css_scheme = apply_filters(
			'jet-woo-builder/jet-archive-category-thumbnail/css-scheme',
			array(
				'thumbnail-wrapper' => '.jet-woo-builder-archive-category-thumbnail__wrapper',
				'thumbnail'         => '.jet-woo-builder-archive-category-thumbnail'
			)
		);

		$this->start_controls_section(
			'section_general',
			array(
				'label' => __( 'Content', 'jet-woo-builder' ),
			)
		);

		$this->add_control(
			'is_linked',
			array(
				'label'        => esc_html__( 'Add link to thumbnail', 'jet-woo-builder' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'jet-woo-builder' ),
				'label_off'    => esc_html__( 'No', 'jet-woo-builder' ),
				'return_value' => 'yes',
				'default'      => '',
			)
		);

		$this->add_control(
			'archive_category_thumbnail_size',
			array(
				'type'    => 'select',
				'label'   => esc_html__( 'Thumbnail Size', 'jet-woo-builder' ),
				'default' => 'woocommerce_thumbnail',
				'options' => jet_woo_builder_tools()->get_image_sizes(),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_archive_category_thumbnail_style',
			array(
				'label'      => esc_html__( 'Thumbnail', 'jet-woo-builder' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'archive_category_thumbnail_background_color',
			array(
				'label'     => esc_html__( 'Background Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['thumbnail'] => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'archive_category_thumbnail_border',
				'selector' => '{{WRAPPER}} ' . $css_scheme['thumbnail'],
			)
		);

		$this->add_control(
			'archive_category_thumbnail_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['thumbnail'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'archive_category_thumbnail_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['thumbnail'],
			)
		);

		$this->add_responsive_control(
			'archive_category_thumbnail_margin',
			array(
				'label'      => esc_html__( 'Margin', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['thumbnail-wrapper'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'archive_category_thumbnail_alignment',
			array(
				'label'     => esc_html__( 'Alignment', 'jet-woo-builder' ),
				'type'      => Controls_Manager::CHOOSE,
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
					'{{WRAPPER}} ' . $css_scheme['thumbnail-wrapper'] => 'text-align: {{VALUE}};',
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

		$category = !empty( $args ) ? $args['category'] : get_queried_object();

		$open_link  = '';
		$close_link = '';

		if ( isset( $settings['is_linked'] ) && 'yes' === $settings['is_linked'] ) {
			$open_link  = '<a href="' . jet_woo_builder_tools()->get_term_permalink( $category->term_id ) . '">';
			$close_link = '</a>';
		}

		echo '<div class="jet-woo-builder-archive-category-thumbnail__wrapper">';
		echo '<div class="jet-woo-builder-archive-category-thumbnail">';
		echo $open_link;
		echo jet_woo_builder_template_functions()->get_category_thumbnail(
			$category->term_id,
			$settings['archive_category_thumbnail_size']
		);
		echo $close_link;
		echo '</div>';
		echo '</div>';

	}

	protected function render() {

		$settings = $this->get_settings();

		$macros_settings = array(
			'is_linked'              => $settings['is_linked'],
			'archive_category_thumbnail_size' => $settings['archive_category_thumbnail_size'],
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

	public function add_product_classes() {
	}

}
