<?php
/**
 * Class description
 *
 * @package   package_name
 * @author    Cherry Team
 * @license   GPL-2.0+
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Jet_Woo_Builder_Documents' ) ) {

	/**
	 * Define Jet_Woo_Builder_Documents class
	 */
	class Jet_Woo_Builder_Documents {

		protected $current_type = null;

		/**
		 * Constructor for the class
		 */
		function __construct() {

			add_action( 'elementor/documents/register', array( $this, 'register_elementor_document_types' ) );

			if ( ! class_exists( 'Jet_Theme_Core' ) && ! class_exists( 'Jet_Engine' ) ) {
				add_action( 'elementor/dynamic_tags/before_render', array( $this, 'switch_to_preview_query' ) );
				add_action( 'elementor/dynamic_tags/after_render', array( $this, 'restore_current_query' ) );
			}

			add_filter( 'admin_body_class', array( $this, 'set_admin_body_class' ) );

		}

		/**
		 * Set admin body classes
		 *
		 * @param $classes
		 *
		 * @return string
		 */
		function set_admin_body_class( $classes ) {

			if ( is_admin() ) {
				$document  = Elementor\Plugin::instance()->documents->get( get_the_ID() );

				if ( $document ){
					$classes .= ' ' . $document->get_name() . '-document';
				}
			}

			return $classes;

		}

		/**
		 * Set currently processed document type
		 *
		 * @param [type] $type [description]
		 */
		public function set_current_type( $type ) {
			$this->current_type = $type;
		}

		/**
		 * Get currently processed document type
		 *
		 * @param [type] $type [description]
		 */
		public function get_current_type() {
			return $this->current_type;
		}

		/**
		 * Switch to specific preview query
		 *
		 * @return void
		 */
		public function switch_to_preview_query() {

			$current_post_id = get_the_ID();
			$document        = Elementor\Plugin::instance()->documents->get_doc_or_auto_save( $current_post_id );

			if ( ! is_object( $document ) || ! method_exists( $document, 'get_preview_as_query_args' ) ) {
				return;
			}

			$new_query_vars = $document->get_preview_as_query_args();

			if ( empty( $new_query_vars ) ) {
				return;
			}

			Elementor\Plugin::instance()->db->switch_to_query( $new_query_vars );

		}

		/**
		 * Restore default query
		 *
		 * @return void
		 */
		public function restore_current_query() {
			Elementor\Plugin::instance()->db->restore_current_query();
		}

		/**
		 * Get registered document types
		 *
		 * @return [type] [description]
		 */
		public function get_document_types() {

			return array(
				'single'   => array(
					'slug'  => jet_woo_builder_post_type()->slug(),
					'name'  => __( 'Single', 'jet-woo-builder' ),
					'file'  => 'includes/documents/class-jet-woo-builder-document.php',
					'class' => 'Jet_Woo_Builder_Document',
				),
				'archive'  => array(
					'slug'  => jet_woo_builder_post_type()->slug() . '-archive',
					'name'  => __( 'Archive', 'jet-woo-builder' ),
					'file'  => 'includes/documents/class-jet-woo-builder-archive-document.php',
					'class' => 'Jet_Woo_Builder_Archive_Document',
				),
				'category' => array(
					'slug'  => jet_woo_builder_post_type()->slug() . '-category',
					'name'  => __( 'Category', 'jet-woo-builder' ),
					'file'  => 'includes/documents/class-jet-woo-builder-category-document.php',
					'class' => 'Jet_Woo_Builder_Category_Document',
				),
				'shop'     => array(
					'slug'  => jet_woo_builder_post_type()->slug() . '-shop',
					'name'  => __( 'Shop', 'jet-woo-builder' ),
					'file'  => 'includes/documents/class-jet-woo-builder-shop-document.php',
					'class' => 'Jet_Woo_Builder_Shop_Document',
				),
			);

		}

		/**
		 * Register apropriate document types for 'jet-woo-builder' post type
		 *
		 * @param  Elementor\Core\Documents_Manager $documents_manager [description]
		 *
		 * @return void
		 */
		public function register_elementor_document_types( $documents_manager ) {

			$document_types = $this->get_document_types();

			foreach ( $document_types as $type => $data ) {
				require jet_woo_builder()->plugin_path( $data['file'] );
				$documents_manager->register_document_type( $data['slug'], $data['class'] );
			}

		}

	}

}
