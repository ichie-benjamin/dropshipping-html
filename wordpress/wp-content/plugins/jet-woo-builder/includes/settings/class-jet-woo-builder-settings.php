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

if ( ! class_exists( 'Jet_Woo_Builder_Settings' ) ) {

	/**
	 * Define Jet_Woo_Builder_Settings class
	 */
	class Jet_Woo_Builder_Settings {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since  1.0.0
		 * @access private
		 * @var    object
		 */
		private static $instance = null;

		/**
		 * [$key description]
		 * @var string
		 */
		public $key = 'jet-woo-builder-settings';

		/**
		 * [$builder description]
		 * @var null
		 */
		public $builder  = null;

		/**
		 * [$settings description]
		 * @var null
		 */
		public $settings = null;

		/**
		 * Global Available Widgets array
		 *
		 * @var array
		 */
		public $global_available_widgets = array();

		/**
		 * Single Product Available Widgets array
		 *
		 * @var array
		 */
		public $single_product_available_widgets = array();

		/**
		 * Archive Product Available Widgets array
		 *
		 * @var array
		 */
		public $archive_product_available_widgets = array();

		/**
		 * Archive Category Available Widgets array
		 *
		 * @var array
		 */
		public $archive_category_available_widgets = array();

		/**
		 * Archive Product Available Widgets array
		 *
		 * @var array
		 */
		public $shop_product_available_widgets = array();

		/**
		 * Init page
		 */
		public function init() {

			add_action( 'admin_enqueue_scripts', array( $this, 'init_builder' ), 0 );
			add_action( 'admin_menu', array( $this, 'register_page' ), 99 );
			add_action( 'init', array( $this, 'save' ), 40 );
			add_action( 'admin_notices', array( $this, 'saved_notice' ) );

			foreach ( glob( jet_woo_builder()->plugin_path( 'includes/widgets/global/' ) . '*.php' ) as $file ) {
				$data = get_file_data( $file, array( 'class'=>'Class', 'name' => 'Name', 'slug'=>'Slug' ) );

				$slug = basename( $file, '.php' );
				$this->global_available_widgets[ $slug] = $data['name'];
			}

			foreach ( glob( jet_woo_builder()->plugin_path( 'includes/widgets/single-product/' ) . '*.php' ) as $file ) {
				$data = get_file_data( $file, array( 'class'=>'Class', 'name' => 'Name', 'slug'=>'Slug' ) );

				$slug = basename( $file, '.php' );
				$this->single_product_available_widgets[ $slug] = $data['name'];
			}

			foreach ( glob( jet_woo_builder()->plugin_path( 'includes/widgets/archive-product/' ) . '*.php' ) as $file ) {
				$data = get_file_data( $file, array( 'class'=>'Class', 'name' => 'Name', 'slug'=>'Slug' ) );

				$slug = basename( $file, '.php' );
				$this->archive_product_available_widgets[ $slug] = $data['name'];
			}

			foreach ( glob( jet_woo_builder()->plugin_path( 'includes/widgets/archive-category/' ) . '*.php' ) as $file ) {
				$data = get_file_data( $file, array( 'class'=>'Class', 'name' => 'Name', 'slug'=>'Slug' ) );

				$slug = basename( $file, '.php' );
				$this->archive_category_available_widgets[ $slug] = $data['name'];
			}

			foreach ( glob( jet_woo_builder()->plugin_path( 'includes/widgets/shop/' ) . '*.php' ) as $file ) {
				$data = get_file_data( $file, array( 'class'=>'Class', 'name' => 'Name', 'slug'=>'Slug' ) );

				$slug = basename( $file, '.php' );
				$this->shop_product_available_widgets[ $slug] = $data['name'];
			}

		}

		/**
		 * Initialize page builder module if reqired
		 *
		 * @return [type] [description]
		 */
		public function init_builder() {

			if ( ! isset( $_REQUEST['page'] ) || $this->key !== $_REQUEST['page'] ) {
				return;
			}

			$builder_data = jet_woo_builder()->framework->get_included_module_data( 'cherry-x-interface-builder.php' );

			$this->builder = new CX_Interface_Builder(
				array(
					'path' => $builder_data['path'],
					'url'  => $builder_data['url'],
				)
			);

		}

		/**
		 * Show saved notice
		 *
		 * @return bool
		 */
		public function saved_notice() {

			if ( ! isset( $_GET['settings-saved'] ) ) {
				return false;
			}

			$message = esc_html__( 'Settings saved', 'jet-woo-builder' );

			printf( '<div class="notice notice-success is-dismissible"><p>%s</p></div>', $message );

			return true;

		}

		/**
		 * Save settings
		 *
		 * @return void
		 */
		public function save() {

			if ( ! isset( $_REQUEST['page'] ) || $this->key !== $_REQUEST['page'] ) {
				return;
			}

			if ( ! isset( $_REQUEST['action'] ) || 'save-settings' !== $_REQUEST['action'] ) {
				return;
			}

			if ( ! current_user_can( 'manage_options' ) ) {
				return;
			}

			$current = get_option( $this->key, array() );
			$data    = $_REQUEST;

			unset( $data['action'] );

			foreach ( $data as $key => $value ) {
				$current[ $key ] = is_array( $value ) ? $value : esc_attr( $value );
			}

			update_option( $this->key, $current );

			$redirect = add_query_arg(
				array( 'dialog-saved' => true ),
				$this->get_settings_page_link()
			);

			wp_redirect( $redirect );
			die();

		}

		/**
		 * Return settings page URL
		 *
		 * @return string
		 */
		public function get_settings_page_link() {

			return add_query_arg(
				array(
					'page' => $this->key,
				),
				esc_url( admin_url( 'admin.php' ) )
			);

		}

		public function get( $setting, $default = false ) {

			if ( null === $this->settings ) {
				$this->settings = get_option( $this->key, array() );
			}

			return isset( $this->settings[ $setting ] ) ? $this->settings[ $setting ] : $default;

		}

		/**
		 * Register add/edit page
		 *
		 * @return void
		 */
		public function register_page() {

			add_submenu_page(
				'elementor',
				esc_html__( 'Jet Woo Builder Settings', 'jet-woo-builder' ),
				esc_html__( 'Jet Woo Builder Settings', 'jet-woo-builder' ),
				'manage_options',
				$this->key,
				array( $this, 'render_page' )
			);

		}

		/**
		 * Render settings page
		 *
		 * @return void
		 */
		public function render_page() {

			foreach ( $this->global_available_widgets as $key => $value ) {
				$default_global_available_widgets[ $key ] = 'true';
			}

			foreach ( $this->single_product_available_widgets as $key => $value ) {
				$default_single_available_widgets[ $key ] = 'true';
			}

			foreach ( $this->archive_product_available_widgets as $key => $value ) {
				$default_archive_available_widgets[ $key ] = 'true';
			}

			foreach ( $this->archive_category_available_widgets as $key => $value ) {
				$default_archive_category_available_widgets[ $key ] = 'true';
			}

			foreach ( $this->shop_product_available_widgets as $key => $value ) {
				$default_shop_available_widgets[ $key ] = 'true';
			}

			$this->builder->register_section(
				array(
					'jet_woo_builder_settings' => array(
						'type'   => 'section',
						'scroll' => false,
						'title'  => esc_html__( 'Jet Woo Builder Settings', 'jet-woo-builder' ),
					),
				)
			);

			$this->builder->register_form(
				array(
					'jet_woo_builder_settings_form' => array(
						'type'   => 'form',
						'parent' => 'jet_woo_builder_settings',
						'action' => add_query_arg(
							array( 'page' => $this->key, 'action' => 'save-settings' ),
							esc_url( admin_url( 'admin.php' ) )
						),
					),
				)
			);

			$this->builder->register_settings(
				array(
					'settings_top' => array(
						'type'   => 'settings',
						'parent' => 'jet_woo_builder_settings_form',
					),
					'settings_bottom' => array(
						'type'   => 'settings',
						'parent' => 'jet_woo_builder_settings_form',
					),
				)
			);

			$this->builder->register_component(
				array(
					'jet_woo_builder_tab_vertical' => array(
						'type'   => 'component-tab-vertical',
						'parent' => 'settings_top',
					),
				)
			);

			$this->builder->register_settings(
				array(
					'available_widgets_options' => array(
						'parent'      => 'jet_woo_builder_tab_vertical',
						'title'       => esc_html__( 'Available Widgets', 'jet-woo-builder' ),
					),
				)
			);

			$this->builder->register_control(
				array(
					'global_available_widgets' => array(
						'type'        => 'checkbox',
						'id'          => 'global_available_widgets',
						'name'        => 'global_available_widgets',
						'parent'      => 'available_widgets_options',
						'value'       => $this->get( 'global_available_widgets', $default_global_available_widgets ),
						'options'     => $this->global_available_widgets,
						'title'       => esc_html__( 'Global Available Widgets', 'jet-woo-builder' ),
						'description' => esc_html__( 'List of widgets that will be available when editing the page', 'jet-woo-builder' ),
						'class'       => 'jet_woo_builder_settings_form__checkbox-group'
					),
				)
			);

			$this->builder->register_control(
				array(
					'single_product_available_widgets' => array(
						'type'        => 'checkbox',
						'id'          => 'single_product_available_widgets',
						'name'        => 'single_product_available_widgets',
						'parent'      => 'available_widgets_options',
						'value'       => $this->get( 'single_product_available_widgets', $default_single_available_widgets ),
						'options'     => $this->single_product_available_widgets,
						'title'       => esc_html__( 'Single Product Available Widgets', 'jet-woo-builder' ),
						'description' => esc_html__( 'List of widgets that will be available when editing the single product template', 'jet-woo-builder' ),
						'class'       => 'jet_woo_builder_settings_form__checkbox-group'
					),
				)
			);

			$this->builder->register_control(
				array(
					'archive_product_available_widgets' => array(
						'type'        => 'checkbox',
						'id'          => 'archive_product_available_widgets',
						'name'        => 'archive_product_available_widgets',
						'parent'      => 'available_widgets_options',
						'value'       => $this->get( 'archive_product_available_widgets', $default_archive_available_widgets ),
						'options'     => $this->archive_product_available_widgets,
						'title'       => esc_html__( 'Archive Product Available Widgets', 'jet-woo-builder' ),
						'description' => esc_html__( 'List of widgets that will be available when editing the archive product template', 'jet-woo-builder' ),
						'class'       => 'jet_woo_builder_settings_form__checkbox-group'
					),
				)
			);

			$this->builder->register_control(
				array(
					'archive_category_available_widgets' => array(
						'type'        => 'checkbox',
						'id'          => 'archive_category_available_widgets',
						'name'        => 'archive_category_available_widgets',
						'parent'      => 'available_widgets_options',
						'value'       => $this->get( 'archive_category_available_widgets', $default_archive_category_available_widgets ),
						'options'     => $this->archive_category_available_widgets,
						'title'       => esc_html__( 'Archive Category Available Widgets', 'jet-woo-builder' ),
						'description' => esc_html__( 'List of widgets that will be available when editing the archive category template', 'jet-woo-builder' ),
						'class'       => 'jet_woo_builder_settings_form__checkbox-group'
					),
				)
			);

			$this->builder->register_control(
				array(
					'shop_product_available_widgets' => array(
						'type'        => 'checkbox',
						'id'          => 'shop_product_available_widgets',
						'name'        => 'shop_product_available_widgets',
						'parent'      => 'available_widgets_options',
						'value'       => $this->get( 'shop_product_available_widgets', $default_shop_available_widgets ),
						'options'     => $this->shop_product_available_widgets,
						'title'       => esc_html__( 'Shop Product Available Widgets', 'jet-woo-builder' ),
						'description' => esc_html__( 'List of widgets that will be available when editing the archive product template', 'jet-woo-builder' ),
						'class'       => 'jet_woo_builder_settings_form__checkbox-group'
					),
				)
			);

			$this->builder->register_settings(
				array(
					'product_thumb_effect_options' => array(
						'parent' => 'jet_woo_builder_tab_vertical',
						'title'  => esc_html__( 'Product Thumb Effect', 'jet-woo-builder' ),
					),
				)
			);

			$this->builder->register_control(
				array(
					'enable_product_thumb_effect' => array(
						'type'        => 'switcher',
						'id'          => 'enable_product_thumb_effect',
						'name'        => 'enable_product_thumb_effect',
						'parent'      => 'product_thumb_effect_options',
						'title'       => esc_html__( 'Enable Thumbnails Effect', 'jet-woo-builder' ),
						'description' => esc_html__( 'Enable thumbnails switch on hover', 'jet-woo-builder' ),
						'value'       => $this->get( 'enable_product_thumb_effect' ),
						'toggle'      => array(
							'true_toggle'  => 'On',
							'false_toggle' => 'Off',
						),
					),
				)
			);

			$this->builder->register_control(
				array(
					'product_thumb_effect' => array(
						'type'    => 'select',
						'id'      => 'product_thumb_effect',
						'name'    => 'product_thumb_effect',
						'parent'  => 'product_thumb_effect_options',
						'value'   => $this->get( 'product_thumb_effect', 'slide-left' ),
						'options' => array(
							'slide-left'     => esc_html__( 'Slide Left', 'jet-woo-builder' ),
							'slide-right'    => esc_html__( 'Slide Right', 'jet-woo-builder' ),
							'slide-top'      => esc_html__( 'Slide Top', 'jet-woo-builder' ),
							'slide-bottom'   => esc_html__( 'Slide Bottom', 'jet-woo-builder' ),
							'fade'           => esc_html__( 'Fade', 'jet-woo-builder' ),
							'fade-with-zoom' => esc_html__( 'Fade With Zoom', 'jet-woo-builder' ),
						),
						'title'   => esc_html__( 'Thumbnails Effect:', 'jet-woo-builder' ),
					)
				)
			);

			$this->builder->register_html(
				array(
					'save_button' => array(
						'type'   => 'html',
						'parent' => 'settings_bottom',
						'class'  => 'cx-component dialog-save',
						'html'   => '<button type="submit" class="button button-primary">' . esc_html__( 'Save', 'jet-woo-builder' ) . '</button>',
					),
				)
			);

			echo '<div class="jet-woo-builder-settings-page">';
				$this->builder->render();
			echo '</div>';
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

/**
 * Returns instance of Jet_Woo_Builder_Settings
 *
 * @return object
 */
function jet_woo_builder_settings() {
	return Jet_Woo_Builder_Settings::get_instance();
}
