<?php
/**
 * Child functions and definitions.
 */


if ( ! class_exists('Bitunet_Child_Theme_Setup') ) {

	final class Bitunet_Child_Theme_Setup {

		private static $instance = null;

		public function __construct() {

			// Register public assets.
			add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ), 9 );

			// Enqueue scripts.
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ), 10 );
			add_action( 'wp_enqueue_scripts', array( $this, 'bitunet_child_theme_scrpits') );

			//Disable Magic button action
			add_action( 'jet-theme-core/register-config', array( $this, 'bitunet_child_jet_theme_core_config' ) );

			//Load Parent assets
			add_filter( 'kava-theme/assets-depends/styles', array( $this, 'bitunet_kava_child_styles_depends' ) );
			// Load Child Theme locale
			add_action('after_setup_theme', array ( $this, 'bitunet_child_theme_locale') );


			//Add custom thumbnails
			add_action( 'after_setup_theme', array( $this, 'bitunet_child_register_image_sizes' ) );

			//Disable Ticker Plugin update
			add_filter( 'site_transient_update_plugins', array( $this, 'bitunet_plugin_update_deactivation' ) );

			require_once get_theme_file_path( 'config-files/classes/class-tgm-plugin-activation.php' );
			require_once get_theme_file_path( 'config-files/required-plugins.php' );
			require_once get_theme_file_path( 'config-files/wizard-config.php' );
			require_once get_theme_file_path( 'config-files/customizer-child.php');


			if ( class_exists( 'Elementor\Plugin' ) ) {
				require_once get_theme_file_path( 'config-files/extensions/elementor.php' );
				require_once get_theme_file_path( 'config-files/plugins-hooks/elementor.php' );
				require_once get_theme_file_path( 'config-files/widgets/elementor-template/class-elementor-template-widget.php' );
			}
		}

		/**
		 * @param null $instance
		 */
		public function register_assets() {
			wp_register_style(
				'thin-icon',
				get_theme_file_uri( 'assets/lib/thin-icon/thin-icon.css' ),
				array(),
				'4.7.0'
			);

			if ( class_exists('GDPR') && get_option( 'gdpr_disable_css', false ) ) {
				wp_register_style(
					'gdpr_styles',
					get_stylesheet_directory_uri() . '/assets/css/gdpr.css',
					array(),
					''
				);
			}
		}

		public function bitunet_plugin_update_deactivation( $value ) {
			if ( class_exists('Crypto_Currency_Price_Widget') ) {
				if ( isset( $value->response['cryptocurrency-price-ticker-widget/cryptocurrency-price-ticker-widget.php'] ) ) {
					unset( $value->response['cryptocurrency-price-ticker-widget/cryptocurrency-price-ticker-widget.php'] );
				}
			}
			return $value;
		}

		public function bitunet_child_jet_theme_core_config( $config_manager ) {
			$config_manager->register_config( array(
				'dashboard_page_name' => esc_html__( 'Bitunet', 'kava' ),
				'library_button' => false,
				'guide' => array(
					'enabled' => true,
				),
				'api' => array(
					'enabled'   => false,
				),
			) );
		}


		 /**
		 * Enqueue styles.
		 */
		public function bitunet_kava_child_styles_depends( $deps ) {

			$parent_handle = 'kava-parent-theme-style';

			wp_register_style(
				$parent_handle,
				get_template_directory_uri() . '/style.css',
				array(),
				kava_theme()->version()
			);

			$deps[] = $parent_handle;

			return $deps;
		}

		public function bitunet_child_register_image_sizes() {
			add_image_size( 'bitunet-thumb-576-339', 576, 339, true );
			add_image_size( 'bitunet-thumb-198-140', 198, 140, true );
			add_image_size( 'bitunet-thumb-360-199', 360, 199, true );
			add_image_size( 'bitunet-thumb-376-253', 376, 253, true );
			add_image_size( 'bitunet-thumb-178-120', 178, 120, true );
			add_image_size( 'bitunet-thumb-329-213', 329, 213, true );
			add_image_size( 'bitunet-thumb-348-213', 348, 213, true );
			add_image_size( 'bitunet-thumb-158-102', 158, 102, true );
		}


		public function enqueue_styles() {
			$styles_depends = apply_filters( 'bitunet-child-theme/assets-depends/styles', array(
				'thin-icon') );
			wp_enqueue_style(
				'bitunet-theme-style',
				get_stylesheet_uri(),
				$styles_depends
			);
			if ( class_exists('GDPR') ) {
				if ( get_option( 'gdpr_disable_css', false ) ) {
					wp_enqueue_style(
						'gdpr_styles',
						get_stylesheet_directory_uri() . '/assets/css/gdpr.css',
						array(),
						''
					);
				}
			}
		}

		public function bitunet_child_theme_scrpits() {
			wp_enqueue_script(
				'bitunet-child-script',
				get_stylesheet_directory_uri() . '/assets/js/bitunet_theme_script.js',
				array( 'jquery' )
			);
		}

		public function bitunet_child_theme_locale() {
			load_child_theme_textdomain('bitunet' , get_stylesheet_directory() . '/languages' );
		}

		public static function get_instance() {

			if ( null == self::$instance ) {
				self::$instance = new self();
			}
			return self::$instance;
		}
	}
}

function bitunet_child_theme() {
	return Bitunet_Child_Theme_Setup::get_instance();
}

bitunet_child_theme();


