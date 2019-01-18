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

if ( ! class_exists( 'Jet_Woo_Builder_Integration' ) ) {

	/**
	 * Define Jet_Woo_Builder_Integration class
	 */
	class Jet_Woo_Builder_Integration {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @var   object
		 */
		private static $instance = null;

		/**
		 * Check if processing elementor widget
		 *
		 * @var boolean
		 */
		private $is_elementor_ajax = false;

		/**
		 * Holder for current product instance
		 *
		 * @var array
		 */
		private $current_product = false;

		/**
		 * Initalize integration hooks
		 *
		 * @return void
		 */
		public function init() {

			add_action( 'elementor/init', array( $this, 'register_category' ) );

			add_action( 'elementor/widgets/widgets_registered', array( $this, 'include_wc_hooks' ), 0 );
			add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_widgets' ), 10 );

			add_action( 'wp_ajax_elementor_render_widget', array( $this, 'set_elementor_ajax' ), 10, - 1 );
			add_action( 'elementor/page_templates/canvas/before_content', array( $this, 'open_canvas_wrap' ) );
			add_action( 'elementor/page_templates/canvas/after_content', array( $this, 'close_canvas_wrap' ) );

			add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'editor_styles' ) );

			add_action( 'elementor/controls/controls_registered', array( $this, 'add_controls' ), 10 );

			add_action( 'template_redirect', array( $this, 'set_track_product_view' ), 20 );

			add_filter( 'post_class', array( $this, 'add_product_post_class' ), 20 );

			$this->include_theme_integration_file();
			$this->include_plugin_integration_file();
		}

		/**
		 * Set current product data
		 */
		public function set_current_product( $product_data = array() ) {
			$this->current_product = $product_data;
		}

		/**
		 * Get current product data
		 * @return [type] [description]
		 */
		public function get_current_product() {
			return $this->current_product;
		}

		/**
		 * Get current product data
		 * @return [type] [description]
		 */
		public function reset_current_product() {
			return $this->current_product = false;
		}

		/**
		 * Enqueue editor styles
		 *
		 * @return void
		 */
		public function editor_styles() {

			wp_enqueue_style(
				'jet-woo-builder-font',
				jet_woo_builder()->plugin_url( 'assets/css/lib/jetwoobuilder-font/css/jetwoobuilder.css' ),
				array(),
				jet_woo_builder()->get_version()
			);

			wp_enqueue_style(
				'jet-woo-builder-icons-font',
				jet_woo_builder()->plugin_url( 'assets/css/lib/jet-woo-builder-icons/jet-woo-builder-icons.css' ),
				array(),
				jet_woo_builder()->get_version()
			);

			wp_enqueue_style(
				'jet-woo-builder-editor',
				jet_woo_builder()->plugin_url( 'assets/css/editor.css' ),
				array(),
				jet_woo_builder()->get_version()
			);

		}

		/**
		 * Include woocommerce front-end hooks
		 *
		 * @return [type] [description]
		 */
		public function include_wc_hooks() {

			$elementor    = Elementor\Plugin::instance();
			$is_edit_mode = $elementor->editor->is_edit_mode();

			if ( ! $is_edit_mode ) {
				return;
			}

			if ( ! defined( 'WC_ABSPATH' ) ) {
				return;
			}

			if ( ! file_exists( WC_ABSPATH . 'includes/wc-template-hooks.php' ) ) {
				return;
			}

			$rewrite = apply_filters( 'jet-woo-builder/integration/rewrite-frontend-hooks', false );

			if ( ! $rewrite ) {
				include_once WC_ABSPATH . 'includes/wc-template-hooks.php';
			}

			remove_filter( 'woocommerce_product_loop_start', 'woocommerce_maybe_show_product_subcategories' );
		}


		public function add_product_post_class( $classes ) {
			if (
				is_post_type_archive( 'product' ) ||
				'related' === wc_get_loop_prop( 'name' ) ||
				'up-sells' === wc_get_loop_prop( 'name' ) ||
				'cross-sells' === wc_get_loop_prop( 'name' )
			) {
				if ( filter_var( jet_woo_builder_settings()->get( 'enable_product_thumb_effect' ), FILTER_VALIDATE_BOOLEAN ) ) {
					$classes[] = 'jet-woo-thumb-with-effect';
				}
			}

			return $classes;
		}


		/**
		 * Track product views.
		 */
		public function set_track_product_view() {
			if ( ! is_singular( 'product' ) ) {
				return;
			}

			global $post;

			if ( empty( $_COOKIE['woocommerce_recently_viewed'] ) ) {
				$viewed_products = array();
			} else {
				$viewed_products = (array) explode( '|', $_COOKIE['woocommerce_recently_viewed'] );
			}

			if ( ! in_array( $post->ID, $viewed_products ) ) {
				$viewed_products[] = $post->ID;
			}

			if ( sizeof( $viewed_products ) > 30 ) {
				array_shift( $viewed_products );
			}

			// Store for session only
			wc_setcookie( 'woocommerce_recently_viewed', implode( '|', $viewed_products ) );
		}

		/**
		 * Include integration theme file
		 *
		 * @return void
		 */
		public function include_theme_integration_file() {

			$template = get_template();
			$int_file = jet_woo_builder()->plugin_path( "includes/integrations/themes/{$template}/functions.php" );

			if ( file_exists( $int_file ) ) {
				require $int_file;
			}

		}

		/**
		 * Include plugin integrations file
		 *
		 * @return [type] [description]
		 */
		public function include_plugin_integration_file() {

			$active_plugins = get_option( 'active_plugins' );

			foreach ( glob( jet_woo_builder()->plugin_path( 'includes/integrations/plugins/*' ) ) as $path ) {

				if ( ! is_dir( $path ) ) {
					continue;
				}

				$this->dir = basename( $path );

				$matched_plugins = array_filter( $active_plugins, array( $this, 'is_plugin_active' ) );

				if ( ! empty( $matched_plugins ) ) {
					require "{$path}/functions.php";
				}

			}

		}

		/**
		 * Open wrapper for canvas page template for product templates
		 *
		 * @return [type] [description]
		 */
		public function open_canvas_wrap() {

			if ( ! is_singular( jet_woo_builder_post_type()->slug() ) ) {
				return;
			}

			echo '<div class="product">';
		}

		/**
		 * Close wrapper for canvas page template for product templates
		 *
		 * @return [type] [description]
		 */
		public function close_canvas_wrap() {

			if ( ! is_singular( jet_woo_builder_post_type()->slug() ) ) {
				return;
			}

			echo '</div>';
		}

		/**
		 * Set $this->is_elementor_ajax to true on Elementor AJAX processing
		 *
		 * @return  void
		 */
		public function set_elementor_ajax() {
			$this->is_elementor_ajax = true;
		}

		/**
		 * Check if we currently in Elementor mode
		 *
		 * @return void
		 */
		public function in_elementor() {

			$result = false;

			if ( wp_doing_ajax() ) {
				$result = $this->is_elementor_ajax;
			} elseif ( Elementor\Plugin::instance()->editor->is_edit_mode()
			           || Elementor\Plugin::instance()->preview->is_preview_mode() ) {
				$result = true;
			}

			/**
			 * Allow to filter result before return
			 *
			 * @var bool $result
			 */
			return apply_filters( 'jet-woo-builder/in-elementor', $result );
		}

		/**
		 * Register plugin widgets
		 *
		 * @param  object $widgets_manager Elementor widgets manager instance.
		 *
		 * @return void
		 */
		public function register_widgets( $widgets_manager ) {

			$global_available_widgets           = jet_woo_builder_settings()->get( 'global_available_widgets' );
			$single_available_widgets           = jet_woo_builder_settings()->get( 'single_product_available_widgets' );
			$archive_available_widgets          = jet_woo_builder_settings()->get( 'archive_product_available_widgets' );
			$archive_category_available_widgets = jet_woo_builder_settings()->get( 'archive_category_available_widgets' );
			$shop_available_widgets             = jet_woo_builder_settings()->get( 'shop_product_available_widgets' );

			require_once jet_woo_builder()->plugin_path( 'includes/base/class-jet-woo-builder-base.php' );

			foreach ( glob( jet_woo_builder()->plugin_path( 'includes/widgets/global/' ) . '*.php' ) as $file ) {

				$slug    = basename( $file, '.php' );
				$enabled = isset( $global_available_widgets[ $slug ] ) ? $global_available_widgets[ $slug ] : '';

				if ( filter_var( $enabled, FILTER_VALIDATE_BOOLEAN ) || ! $global_available_widgets ) {
					$this->register_widget( $file, $widgets_manager );
				}
			}

			$doc_type = jet_woo_builder()->documents->get_current_type();

			if ( ! $doc_type ) {
				if ( get_post_type() === jet_woo_builder_post_type()->slug() ) {
					$doc_type = get_post_meta( get_the_ID(), '_elementor_template_type', true );
				}
			}

			$doc_type = apply_filters( 'jet-woo-builder/integration/doc-type', $doc_type );

			if ( ! $doc_type ) {
				return;
			}

			$doc_types    = jet_woo_builder()->documents->get_document_types();
			$is_edit_mode = Elementor\Plugin::instance()->editor->is_edit_mode();

			if ( $doc_types['single']['slug'] === $doc_type ) {
				foreach ( glob( jet_woo_builder()->plugin_path( 'includes/widgets/single-product/' ) . '*.php' ) as $file ) {
					$slug    = basename( $file, '.php' );
					$enabled = isset( $single_available_widgets[ $slug ] ) ? $single_available_widgets[ $slug ] : '';

					if ( filter_var( $enabled, FILTER_VALIDATE_BOOLEAN ) || ! $single_available_widgets ) {
						$this->register_widget( $file, $widgets_manager );
					}
				}
			}

			if (
				$doc_types['archive']['slug'] === $doc_type
				|| ( 'elementor' === jet_woo_builder_shop_settings()->get( 'widgets_render_method' ) && ! $is_edit_mode )
			) {

				foreach ( glob( jet_woo_builder()->plugin_path( 'includes/widgets/archive-product/' ) . '*.php' ) as $file ) {
					$slug    = basename( $file, '.php' );
					$enabled = isset( $archive_available_widgets[ $slug ] ) ? $archive_available_widgets[ $slug ] : '';

					if ( filter_var( $enabled, FILTER_VALIDATE_BOOLEAN ) || ! $archive_available_widgets ) {
						$this->register_widget( $file, $widgets_manager );
					}
				}

			}

			if ( $doc_types['shop']['slug'] === $doc_type ) {
				foreach ( glob( jet_woo_builder()->plugin_path( 'includes/widgets/shop/' ) . '*.php' ) as $file ) {
					$slug    = basename( $file, '.php' );
					$enabled = isset( $shop_available_widgets[ $slug ] ) ? $shop_available_widgets[ $slug ] : '';

					if ( filter_var( $enabled, FILTER_VALIDATE_BOOLEAN ) || ! $shop_available_widgets ) {
						$this->register_widget( $file, $widgets_manager );
					}
				}

			}

			if (
				$doc_types['category']['slug'] === $doc_type
				|| ( 'elementor' === jet_woo_builder_shop_settings()->get( 'widgets_render_method' ) && ! $is_edit_mode )
			) {
				foreach ( glob( jet_woo_builder()->plugin_path( 'includes/widgets/archive-category/' ) . '*.php' ) as $file ) {
					$slug    = basename( $file, '.php' );
					$enabled = isset( $archive_category_available_widgets[ $slug ] ) ? $archive_category_available_widgets[ $slug ] : '';

					if ( filter_var( $enabled, FILTER_VALIDATE_BOOLEAN ) || ! $archive_category_available_widgets ) {
						$this->register_widget( $file, $widgets_manager );
					}
				}

			}

		}


		/**
		 * Register addon by file name
		 *
		 * @param  string $file File name.
		 * @param  object $widgets_manager Widgets manager instance.
		 *
		 * @return void
		 */
		public function register_widget( $file, $widgets_manager ) {

			$base  = basename( str_replace( '.php', '', $file ) );
			$class = ucwords( str_replace( '-', ' ', $base ) );
			$class = str_replace( ' ', '_', $class );
			$class = sprintf( 'Elementor\%s', $class );

			require_once $file;

			if ( class_exists( $class ) ) {
				$widgets_manager->register_widget_type( new $class );
			}
		}

		/**
		 * Register cherry category for elementor if not exists
		 *
		 * @return void
		 */
		public function register_category() {

			$elements_manager    = Elementor\Plugin::instance()->elements_manager;
			$jet_woo_builder_cat = 'jet-woo-builder';

			$elements_manager->add_category(
				$jet_woo_builder_cat,
				array(
					'title' => esc_html__( 'Jet Woo Builder', 'jet-woo-builder' ),
					'icon'  => 'font',
				),
				1
			);
		}

		/**
		 * Add new controls.
		 *
		 * @param  object $controls_manager Controls manager instance.
		 *
		 * @return void
		 */
		public function add_controls( $controls_manager ) {

			$grouped = array(
				'jet-woo-box-style' => 'Jet_Woo_Group_Control_Box_Style',
			);

			foreach ( $grouped as $control_id => $class_name ) {
				if ( $this->include_control( $class_name, true ) ) {
					$controls_manager->add_group_control( $control_id, new $class_name() );
				}
			}

		}

		/**
		 * Include control file by class name.
		 *
		 * @param  [type] $class_name [description]
		 *
		 * @return [type]             [description]
		 */
		public function include_control( $class_name, $grouped = false ) {

			$filename = sprintf(
				'includes/controls/%2$sclass-%1$s.php',
				str_replace( '_', '-', strtolower( $class_name ) ),
				( true === $grouped ? 'groups/' : '' )
			);

			if ( ! file_exists( jet_woo_builder()->plugin_path( $filename ) ) ) {
				return false;
			}

			require jet_woo_builder()->plugin_path( $filename );

			return true;
		}

		/**
		 * Returns the instance.
		 *
		 * @since  1.0.0
		 * @return object
		 */
		public static function get_instance( $shortcodes = array() ) {

			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self( $shortcodes );
			}

			return self::$instance;
		}
	}

}

/**
 * Returns instance of Jet_Woo_Builder_Integration
 *
 * @return object
 */
function jet_woo_builder_integration() {
	return Jet_Woo_Builder_Integration::get_instance();
}
