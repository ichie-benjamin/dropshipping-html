<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


class Jet_Woo_Builder_Document extends Elementor\Core\Base\Document {

	public $first_product = null;

	/**
	 * @access public
	 */
	public function get_name() {
		return 'jet-woo-builder';
	}

	/**
	 * @access public
	 * @static
	 */
	public static function get_title() {
		return __( 'Jet Woo Template', 'jet-woo-builder' );
	}

	/**
	 * @access public
	 */
	public function get_wp_preview_url() {

		$main_post_id   = $this->get_main_id();
		$sample_product = get_post_meta( $main_post_id, '_sample_product', true );

		if ( ! $sample_product ) {
			$sample_product = $this->query_first_product();
		}

		$product_id = $sample_product;

		return add_query_arg(
			array(
				'preview_nonce'    => wp_create_nonce( 'post_preview_' . $main_post_id ),
				'jet_woo_template' => $main_post_id,
			),
			get_permalink( $product_id )
		);

	}

	/**
	 * Query for first product ID.
	 *
	 * @return int|bool
	 */
	public function query_first_product() {

		if ( null !== $this->first_product ) {
			return $this->first_product;
		}

		$args = array(
			'post_type'      => 'product',
			'post_status'    => array( 'publish', 'pending', 'draft', 'future' ),
			'posts_per_page' => 1,
		);

		$sample_product = get_post_meta( $this->get_main_id(), '_sample_product', true );

		if ( $sample_product ) {
			$args['p'] = $sample_product;
		}

		$wp_query = new WP_Query( $args );

		if ( ! $wp_query->have_posts() ) {
			return false;
		}

		$post = $wp_query->posts;

		return $this->first_product = $post[0]->ID;

	}

	public function get_preview_as_query_args() {

		jet_woo_builder()->documents->set_current_type( $this->get_name() );

		$args    = array();
		$product = $this->query_first_product();

		if ( ! empty( $product ) ) {

			$args = array(
				'post_type' => 'product',
				'p'         => $product,
			);

		}

		return $args;
	}

	/**
	 * Get elements data with new query
	 *
	 * @param  [type]  $data              [description]
	 * @param  boolean $with_html_content [description]
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
