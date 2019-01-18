<?php

/**
 * ReduxFramework Barebones Sample Config File
 * For full documentation, please visit: http://docs.reduxframework.com/
 */

if ( ! class_exists( 'Redux' ) ) {
    return;
}

// This is your option name where all the Redux data is stored.
$opt_name = "crtools_redux";

/**
 * ---> SET ARGUMENTS
 * All the possible arguments for Redux.
 * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
 * */

$theme = wp_get_theme(); // For use with some settings. Not necessary.

if( !function_exists('get_plugin_data') ){
    require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}
$crtools_plugin = get_plugin_data( CRTOOLS_MAIN_FILE );

// TODO get style
/*self::$styles = json_decode(file_get_contents( CRTOOLS_URL . 'assets/data/styles.txt'));*/

$args = array(
    // TYPICAL -> Change these values as you need/desire
    'opt_name'             => $opt_name,
    // This is where your data is stored in the database and also becomes your global variable name.
    'display_name'         => $crtools_plugin['Name'],
    // Name that appears at the top of your panel
    'display_version'      =>  $crtools_plugin['Version'],
    // Version that appears at the top of your panel
    'menu_type'            => 'menu',
    //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
    'allow_sub_menu'       => true,
    // Show the sections below the admin menu item or not
    'menu_title'           => 'CR Tools',
    'page_title'           => 'CR Tools',
    // You will need to generate a Google API key to use this feature.
    // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
    'google_api_key'       => '',
    // Set it you want google fonts to update weekly. A google_api_key value is required.
    'google_update_weekly' => false,
    // Must be defined to add google fonts to the typography module
    'async_typography'     => true,
    // Use a asynchronous font on the front end or font string
    //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
    'admin_bar'            => false,
    // Show the panel pages on the admin bar
    'admin_bar_icon'       => 'dashicons-portfolio',
    // Choose an icon for the admin bar menu
    'admin_bar_priority'   => 50,
    // Choose an priority for the admin bar menu
    'global_variable'      => '',
    // Set a different name for your global variable other than the opt_name
    'dev_mode'             => false,
    // Show the time the page took to load, etc
    'update_notice'        => true,
    // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
    'customizer'           => true,
    // Enable basic customizer support
    //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
    //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

    // OPTIONAL -> Give you extra features
    'page_priority'        => null,
    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
    'page_parent'          => 'themes.php',
    // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
    'page_permissions'     => 'manage_options',
    // Permissions needed to access the options panel.
    'menu_icon'            => CRTOOLS_URL . 'assets/images/crtools_icon.svg',
    // Specify a custom URL to an icon
    'last_tab'             => '',
    // Force your panel to always open to a specific tab (by id)
    'page_icon'            => 'icon-themes',
    // Icon displayed in the admin panel next to your menu_title
    'page_slug'            => 'crtools',
    // Page slug used to denote the panel
    'save_defaults'        => true,
    // On load save the defaults to DB before user clicks save or not
    'default_show'         => false,
    // If true, shows the default value next to each field that is not the default value.
    'default_mark'         => '',
    // What to print by the field's title if the value shown is default. Suggested: *
    'show_import_export'   => true,
    // Shows the Import/Export panel when not used as a field.

    // CAREFUL -> These options are for advanced use only
    'transient_time'       => 60 * MINUTE_IN_SECONDS,
    'output'               => true,
    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
    'output_tag'           => true,
    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
    // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

    // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
    'database'             => '',
    // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!

    'use_cdn'              => true,
    // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.

    //'compiler'             => true,

    // HINTS
    'hints'                => array(
        'icon'          => 'el el-question-sign',
        'icon_position' => 'right',
        'icon_color'    => 'lightgray',
        'icon_size'     => 'normal',
        'tip_style'     => array(
            'color'   => 'light',
            'shadow'  => true,
            'rounded' => false,
            'style'   => '',
        ),
        'tip_position'  => array(
            'my' => 'top left',
            'at' => 'bottom right',
        ),
        'tip_effect'    => array(
            'show' => array(
                'effect'   => 'slide',
                'duration' => '500',
                'event'    => 'mouseover',
            ),
            'hide' => array(
                'effect'   => 'slide',
                'duration' => '500',
                'event'    => 'click mouseleave',
            ),
        ),
    )
);

// ADMIN BAR LINKS -> Setup custom links in the admin bar menu as external items.
/*$args['admin_bar_links'][] = array(
    'id'    => 'redux-docs',
    'href'  => 'http://docs.reduxframework.com/',
    'title' => __( 'Documentation', 'crtools' ),
);

$args['admin_bar_links'][] = array(
    //'id'    => 'redux-support',
    'href'  => 'https://github.com/ReduxFramework/redux-framework/issues',
    'title' => __( 'Support', 'crtools' ),
);

$args['admin_bar_links'][] = array(
    'id'    => 'redux-extensions',
    'href'  => 'reduxframework.com/extensions',
    'title' => __( 'Extensions', 'crtools' ),
);*/

// SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
/*$args['share_icons'][] = array(
    'url'   => 'https://github.com/ReduxFramework/ReduxFramework',
    'title' => 'Visit us on GitHub',
    'icon'  => 'el el-github'
    //'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
);
$args['share_icons'][] = array(
    'url'   => 'https://www.facebook.com/pages/Redux-Framework/243141545850368',
    'title' => 'Like us on Facebook',
    'icon'  => 'el el-facebook'
);
$args['share_icons'][] = array(
    'url'   => 'http://twitter.com/reduxframework',
    'title' => 'Follow us on Twitter',
    'icon'  => 'el el-twitter'
);
$args['share_icons'][] = array(
    'url'   => 'http://www.linkedin.com/company/redux-framework',
    'title' => 'Find us on LinkedIn',
    'icon'  => 'el el-linkedin'
);*/

// Panel Intro text -> before the form
/*if ( ! isset( $args['global_variable'] ) || $args['global_variable'] !== false ) {
    if ( ! empty( $args['global_variable'] ) ) {
        $v = $args['global_variable'];
    } else {
        $v = str_replace( '-', '_', $args['opt_name'] );
    }
    $args['intro_text'] = sprintf( __( '<p>Did you know that Redux sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$%1$s</strong></p>', 'crtools' ), $v );
} else {
    $args['intro_text'] = __( '<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'crtools' );
}*/

$args['intro_text'] = __( '<p>We had invested great effort and time to make this plugin better. We will appreciate your support.<br><a href="http://liberteam.org/"><b>Donate cryptocoin</b></a> or leave your <a href="https://wordpress.org/support/plugin/cryptocurrency-rocket-tools/reviews/"><b>review</b></a>.</p>', 'crtools' );

// Add content after the form.
// $args['footer_text'] = __('<p>We had invested great effort and time to make this plugin better.<br>We will appreciate your support.<br><a href="http://liberteam.org/"><b>Donate cryptocoin</b></a></p>', 'crtools' );

Redux::setArgs( $opt_name, $args );

/*
 * ---> END ARGUMENTS
 */

/*
 * ---> START HELP TABS
 */

$tabs = array(
    array(
        'id'      => 'redux-help-tab-1',
        'title'   => __( 'Theme Information 1', 'crtools' ),
        'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'crtools' )
    ),
    array(
        'id'      => 'redux-help-tab-2',
        'title'   => __( 'Theme Information 2', 'crtools' ),
        'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'crtools' )
    )
);
Redux::setHelpTab( $opt_name, $tabs );

// Set the help sidebar
$content = __( '<p>This is the sidebar content, HTML is allowed.</p>', 'crtools' );
Redux::setHelpSidebar( $opt_name, $content );


/*
 * <--- END HELP TABS
 */


/*
 *
 * ---> START SECTIONS
 *
 */

/*

    As of Redux 3.5+, there is an extensive API. This API can be used in a mix/match mode allowing for


 */

// -> START Basic Fields

Redux::setSection( $opt_name, array(
    'title' => __( 'Settings', 'crtools' ),
    'id'    => 'settings',
    'desc'  => __( 'Basic fields as subsections.', 'crtools' ),
    'icon'  => 'el el-cog'
) );

Redux::setSection( $opt_name, array(
    'title'      => __( 'General Settings', 'crtools' ),
    'desc'       => __( '', 'crtools' ),
    'id'         => 'general-settings-subsection',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'       => 'crtools-css',
            'type'     => 'textarea',
            'title'    => __( 'Custom CSS', 'crtools' ),
            'subtitle' => __( '', 'crtools' ),
            'desc'     => __( 'Write your custom CSS', 'crtools' ),
            'default' =>  __( "/*You can add your own CSS here.*/\n\n"),
        ),
    )
) );

Redux::setSection( $opt_name, array(
    'title'      => __( 'Converter', 'crtools' ),
    'desc'       => __( 'Settings are coming soon', 'crtools' ),
    'id'         => 'converter-subsection',
    'subsection' => true,
    'fields'     => array(

    )
) );

Redux::setSection( $opt_name, array(
    'title'      => __( 'Graph', 'crtools' ),
    'desc'       => __( '', 'crtools' ),
    'id'         => 'graph-subsection',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'       => 'crtools-graph-graphColor',
            'type'     => 'color',
            'title'    => __( 'Graph Color', 'crtools' ),
            'subtitle' => __( 'Pick a graph color (default: #5db75c)', 'crtools' ),
            'default'  => '#5db75c',
            'transparent'  => false,
        ),
        array(
            'id'       => 'crtools-graph-cursorColor',
            'type'     => 'color',
            'title'    => __( 'Cursor Color', 'crtools' ),
            'subtitle' => __( 'Pick a cursor color (default: #c90000)', 'crtools' ),
            'default'  => '#c90000',
            'transparent'  => false,
        ),
    )
) );


