<?php
/**
 * Plugin Name: Cryptocurrency Rocket Tools
 * Description: Price ticker, table, graph, converter, price list of all cryptocurrencies.
 * Version: 2.2
 * Author: Webstulle
 * Author URI: http://webstulle.com/
 * Text Domain: cryptocurrency-rocket-tools
 * Domain Path: /languages
 * License: GPL2 or later
 *
 * @package Cryptocurrency Rocket Tools
 */


// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


// Define plugin url global
define('CRTOOLS_URL', plugin_dir_url( __FILE__ ));

define('CRTOOLS_PATH', plugin_dir_path( __FILE__ ));

define('CRTOOLS_MAIN_FILE', __FILE__ );

define('CMC_API_URL', 'https://api.coinmarketcap.com' );


// Define Redux Framework
if ( !class_exists( 'ReduxFramework' ) && file_exists( dirname( __FILE__ ) . '/frameworks/ReduxFramework/ReduxCore/framework.php' ) ) {
    require_once( dirname( __FILE__ ) . '/frameworks/ReduxFramework/ReduxCore/framework.php' );
}
if ( !isset( $crtools_redux ) && file_exists( dirname( __FILE__ ) . '/includes/admin-config.php' ) ) {
    require_once( dirname( __FILE__ ) . '/includes/admin-config.php' );
}


// Localization
function crtools_textdomain() {
    load_plugin_textdomain( 'cryptocurrency-rocket-tools', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'crtools_textdomain' );


// Difine assets
function crtools() {

    global $crtoolsVars;
    include_once( dirname(__FILE__) . '/includes/messages.php');

    wp_enqueue_script( 'jquery');

    wp_enqueue_script( 'crtools', CRTOOLS_URL.'assets/js/crtools.min.js');
    wp_localize_script('crtools', 'crtoolsVars', $crtoolsVars );

    wp_enqueue_style( 'crtools-css', CRTOOLS_URL.'assets/css/main.css');
}
add_action( 'wp_enqueue_scripts', 'crtools' );


// Define supported shortcodes
require_once(dirname(__FILE__) . '/includes/shortcodes.php');
add_shortcode( 'crtools-table', 'crtools_table_shortcode' );
add_shortcode( 'crtools-converter', 'crtools_converter_shortcode' );
add_shortcode( 'crtools-graph', 'crtools_graph_shortcode' );
add_shortcode( 'crtools-pricelist', 'crtools_pricelist_shortcode' );


// Add custom CSS
add_action('wp_head', 'crtools_get_custom_css', 1000);


// For Redux admin panel
function crtools_getCoinList()
{
    header('Access-Control-Allow-Origin: *');
    $data = json_decode(file_get_contents(CMC_API_URL . '/v1/ticker/?limit=10000'), true);

    if(!empty($data))
        foreach ($data as $coin)
            $coinList[$coin['symbol']] = $coin['name'];

    return $coinList;
}

