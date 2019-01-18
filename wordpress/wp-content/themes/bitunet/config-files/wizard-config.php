<?php
/*
 * Wizard Plugin config
 *
 * @package Bitunet
 */

add_action( 'init', 'bitunet_plugins_wizard_config', 9 );
add_action( 'init', 'bitunet_data_importer_config', 9 );

/**
 * Register Jet Plugins Wizards config
 *
 */

function bitunet_plugins_wizard_config() {

	if ( ! is_admin() ) {
		return;
	}
	if ( ! function_exists( 'jet_plugins_wizard_register_config' ) ) {
		return;
	}

	jet_plugins_wizard_register_config( array(
		'license' => array(
			'enabled' => false,
		),
		'plugins' => array(
			'jet-data-importer'                  => array(
				'name'   => esc_html__( 'Jet Data Importer', 'bitunet' ),
				'source' => 'remote',
				'path'   => 'https://github.com/ZemezLab/jet-data-importer/archive/master.zip',
				'access' => 'base',
			),
			'jet-blocks'                         => array(
				'name'   => esc_html__( 'Jet Blocks For Elementor', 'bitunet' ),
				'source' => 'local',
				'path'   => get_stylesheet_directory_uri() . '/assets/includes/jet-blocks.zip',
				'access' => 'base',
			),
			'jet-elements'                       => array(
				'name'   => esc_html__( 'Jet Elements For Elementor', 'bitunet' ),
				'source' => 'local',
				'path'   => get_stylesheet_directory_uri() . '/assets/includes/jet-elements.zip',
				'access' => 'base',
			),
			'jet-tabs'                           => array(
				'name'   => esc_html__( 'Jet Tabs For Elementor', 'bitunet' ),
				'source' => 'local',
				'path'   => get_stylesheet_directory_uri() . '/assets/includes/jet-tabs.zip',
				'access' => 'base',
			),
			'jet-theme-core'                     => array(
				'name'   => esc_html__( 'Jet Theme Core', 'bitunet' ),
				'source' => 'local',
				'path'   => get_stylesheet_directory_uri() . '/assets/includes/jet-theme-core.zip',
				'access' => 'base',
			),
			'jet-blog'                           => array(
				'name'   => esc_html__( 'Jet Blog', 'bitunet' ),
				'source' => 'local',
				'path'   => get_stylesheet_directory_uri() . '/assets/includes/jet-blog.zip',
				'access' => 'skins',
			),
			'jet-popup'                          => array(
				'name'   => esc_html__( 'Jet Popup', 'bitunet' ),
				'source' => 'local',
				'path'   => get_stylesheet_directory_uri() . '/assets/includes/jet-popup.zip',
				'access' => 'skins',
			),
			'jet-tricks'                         => array(
				'name'   => esc_html__( 'Jet Tricks', 'bitunet' ),
				'source' => 'local',
				'path'   => get_stylesheet_directory_uri() . '/assets/includes/jet-tricks.zip',
				'access' => 'base',
			),
			'jet-menu'                           => array(
				'name'   => esc_html__( 'Jet Menu', 'bitunet' ),
				'source' => 'local',
				'path'   => get_stylesheet_directory_uri() . '/assets/includes/jet-menu.zip',
				'access' => 'base',
			),
			'jet-woo-builder'                    => array(
				'name'   => esc_html__( 'Jet Woo Builder', 'bitunet' ),
				'source' => 'local',
				'path'   => get_stylesheet_directory_uri() . '/assets/includes/jet-woo-builder.zip',
				'access' => 'skins',
			),
			'kava-extra'                         => array(
				'name'   => esc_html__( 'Kava Extra', 'bitunet' ),
				'source' => 'local',
				'path'   => get_stylesheet_directory_uri() . '/assets/includes/kava-extra.zip',
				'access' => 'base',
			),
			'woocommerce'                        => array(
				'name'   => esc_html__( 'Woocommerce', 'bitunet' ),
				'access' => 'skins',
			),
			'visualizer'                         => array(
				'name'   => esc_html__( 'Visualizer', 'bitunet' ),
				'access' => 'skins',
			),
			'contact-form-7'                     => array(
				'name'   => esc_html__( 'Contact Form 7', 'bitunet' ),
				'access' => 'skins',
			),
			'cryptocurrency-price-ticker-widget' => array(
				'name'   => esc_html__( 'Kava Extra', 'bitunet' ),
				'source' => 'local',
				'path'   => get_stylesheet_directory_uri() . '/assets/includes/cryptocurrency-price-ticker-widget.zip',
				'access' => 'skins',
			),
			'cryptocurrency-rocket-tools'        => array(
				'name'   => esc_html__( 'Cryptocurrency Rocket Tools', 'bitunet' ),
				'access' => 'skins',
			),
			'elementor'                          => array(
				'name'   => esc_html__( 'Elementor', 'bitunet' ),
				'access' => 'base',
			),
		),
		'skins'   => array(
			'base'     => array(
				'jet-data-importer',
				'elementor',
				'jet-blocks',
				'jet-elements',
				'jet-tabs',
				'jet-theme-core',
				'jet-tricks',
				'jet-menu',
				'kava-extra',
			),
			'advanced' => array(
				'default' => array(
					'full'  => array(
						'woocommerce',
						'cryptocurrency-price-ticker-widget',
						'cryptocurrency-rocket-tools',
						'visualizer',
						'contact-form-7',
						'jet-popup',
						'jet-blog',
						'jet-woo-builder',
					),
					'lite'  => false,
					'demo'  => 'http://ld-wp.template-help.com/bitunet/skin-1/',
					'thumb' => get_stylesheet_directory_uri() . '/assets/demo-content/default/default.jpg',
					'name'  => esc_html__( 'Bitunet Default', 'bitunet' ),
				),
				'skin-1'  => array(
					'full'  => array(
						'woocommerce',
						'jet-woo-builder',
						'contact-form-7',
						'jet-blog',
					),
					'lite'  => false,
					'demo'  => 'http://ld-wp.template-help.com/bitunet/skin-2/',
					'thumb' => get_stylesheet_directory_uri() . '/assets/demo-content/skin-1/skin-1.jpg',
					'name'  => esc_html__( 'Bitunet Blue', 'bitunet' ),
				),
				'skin-2'  => array(
					'full'  => array(
						'cryptocurrency-price-ticker-widget',
						'jet-blog',
						'contact-form-7',
						'cryptocurrency-rocket-tools',
					),
					'lite'  => false,
					'demo'  => 'http://ld-wp.template-help.com/bitunet/skin-3/',
					'thumb' => get_stylesheet_directory_uri() . '/assets/demo-content/skin-2/skin-2.jpg',
					'name'  => esc_html__( 'Bitunet Crypto Blog', 'bitunet' ),
				),
				'skin-3'  => array(
					'full'  => array(
						'cryptocurrency-price-ticker-widget',
					),
					'lite'  => false,
					'demo'  => 'http://ld-wp.template-help.com/bitunet/skin-4/',
					'thumb' => get_stylesheet_directory_uri() . '/assets/demo-content/skin-3/skin-3.jpg',
					'name'  => esc_html__( 'Bitunet Crypto Landing - Blockchain', 'bitunet' ),
				),
				'skin-4'  => array(
					'full'  => array(
						'cryptocurrency-price-ticker-widget',
						'cryptocurrency-rocket-tools',
						'visualizer',
					),
					'lite'  => false,
					'demo'  => 'http://ld-wp.template-help.com/bitunet/skin-5/',
					'thumb' => get_stylesheet_directory_uri() . '/assets/demo-content/skin-4/skin-4.jpg',
					'name'  => esc_html__( 'Bitunet Crypto Landing - ICO', 'bitunet' ),
				),
			),
		),
		'texts'   => array(
			'theme-name' => esc_html__( 'Bitunet', 'bitunet' ),
		)
	) );
}



