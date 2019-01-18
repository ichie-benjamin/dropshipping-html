<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

function crtools_table_shortcode( $atts )
{
    global $crtools_redux;

    crtools_iclude_scripts('table');

    $toolID = 'crtools-table-' . rand();

    $params = array(
        'toolID' => $toolID,
        'baseLink' => isset($crtools_redux['crtools-table-baseLink']) ? $crtools_redux['crtools-table-baseLink'] : '',
        'pageLinks' => isset($crtools_redux['crtools-table-pageLinks']) ? $crtools_redux['crtools-table-pageLinks'] : '',
        'graphLink' => $crtools_redux['crtools-table-graphLink'] ? true : false,

        'coin' => isset($atts['coin']) ? $atts['coin'] : '',
        'type' => isset($atts['type']) ? $atts['type'] : '',
        'fiat' => isset($atts['fiat']) ? $atts['fiat'] : '',
        'cols' => isset($atts['cols']) ? $atts['cols'] : '',
        'search' => isset($atts['search']) ? $atts['search'] : '',
        'pagination' =>isset($atts['pagination']) ? $atts['pagination'] : '',
    );

    //$class = get_table_class(); TODO get style
    $class = '';

    $html = '<div class="crtools-table"><table class="'.$class.'" id="'.$toolID.'" width="100%"></table></div><script>jQuery(document).ready(function(){ crtools.table.init('.json_encode($params).') })</script>';

    return $html;
}

function crtools_converter_shortcode( $atts )
{
    global $crtools_redux;

    crtools_iclude_scripts('converter');

    $toolID = 'crtools-converter-' . rand();

    $params = array(
        'toolID' => $toolID,
        'from' => isset($atts['from']) ? $atts['from'] : '',
        'to' => isset($atts['to']) ? $atts['to'] : '',
        'other' => isset($atts['other']) ? $atts['other'] : ''
    );

    $html = '<div class="crtools-converter" id="'.$toolID.'"></div><script>jQuery(document).ready(function(){ crtools.converter.init('.json_encode($params).') })</script>';

    return $html;
}

function crtools_graph_shortcode( $atts )
{
    global $crtools_redux;

    crtools_iclude_scripts('graph');

    $toolID = 'crtools-graph-' . rand();

    $params = array(
        'toolID' => $toolID,
        'graphColor' => isset($crtools_redux['crtools-graph-graphColor']) ? $crtools_redux['crtools-graph-graphColor'] : '',
        'cursorColor' => isset($crtools_redux['crtools-graph-cursorColor']) ? $crtools_redux['crtools-graph-cursorColor'] : '',

        'coin' => isset($atts['coin']) ? $atts['coin'] : '',
        'fiat' => isset($atts['fiat']) ? $atts['fiat'] : '',
        'period' => isset($atts['period']) ? $atts['period'] : '',
    );

    $html = '<div class="crtools-graph" id="'.$toolID.'"></div><script>jQuery(document).ready(function(){ crtools.graph.init('.json_encode($params).') })</script>';

    return $html;
}

function crtools_pricelist_shortcode( $atts )
{
    global $crtools_redux;

    crtools_iclude_scripts('pricelist');

    $toolID = 'crtools-pricelist-' . rand();

    $params = array(
        'toolID' => $toolID,
        'redColor' => isset($crtools_redux['crtools-pricelist-redColor']) ? $crtools_redux['crtools-pricelist-redColor'] : '',
        'greenColor' => isset($crtools_redux['crtools-pricelist-greenColor']) ? $crtools_redux['crtools-pricelist-greenColor'] : '',

        'coin' => isset($atts['coin']) ? $atts['coin'] : '',
        'fiat' => isset($atts['fiat']) ? $atts['fiat'] : '',
        'limit' => isset($atts['limit']) ? $atts['limit'] : '',
        'cols' => isset($atts['cols']) ? $atts['cols'] : '',
    );

    $html = '<div class="crtools-pricelist" id="'.$toolID.'"></div><script>jQuery(document).ready(function(){ crtools.pricelist.init('.json_encode($params).') })</script>';

    return $html;
}

function crtools_iclude_scripts( $type ) {

    switch($type)
    {
        case 'table':
            wp_enqueue_script( 'datatables', CRTOOLS_URL . 'assets/js/libs/datatables/jquery.dataTables.min.js');
            wp_enqueue_script( 'datatables-material', CRTOOLS_URL . 'assets/js/libs/datatables/dataTables.bootstrap.min.js');
            wp_enqueue_style('datatables-css-bootstrap-3', CRTOOLS_URL . 'assets/js/libs/datatables/bootstrap.min.css');
            wp_enqueue_style('datatables-css-bootstrap-3-datatables', CRTOOLS_URL . 'assets/js/libs/datatables/dataTables.bootstrap.min.css');
            wp_enqueue_script( 'chartjs', CRTOOLS_URL.'assets/js/libs/chartjs/Chart.bundle.min.js');

            /*// TODO get style
            $style = get_option('crtools_table_style');

            $styleData = array();


            if($style != 0)
            {
                $styles = json_decode(file_get_contents( CRTOOLS_URL.'assets/data/styles.txt'));

                foreach ($styles as $item)
                    if($style == $item->id)
                    {
                        $styleData = get_object_vars($item);
                        break;
                    }
            }

            if(!empty($styleData))
            {
                foreach ($styleData['css'] as $key=>$css)
                    wp_enqueue_style('datatables-css-'.$key , $css);

                foreach ($styleData['script'] as $key=>$script)
                    wp_enqueue_script('datatables-script-'.$key , $script);
            }*/

            break;

        case 'graph':

            wp_enqueue_script( 'amcharts-main', CRTOOLS_URL.'assets/js/libs/echarts/echarts.js');

            break;

        case 'converter':
        default:
            break;
    }
}

// TODO get style
/*function get_table_class( ) {

    $style = get_option('ctools_table_style');

    if($style != 0)
    {
        $styles = json_decode(file_get_contents( CRTOOLS_URL.'/assets/data/styles.txt'));

        foreach ($styles as $item)
            if($style == $item->id)
                return $item->class;
    }
}*/

function crtools_get_custom_css(){

    global $crtools_redux;

    if ($crtools_redux['crtools-css'] != ''){

        echo '

      <style type="text/css">

        '.$crtools_redux['crtools-css'].'

      </style>

    ';

    }

}