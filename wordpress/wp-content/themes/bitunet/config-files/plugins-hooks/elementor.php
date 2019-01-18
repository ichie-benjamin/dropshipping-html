<?php
/**
 * Elementor hooks.
 *
 * @package Bitunet
 */

//Add Kava Extra plugin compatibility
add_filter('kava-extra/theme-compatibility-list', 'bitunet_add_kava_extra_compatibility');

//Add Thin icon pack to Elementor icon picker
add_action( 'elementor/controls/controls_registered', 'bitunet_add_theme_icons_to_icon_control', 20 );
add_action( 'elementor/editor/after_enqueue_styles', 'bitunet_enqueue_icon_font' );


/**
 * Adds Kava Extra plugin compatibility
 *
 * @since  1.0.0
 * @return array
 *
 */

function bitunet_add_kava_extra_compatibility( $args ) {

	$current_theme = array('Bitunet_Theme_Setup');

	$args = array_merge($args , $current_theme);

	return $args;
}


/*
 * Add Thin Icon pack
 *
 * @since 1.0.0
 * @return void
 *
 */

function bitunet_add_theme_icons_to_icon_control( $controls_manager ) {
	$default_icons = $controls_manager->get_control( 'icon' )->get_settings( 'options' );

	$thin_icons_data = array(
		'icons'  => bitunet_get_thin_icons_set(),
		'format' => 'thin %s',
	);


	$thin_icons_array = array();

	foreach( $thin_icons_data['icons'] as $index => $icon ) {
		$key = sprintf( $thin_icons_data['format'], $icon );

		$thin_icons_array[ $key ] = $icon;
	}

	$new_icons = array_merge( $default_icons, $thin_icons_array );

	$controls_manager->get_control( 'icon' )->set_settings( 'options', $new_icons );
}


/*
 * Get Thin icons set
 *
 * @since 1.0.0
 * $return array
 *
 */

function bitunet_get_thin_icons_set() {

	static $thin_icons;

	if ( ! $thin_icons ) {
		ob_start();

		include get_theme_file_path('/assets/lib/thin-icon/thin-icon.css');

		$result = ob_get_clean();

		preg_match_all( '/\.([-_a-zA-Z0-9]+):before[, {]/', $result, $matches );

		if ( ! is_array( $matches ) || empty( $matches[1] ) ) {
			return;
		}

		$thin_icons = $matches[1];
	}

	return $thin_icons;
}


/**
 *
 * Enqueue icon font.
 *
 */

function bitunet_enqueue_icon_font() {
	wp_enqueue_style( 'thin-icon', get_theme_file_uri( 'assets/lib/thin-icon/thin-icon.css' ), array(), '4.7.0' );
}