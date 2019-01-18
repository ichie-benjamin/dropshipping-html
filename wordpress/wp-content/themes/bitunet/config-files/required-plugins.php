<?php
/**
 * Setup Jet Plugins Wizard
 *
 * @package Bitunet
 */

add_action( 'tgmpa_register', 'bitunet_register_required_plugins' );

function bitunet_register_required_plugins() {

	$plugins = array(
		array(
			'name'         => esc_html__( 'Jet Plugin Wizard', 'bitunet' ),
			'slug'         => 'jet-plugins-wizard',
			'source'       => 'https://github.com/ZemezLab/jet-plugins-wizard/archive/1.0.0.zip',
			'external_url' => 'https://github.com/ZemezLab/jet-plugins-wizard',
		),
	);

	$config = array(
		'id'           => 'bitunet',
		'default_path' => '',
		'menu'         => 'tgmpa-install-plugins',
		'has_notices'  => true,
		'dismissable'  => true,
		'dismiss_msg'  => '',
		'is_automatic' => true,
		'message'      => '',
	);

	tgmpa( $plugins, $config );
}
