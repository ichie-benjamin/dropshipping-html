<?php
/**
 * Elementor compatibility.
 *
 * @package Bitunet
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Bitunet_Elementor' ) ) {

	/**
	 * Define Bitunet_Elementor class
	 */
	class Bitunet_Elementor {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @var   object
		 */
		private static $instance = null;

		/**
		 * Elementor addons directory inside theme
		 *
		 * @var string
		 */
		public $addons_dir = '/elementor-addons';

		/**
		 * Constructor for the class
		 */
		public function __construct() {

			if ( ! $this->has_elementor() ) {
				return;
			}

			add_filter( 'cherry_ui_add_data_to_element',          array( $this, 'is_elementor_widget' ) );

			$addons = $this->get_theme_addons();

			if ( ! empty( $addons ) ) {
				add_action( 'elementor/init',                           array( $this, 'register_theme_category' ) );
				add_action( 'elementor/widgets/widgets_registered',     array( $this, 'register_theme_addons' ), 10 );
			}

		}

		/**
		 * Check if elementor installed
		 *
		 * @return boolean
		 */
		public function has_elementor() {
			return defined( 'ELEMENTOR_VERSION' );
		}

		/**
		 * Register category for theme addons
		 *
		 * @return void
		 */
		public function register_theme_category() {

			$template         = get_template();
			$theme_obj        = wp_get_theme( $template );
			$elements_manager = Elementor\Plugin::instance()->elements_manager;
			$cat_slug         = $theme_obj->get( 'TextDomain' );
			$cat_name         = $theme_obj->get( 'Name' );

			$elements_manager->add_category(
				$cat_slug,
				array(
					'title' => $cat_name,
					'icon'  => 'font',
				),
				1
			);

		}

		/**
		 * Register plugin addons
		 *
		 * @param  object $widgets_manager Elementor widgets manager instance.
		 * @return void
		 */
		public function register_theme_addons( $widgets_manager ) {

			$addons = $this->get_theme_addons();


			foreach ( $addons as $file ) {
				$this->register_addon( $file, $widgets_manager );
			}

		}

		/**
		 * Register addon by file name
		 *
		 * @param  string $file            File name.
		 * @param  object $widgets_manager Widgets manager instance.
		 * @return void
		 */
		public function register_addon( $file, $widgets_manager ) {

			$base  = basename( str_replace( '.php', '', $file ) );
			$class = ucwords( str_replace( '-', ' ', $base ) );
			$class = str_replace( ' ', '_', $class );
			$class = sprintf( 'Elementor\Bitunet_%s', $class );

			require $file;


			if ( class_exists( $class ) ) {
				$widgets_manager->register_widget_type( new $class );
			}
		}

		/**
		 * Returns theme addons list
		 *
		 * @return array
		 */
		public function get_theme_addons() {
			return glob( get_stylesheet_directory() . $this->addons_dir . '/*.php' );
		}

		/**
		 * Set $add_js_to_response into true if is elementor widget request.
		 *
		 * @param  boolean $add_js_to_response
		 * @return boolean
		 */
		public function is_elementor_widget( $add_js_to_response ) {

			if ( isset( $_REQUEST['action'] ) && 'elementor_editor_get_wp_widget_form' === $_REQUEST['action'] ) {
				return true;
			} else {
				return $add_js_to_response;
			}

		}


		/**
		 * Returns JS for elementor-edit.js data
		 *
		 * @return array
		 */
		public function get_data() {

			return array(
				'widgets' => $this->get_widgets(),
			);

		}

		/**
		 * Save widgets list into js variable
		 */
		public function get_widgets() {

			global $wp_widget_factory;

			if ( empty( $wp_widget_factory->widgets ) ) {
				return array();
			}

			$result = array();

			foreach ( $wp_widget_factory->widgets as $widget ) {

				if ( ! isset( $widget->widget_id ) ) {
					continue;
				}

				if ( false === strpos( $widget->widget_id, 'bitunet' ) ) {
					continue;
				}

				$result[] = $widget->widget_id;
			}

			return $result;
		}


		/**
		 * Returns the instance.
		 *
		 * @since  1.0.0
		 * @return object
		 */
		public static function get_instance() {

			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self;
			}
			return self::$instance;
		}
	}

}

/**
 * Returns instance of Bitunet_Elementor
 *
 * @return object
 */
function bitunet_elementor() {
	return Bitunet_Elementor::get_instance();
}

bitunet_elementor();