/**
 * Register Jet Data Importer config
 * @return [type] [description]
 */
function bitunet_data_importer_config() {

	if ( ! is_admin() ) {
		return;
	}

	if ( ! function_exists( 'jet_data_importer_register_config' ) ) {
		return;
	}

	jet_data_importer_register_config( array(
		'xml'             => false,
		'advanced_import' => array(
			'default' => array(
				'label'    => esc_html__( 'Bitunet', 'bitunet' ),
				'full'     => get_theme_file_path() . '/assets/demo-content/default/default.xml',
				'lite'     => false,
				'thumb'    => get_stylesheet_directory_uri() . '/assets/demo-content/default/default.jpg',
				'demo_url' => 'http://ld-wp.template-help.com/bitunet/skin-1/',
			),
			'skin-1'  => array(
				'label'    => esc_html__( 'Bitunet Blue', 'bitunet' ),
				'full'     => get_theme_file_path() . '/assets/demo-content/skin-1/skin-1.xml',
				'lite'     => false,
				'thumb'    => get_stylesheet_directory_uri() . '/assets/demo-content/skin-1/skin-1.jpg',
				'demo_url' => 'http://ld-wp.template-help.com/bitunet/skin-2/',
			),
			'skin-2'  => array(
				'label'    => esc_html__( 'Bitunet Crypto Blog', 'bitunet' ),
				'full'     => get_theme_file_path() . '/assets/demo-content/skin-2/skin-2.xml',
				'lite'     => false,
				'thumb'    => get_stylesheet_directory_uri() . '/assets/demo-content/skin-2/skin-2.jpg',
				'demo_url' => 'http://ld-wp.template-help.com/bitunet/skin-3/',
			),
			'skin-3'  => array(
				'label'    => esc_html__( 'Bitunet Crypto Landing - Blockchain', 'bitunet' ),
				'full'     => get_theme_file_path() . '/assets/demo-content/skin-3/skin-3.xml',
				'lite'     => false,
				'thumb'    => get_stylesheet_directory_uri() . '/assets/demo-content/skin-3/skin-3.jpg',
				'demo_url' => 'http://ld-wp.template-help.com/bitunet/skin-4/',
			),
			'skin-4'  => array(
				'label'    => esc_html__( 'Bitunet Crypto Landing - ICO', 'bitunet' ),
				'full'     => get_theme_file_path() . '/assets/demo-content/skin-4/skin-4.xml',
				'lite'     => false,
				'thumb'    => get_stylesheet_directory_uri() . '/assets/demo-content/skin-4/skin-4.jpg',
				'demo_url' => 'http://ld-wp.template-help.com/bitunet/skin-5/',
			),
		),
		'import'          => array(
			'chunk_size' => 3,
		),
		'slider'          => array(
			'path' => 'https://raw.githubusercontent.com/JetImpex/wizard-slides/master/slides.json',
		),
		'export'          => array(
			'options' => array(
				'woocommerce_default_country',
				'woocommerce_techguide_page_id',
				'woocommerce_default_catalog_orderby',
				'techguide_catalog_image_size',
				'techguide_single_image_size',
				'techguide_thumbnail_image_size',
				'woocommerce_cart_page_id',
				'woocommerce_checkout_page_id',
				'woocommerce_terms_page_id',
				'tm_woowishlist_page',
				'tm_woocompare_page',
				'tm_woocompare_enable',
				'tm_woocompare_show_in_catalog',
				'tm_woocompare_show_in_single',
				'tm_woocompare_compare_text',
				'tm_woocompare_remove_text',
				'tm_woocompare_page_btn_text',
				'tm_woocompare_show_in_catalog',

				'site_icon',
				'elementor_cpt_support',
				'elementor_disable_color_schemes',
				'elementor_disable_typography_schemes',
				'elementor_container_width',
				'elementor_css_print_method',
				'elementor_global_image_lightbox',

				'jet-elements-settings',
				'jet_menu_options',
				'jet_popup_conditions',

				'highlight-and-share',
				'stockticker_defaults',
			),
			'tables'  => array(),
		),
	) );
}

