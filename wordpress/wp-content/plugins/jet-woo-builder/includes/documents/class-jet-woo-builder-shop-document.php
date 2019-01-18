<?php

use Elementor\Controls_Manager;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Jet_Woo_Builder_Shop_Document extends Elementor\Core\Base\Document {

	public $first_product = null;

	/**
	 * @access public
	 */
	public function get_name() {
		return 'jet-woo-builder-shop';
	}

	/**
	 * @access public
	 * @static
	 */
	public static function get_title() {
		return __( 'Jet Woo Shop Template', 'jet-woo-builder' );
	}

	public function get_preview_as_query_args() {

		jet_woo_builder()->documents->set_current_type( $this->get_name() );

		$args = array();

		$products = get_posts( array(
			'post_type'      => 'product',
			'posts_per_page' => 5,
		) );

		if ( ! empty( $products ) ) {

			$args = array(
				'post_type' => 'product',
				'p'         => $products,
			);

		}

		wc_set_loop_prop( 'total', 20 );
		wc_set_loop_prop( 'total_pages', 3 );

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