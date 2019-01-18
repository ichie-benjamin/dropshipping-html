<?php
/**
 * Plugin Name: JetWooBuilder For Elementor
 * Plugin URI:  http://jetwoobuilder.zemez.io/
 * Description: Your perfect asset in creating WooCommerce page templates using loads of special widgets & stylish page layouts
 * Version:     1.3.5
 * Author:      Zemez
 * Author URI:  https://zemez.io/wordpress/
 * Text Domain: jet-woo-builder
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /languages
 * WC tested up to: 3.5
 * WC requires at least: 3.0
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die();
}

// If class `Jet_Woo_Builder` doesn't exists yet.
if ( ! class_exists( 'Jet_Woo_Builder' ) ) {

	/**
	 * Sets up and initializes the plugin.
	 */
	class Jet_Woo_Builder {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since  1.0.0
		 * @access private
		 * @var    object
		 */
		private static $instance = null;

		/**
		 * Holder for base plugin URL
		 *
		 * @since  1.0.0
		 * @access private
		 * @var    string
		 */
		private $plugin_url = null;

		/**
		 * Plugin version
		 *
		 * @var string
		 */
		private $version = '1.3.5';

		/**
		 * Plugin properties
		 */
		public $framework;
		public $documents;
		public $parser;

		/**
		 * Holder for base plugin path
		 *
		 * @since  1.0.0
		 * @access private
		 * @var    string
		 */
		private $plugin_path = null;

		/**
		 * Sets up needed actions/filters for the plugin to initialize.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function __construct() {

			// Load the core functions/classes required by the rest of the plugin.
			add_action( 'after_setup_theme', array( $this, 'load_framework' ), - 20 );

			// Internationalize the text strings used.
			add_action( 'init', array( $this, 'lang' ), - 999 );
			// Load files.
			add_action( 'init', array( $this, 'init' ), - 999 );

			// Plugin row meta
			add_filter( 'plugin_row_meta', array( $this, 'plugin_row_meta' ), 10, 2 );

			// Register activation and deactivation hook.
			register_activation_hook( __FILE__, array( $this, 'activation' ) );
			register_deactivation_hook( __FILE__, array( $this, 'deactivation' ) );
		}

		/**
		 * Load plugin framework
		 */
		public function load_framework() {

			require $this->plugin_path( 'framework/loader.php' );

			$this->framework = new Jet_Woo_Builder_CX_Loader(
				array(
					$this->plugin_path( 'framework/interface-builder/cherry-x-interface-builder.php' ),
					$this->plugin_path( 'framework/post-meta/cherry-x-post-meta.php' ),
					$this->plugin_path( 'framework/db-updater/cherry-x-db-updater.php' )
				)
			);

		}

		/**
		 * Returns plugin version
		 *
		 * @return string
		 */
		public function get_version() {
			return $this->version;
		}

		/**
		 * Manually init required modules.
		 *
		 * @return void
		 */
		public function init() {

			if ( class_exists( 'WooCommerce' ) ) {

				$this->load_files();

				jet_woo_builder_assets()->init();
				jet_woo_builder_integration()->init();
				jet_woo_builder_integration_woocommerce()->init();
				jet_woo_builder_post_type()->init();

				jet_woo_builder_settings()->init();
				jet_woo_builder_shortocdes()->init();
				jet_woo_builder_shop_settings()->init();
				jet_woo_builder_compatibility()->init();

				$this->documents = new Jet_Woo_Builder_Documents();
				$this->parser    = new Jet_Woo_Builder_Parser();

				if ( is_admin() ) {
					// Init DB upgrader
					require $this->plugin_path( 'includes/class-jet-woo-builder-db-upgrader.php' );
					jet_woo_builder_db_upgrader()->init();

				}
			}

			if ( is_admin() ) {

				require $this->plugin_path( 'includes/updater/class-jet-woo-builder-plugin-update.php' );

				jet_woo_builder_updater()->init( array(
					'version' => $this->get_version(),
					'slug'    => 'jet-woo-builder',
				) );

				if ( ! $this->has_elementor() ) {
					$this->required_plugins_notice();
				}

			}

		}

		/**
		 * Show recommended plugins notice.
		 *
		 * @return void
		 */
		public function required_plugins_notice() {
			require $this->plugin_path( 'includes/lib/class-tgm-plugin-activation.php' );
			add_action( 'tgmpa_register', array( $this, 'register_required_plugins' ) );
		}

		/**
		 * Register required plugins
		 *
		 * @return void
		 */
		public function register_required_plugins() {

			$plugins = array(
				array(
					'name'     => 'Elementor',
					'slug'     => 'elementor',
					'required' => true,
				),
				array(
					'name'     => 'WooCommerce',
					'slug'     => 'woocommerce',
					'required' => true,
				),
			);

			$config = array(
				'id'           => 'jet-woo-builder',
				'default_path' => '',
				'menu'         => 'jet-woo-elements-install-plugins',
				'parent_slug'  => 'plugins.php',
				'capability'   => 'manage_options',
				'has_notices'  => true,
				'dismissable'  => true,
				'dismiss_msg'  => '',
				'is_automatic' => false,
				'strings'      => array(
					'notice_can_install_required'    => _n_noop(
						'Jet Woo Builder for Elementor requires the following plugin: %1$s.',
						'Jet Woo Builder for Elementor requires the following plugins: %1$s.',
						'jet-woo-builder'
					),
					'notice_can_install_recommended' => _n_noop(
						'Jet Woo Builder for Elementor recommends the following plugin: %1$s.',
						'Jet Woo Builder for Elementor recommends the following plugins: %1$s.',
						'jet-woo-builder'
					),
				),
			);

			tgmpa( $plugins, $config );

		}

		/**
		 * Check if theme has elementor
		 *
		 * @return boolean
		 */
		public function has_elementor() {
			return defined( 'ELEMENTOR_VERSION' );
		}

		/**
		 * Returns utility instance
		 *
		 * @return object
		 */
		public function utility() {
			$utility = $this->get_core()->modules['cherry-utility'];

			return $utility->utility;
		}

		/**
		 * Load required files.
		 *
		 * @return void
		 */
		public function load_files() {
			require $this->plugin_path( 'includes/class-jet-woo-builder-assets.php' );
			require $this->plugin_path( 'includes/class-jet-woo-builder-tools.php' );
			require $this->plugin_path( 'includes/class-jet-woo-builder-post-type.php' );
			require $this->plugin_path( 'includes/class-jet-woo-builder-documents.php' );
			require $this->plugin_path( 'includes/class-jet-woo-builder-parser.php' );

			require $this->plugin_path( 'includes/integrations/base/class-jet-woo-builder-integration.php' );
			require $this->plugin_path( 'includes/integrations/base/class-jet-woo-builder-integration-woocommerce.php' );

			require $this->plugin_path( 'includes/class-jet-woo-builder-template-functions.php' );
			require $this->plugin_path( 'includes/class-jet-woo-builder-shortcodes.php' );

			require $this->plugin_path( 'includes/settings/class-jet-woo-builder-settings.php' );
			require $this->plugin_path( 'includes/settings/class-jet-woo-builder-shop-settings.php' );

			require $this->plugin_path( 'includes/lib/compatibility/class-jet-woo-builder-compatibility.php' );
		}

		/**
		 * Returns path to file or dir inside plugin folder
		 *
		 * @param  string $path Path inside plugin dir.
		 *
		 * @return string
		 */
		public function plugin_path( $path = null ) {

			if ( ! $this->plugin_path ) {
				$this->plugin_path = trailingslashit( plugin_dir_path( __FILE__ ) );
			}

			return $this->plugin_path . $path;
		}

		/**
		 * Returns url to file or dir inside plugin folder
		 *
		 * @param  string $path Path inside plugin dir.
		 *
		 * @return string
		 */
		public function plugin_url( $path = null ) {

			if ( ! $this->plugin_url ) {
				$this->plugin_url = trailingslashit( plugin_dir_url( __FILE__ ) );
			}

			return $this->plugin_url . $path;
		}

		/**
		 * Loads the translation files.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function lang() {
			load_plugin_textdomain( 'jet-woo-builder', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
		}

		/**
		 * Get the template path.
		 *
		 * @return string
		 */
		public function template_path() {
			return apply_filters( 'jet-woo-builder/template-path', 'jet-woo-builder/' );
		}

		/**
		 * Returns path to template file.
		 *
		 * @return string|bool
		 */
		public function get_template( $name = null ) {

			$template = locate_template( $this->template_path() . $name );

			if ( ! $template ) {
				$template = $this->plugin_path( 'templates/' . $name );
			}

			if ( file_exists( $template ) ) {
				return $template;
			} else {
				return false;
			}
		}

		/**
		 * Add plugin changelog link.
		 *
		 * @param array  $plugin_meta
		 * @param string $plugin_file
		 *
		 * @return array
		 */
		public function plugin_row_meta( $plugin_meta, $plugin_file ) {
			if ( plugin_basename( __FILE__ ) === $plugin_file ) {
				$plugin_meta['changelog'] = sprintf(
					'<a href="http://documentation.zemez.io/wordpress/index.php?project=jetwoobuilder&lang=en&section=jetwoobuilder-changelog" target="_blank">%s</a>',
					esc_html__( 'Changelog', 'jet-woo-builder' )
				);
			}
			return $plugin_meta;
		}

		/**
		 * Do some stuff on plugin activation
		 *
		 * @since  1.0.0
		 * @return void
		 */
		public function activation() {
		}

		/**
		 * Do some stuff on plugin activation
		 *
		 * @since  1.0.0
		 * @return void
		 */
		public function deactivation() {
		}

		/**
		 * Returns the instance.
		 *
		 * @since  1.0.0
		 * @access public
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

if ( ! function_exists( 'jet_woo_builder' ) ) {

	/**
	 * Returns instanse of the plugin class.
	 *
	 * @since  1.0.0
	 * @return object
	 */
	function jet_woo_builder() {
		return Jet_Woo_Builder::get_instance();
	}
}

jet_woo_builder();
