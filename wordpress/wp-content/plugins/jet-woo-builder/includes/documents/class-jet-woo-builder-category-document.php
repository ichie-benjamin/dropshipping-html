<?php

use Elementor\Controls_Manager;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Jet_Woo_Builder_Category_Document extends Elementor\Core\Base\Document {

	public $first_category = null;

	/**
	 * @access public
	 */
	public function get_name() {
		return 'jet-woo-builder-category';
	}

	/**
	 * @access public
	 * @static
	 */
	public static function get_title() {
		return __( 'Jet Woo Category Template', 'jet-woo-builder' );
	}

	protected function _register_controls() {

		parent::_register_controls();

		$this->start_controls_section(
			'section_template_category_settings',
			array(
				'label'      => esc_html__( 'Template Settings', 'jet-woo-builder' ),
				'tab'        => Controls_Manager::TAB_SETTINGS,
				'show_label' => false,
			)
		);

		$this->add_control(
			'use_custom_template_category_columns',
			array(
				'label'        => esc_html__( 'Use custom columns count', 'jet-woo-builder' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'jet-woo-builder' ),
				'label_off'    => esc_html__( 'No', 'jet-woo-builder' ),
				'return_value' => 'yes',
				'default'      => '',
			)
		);

		$this->add_responsive_control(
			'template_category_columns_count',
			array(
				'label'           => esc_html__( 'Template Columns', 'jet-woo-builder' ),
				'type'            => Controls_Manager::NUMBER,
				'desktop_default' => 4,
				'tablet_default'  => 3,
				'mobile_default'  => 2,
				'min'             => 1,
				'max'             => 6,
				'step'            => 1,
				'condition'       => array(
					'use_custom_template_category_columns' => 'yes'
				)
			)
		);

		$this->add_responsive_control(
			'template_category_columns_horizontal_gutter',
			array(
				'label'      => esc_html__( 'Template Columns Horizontal Gutter (px)', 'jet-woo-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
				),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'    => array(
					'size' => 10,
					'unit' => 'px',
				),
				'selectors'  => array(
					'.woocommerce {{WRAPPER}} ' . '.products.jet-woo-builder-categories--columns .product.product-category' => 'padding-left: calc({{SIZE}}{{UNIT}}/2); padding-right: calc({{SIZE}}{{UNIT}}/2);',
					'.woocommerce {{WRAPPER}} ' . '.products.jet-woo-builder-categories--columns'                         => 'margin-left: calc(-{{SIZE}}{{UNIT}}/2); margin-right: calc(-{{SIZE}}{{UNIT}}/2);',
				),
				'condition'  => array(
					'use_custom_template_category_columns' => 'yes'
				)
			)
		);

		$this->add_responsive_control(
			'template_category_columns_vertical_gutter',
			array(
				'label'      => esc_html__( 'Template Columns Vertical Gutter (px)', 'jet-woo-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
				),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'    => array(
					'size' => 10,
					'unit' => 'px',
				),
				'selectors'  => array(
					'.woocommerce ' . '.products.jet-woo-builder-categories--columns .product.product-category' => 'margin-bottom: {{SIZE}}{{UNIT}}!important;',
				),
				'condition'  => array(
					'use_custom_template_category_columns' => 'yes'
				)
			)
		);

		$this->end_controls_section();

	}

	/**
	 * @since 2.0.0
	 * @access public
	 *
	 * @param $data
	 *
	 * @return bool
	 */
	public function save( $data ) {
		if ( ! $this->is_editable_by_current_user() ) {
			return false;
		}

		if ( Elementor\DB::STATUS_AUTOSAVE === $data['settings']['post_status'] ) {
			if ( ! defined( 'DOING_AUTOSAVE' ) ) {
				define( 'DOING_AUTOSAVE', true );
			}
		}

		if ( ! empty( $data['settings'] ) ) {
			$this->save_settings( $data['settings'] );
		}

		// Refresh post after save settings.
		$this->post = get_post( $this->post->ID );

		// TODO: refresh settings.
		$this->save_elements( $data['elements'] );

		$this->save_template_item_to_meta( $this->post->ID );

		// Update Post CSS
		$post_css = new Elementor\Core\Files\CSS\Post( $this->post->ID );
		$post_css->update();

		return true;
	}

	/**
	 * Query for first product ID.
	 *
	 * @return int|bool
	 */
	public function query_first_category() {

		if ( null !== $this->first_category ) {
			return $this->first_category;
		}

		$product_categories = get_categories( array(
			'taxonomy'     => 'product_cat',
			'orderby'      => 'name',
			'pad_counts'   => false,
			'hierarchical' => 1,
			'hide_empty'   => false
		) );


		if ( ! empty( $product_categories ) ) {
			$product_category = $product_categories[0];
		}


		return $this->first_category = $product_category->term_id;

	}

	/**
	 * @access public
	 */
	public function get_wp_preview_url() {

		$main_post_id = $this->get_main_id();

		$product_category = $this->query_first_category();

		return add_query_arg(
			array(
				'preview_nonce'    => wp_create_nonce( 'post_preview_' . $main_post_id ),
				'jet_woo_template' => $main_post_id,
			),
			esc_url( get_category_link( $product_category ) )
		);

	}

	/**
	 * [save_template_item_to_meta description]
	 * @return [type] [description]
	 */
	public function save_template_item_to_meta( $post_id ) {

		$content = Elementor\Plugin::instance()->frontend->get_builder_content( $post_id, false );
		$content = preg_replace( '/<style>.*?<\/style>/', '', $content );

		update_post_meta( $post_id, '_jet_woo_builder_content', $content );
	}

	public function get_preview_as_query_args() {

		jet_woo_builder()->documents->set_current_type( $this->get_name() );

		$args = array();

		$product_category = $this->query_first_category();

		if ( ! empty( $product_category ) ) {

			$args = array(
				'posts_per_page' => - 1,
				'post_type'      => 'product',
				'tax_query'      => array(
					array(
						'taxonomy' => 'product_cat',
						'field'    => 'id',
						'terms'    => $product_category
					)
				)
			);

		}

		return $args;
	}

	/**
	 * Get elements data with new query
	 *
	 * @param  [type]  $data              [description]
	 * @param  boolean $with_html_content [description]
	 *
	 * @return [type]                     [description]
	 */
	public function get_elements_raw_data( $data = null, $with_html_content = false ) {
		jet_woo_builder()->documents->switch_to_preview_query();

		$editor_data = parent::get_elements_raw_data( $data, $with_html_content );

		jet_woo_builder()->documents->restore_current_query();

		return $editor_data;
	}

	public function render_element( $data ) {
		jet_woo_builder()->documents->switch_to_preview_query();

		$render_html = parent::render_element( $data );

		jet_woo_builder()->documents->restore_current_query();

		return $render_html;
	}

	public function get_elements_data( $status = 'publish' ) {

		if ( ! isset( $_GET[ jet_woo_builder_post_type()->slug() ] ) || ! isset( $_GET['preview'] ) ) {
			return parent::get_elements_data( $status );
		}

		jet_woo_builder()->documents->switch_to_preview_query();

		$elements = parent::get_elements_data( $status );

		jet_woo_builder()->documents->restore_current_query();

		return $elements;
	}

}