Redux::setSection( $opt_name, array(
    'title'      => __( 'Table', 'crtools' ),
    'desc'       => __( '', 'crtools' ),
    'id'         => 'table-subsection',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'       => 'crtools-table-baseLink',
            'type'     => 'text',
            'title'    => __( 'Base Link', 'crtools' ),
            'subtitle' => __( 'Set base link to specified pages', 'crtools' ),
            'desc'     => __( 'It uses a coin symbol like "btc" or "eth".', 'crtools' ) . '<br>' .
                __( 'If you need to create only few coin pages use the "Coin Pages" option to assign the links to them. ', 'crtools' )  . '<br>' .
                __( '<div id="info-opt-info-field" class="redux-normal   redux-notice-field redux-field-info"><p class="redux-info-desc">Examples:<br>if Base Link is <b>"coin"</b>, then Bitcoin page is <b>"www.sitename.com/coin/btc/"</b><br>if Base Link is <b>"/"</b>, then Bitcoin page is <b>"www.sitename.com/btc/"</b></p></div>', 'crtools' ),
            'default'  => '',
        ),
        array(
            'id'       => 'crtools-table-pageLinks',
            'type'     => 'select',
            'multi'    => true,
            'title'    => __( 'Coin Pages', 'crtools' ),
            'subtitle' => __( 'Set links only for few coins', 'crtools' ),
            'desc'     => __( 'Click and wait until the full list is loaded.', 'crtools' ),
            'options'  => crtools_getCoinList(),
            'default'  => array(),
        ),
        array(
            'id'       => 'crtools-table-graphLink',
            'type'     => 'checkbox',
            'title'    => __( 'Add Link On Graph 7D', 'crtools' ),
            'subtitle' => __( 'Set a graph as a link', 'crtools' ),
            'desc'     => __( '', 'crtools' ),
            'default'  => '1',
        ),
    )
) );


Redux::setSection( $opt_name, array(
    'title'      => __( 'Price List', 'crtools' ),
    'desc'       => __( '', 'crtools' ),
    'id'         => 'pricelist-subsection',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'       => 'crtools-pricelist-redColor',
            'type'     => 'color',
            'title'    => __( 'Red Color', 'crtools' ),
            'subtitle' => __( 'Pick a red color (default: #a11b09)', 'crtools' ),
            'default'  => '#a11b09',
            'transparent'  => false,
        ),
        array(
            'id'       => 'crtools-pricelist-greenColor',
            'type'     => 'color',
            'title'    => __( 'Green Color', 'crtools' ),
            'subtitle' => __( 'Pick a green color (default: #4caf50)', 'crtools' ),
            'default'  => '#4caf50',
            'transparent'  => false,
        ),
    )
) );

if (file_exists( CRTOOLS_PATH . '/readme.txt')) {
    Redux::setSection($opt_name, array(
        'title' => __('Documentation', 'crtools'),
        'id' => 'documentation',
        'icon' => 'el el-info-circle',
        'fields' => array(

        )
    ));
}

Redux::setSection( $opt_name, array(
    'title'      => __( 'General Info', 'crtools' ),
    'id'         => 'general-info-subsection',
    'subsection' => true,
    'fields'     => array(
        array(
            'id' => 'crtools-general-info',
            'type' => 'raw',
            'markdown' => true,
            'content' => file_get_contents(CRTOOLS_PATH . '/includes/GENERAL_INFO.md'),
        )
    )
) );

Redux::setSection( $opt_name, array(
    'title'      => __( 'Shortcodes', 'crtools' ),
    'id'         => 'shortcodes-subsection',
    'subsection' => true,
    'fields'     => array(
        array(
            'id' => 'crtools-shortcodes',
            'type' => 'raw',
            'markdown' => true,
            'content' => file_get_contents(CRTOOLS_PATH . '/includes/SHORTCODES.md'),
        )
    )
) );

Redux::setSection( $opt_name, array(
    'title'      => __( 'Localization', 'crtools' ),
    'id'         => 'localization-subsection',
    'subsection' => true,
    'fields'     => array(
        array(
            'id' => 'crtools-localization',
            'type' => 'raw',
            'markdown' => true,
            'content' => file_get_contents(CRTOOLS_PATH . '/includes/LOCALIZATION.md'),
        )
    )
) );


Redux::setSection( $opt_name, array(
    'title'      => __( 'Changelog', 'crtools' ),
    'id'         => 'changelog-subsection',
    'subsection' => true,
    'fields'     => array(
        array(
            'id' => 'crtools-changelog',
            'type' => 'raw',
            'markdown' => true,
            'content' => file_get_contents(CRTOOLS_PATH . '/includes/CHANGELOG.md'),
        )
    )
) );

