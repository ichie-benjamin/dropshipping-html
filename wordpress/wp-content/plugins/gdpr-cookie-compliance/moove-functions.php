<?php
if ( ! defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly

/**
 * Moove_Functions File Doc Comment
 *
 * @category Moove_Functions
 * @package   gdpr-cookie-compliance
 * @author    Gaspar Nemes
 */
function moove_gdpr_get_plugin_directory_url() {
	return plugin_dir_url( __FILE__ );
}

add_filter( 'plugin_action_links', 'moove_gdpr_plugin_settings_link', 10, 2 );

function moove_gdpr_plugin_settings_link( $links, $file ) {
	if ( plugin_basename( dirname( __FILE__ ) . '/moove-gdpr.php' ) === $file ) {
		/*
         * Insert the settings page link at the beginning
         */
		$in = '<a href="options-general.php?page=moove-gdpr">' . __( 'Settings','gdpr-cookie-compliance' ) . '</a>';
		array_unshift( $links, $in );

	}
	return $links;
}

/**
 * Get an attachment ID given a URL.
 * 
 * @param string $url
 *
 * @return int Attachment ID on success, 0 on failure
 */
function gdpr_get_attachment_id( $url ) {

    $attachment_id = 0;

    $dir = wp_upload_dir();

    if ( false !== strpos( $url, $dir['baseurl'] . '/' ) ) { // Is URL in uploads directory?

        $file = basename( $url );

        $query_args = array(
            'post_type'   => 'attachment',
            'post_status' => 'inherit',
            'fields'      => 'ids',
            'meta_query'  => array(
                array(
                    'value'   => $file,
                    'compare' => 'LIKE',
                    'key'     => '_wp_attachment_metadata',
                ),
            )
        );

        $query = new WP_Query( $query_args );

        if ( $query->have_posts() ) {

            while ( $query->have_posts() ) : $query->the_post(); 
                $post_id = get_the_ID();

                $meta = wp_get_attachment_metadata( $post_id );
                if ( $meta && isset( $meta['file'] ) && isset( $meta['sizes'] ) ) :
                    $original_file       = basename( $meta['file'] );
                    $cropped_image_files = wp_list_pluck( $meta['sizes'], 'file' );

                    if ( $original_file === $file || in_array( $file, $cropped_image_files ) ) {
                        $attachment_id = $post_id;
                        break;
                    }
                endif;

            endwhile;
            wp_reset_query();
            wp_reset_postdata();

        }

    }

    return $attachment_id;
}

/**
 * Get image alt text by image URL
 *
 * @param String $image_url
 *
 * @return Bool | String
 */
function gdpr_get_logo_alt( $image_url ) {

    global $wpdb;

    if ( empty( $image_url ) ) {
        return get_bloginfo('name');
    }
    $image_id   = gdpr_get_attachment_id( $image_url );
    if ( $image_id ) :
    	$image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
    	return $image_alt;
    else :
    	return get_bloginfo('name');
    endif;

}

function gdpr_get_module( $module = '' ) {
    if ( $module ) :
        $module_controller = new GDPR_Modules();
        switch ( $module ) :
            case 'floating-button':
                return apply_filters( 'gdpr_floating_button_module', $module_controller->get_floating_button() );
                break;
            case 'infobar-base':
                return apply_filters( 'gdpr_infobar_base_module', $module_controller->get_infobar_base() );
                break;
            case 'infobar-content':
                return apply_filters( 'gdpr_infobar_content_module', $module_controller->get_infobar_content() );
                break;
            case 'infobar-buttons':
                return apply_filters( 'gdpr_infobar_buttons_module', $module_controller->get_infobar_buttons() );
                break;
            case 'company-logo':
                return apply_filters( 'gdpr_company_logo_module', $module_controller->get_company_logo() );
                break;
            case 'gdpr-branding':
                return apply_filters( 'gdpr_branding_module', $module_controller->get_gdpr_branding() );
                break;
            case 'modal-base' :
                return apply_filters( 'gdpr_modal_base_module', $module_controller->get_modal_base() );
                break;
            case 'tab-navigation' :
                return apply_filters( 'gdpr_tab_navigation_module', $module_controller->get_tab_navigation() );
                break;
            case 'modal-footer-buttons' :
                return apply_filters( 'gdpr_modal_footer_buttons_module', $module_controller->get_tab_footer_buttons() );
                break;
            case 'section-overview' :
                return apply_filters( 'gdpr_section_overview_module', $module_controller->get_section_overview() );
                break;
            case 'section-strictly' :
                return apply_filters( 'gdpr_section_strictly_module', $module_controller->get_section_strictly() );
                break;
            case 'section-advanced' :
                return apply_filters( 'gdpr_section_advanced_module', $module_controller->get_section_advanced() );
                break;
            case 'section-third_party' :
                return apply_filters( 'gdpr_section_third_party_module', $module_controller->get_section_third_party() );
                break;
            case 'section-cookiepolicy' :
                return apply_filters( 'gdpr_section_cookiepolicy_module', $module_controller->get_section_cookiepolicy() );
                break;
            case 'branding-styles' :
                return apply_filters( 'gdpr_branding_styles_module', $module_controller->get_branding_styles() );
                break;               

        endswitch;
    endif;
    return false;
}

/**
 * Checking accepted cookie values by type
 */

if ( ! function_exists( 'gdpr_cookie_is_accepted' ) ) :
    function gdpr_cookie_is_accepted( $type = '' ) {
        $response   = false;
        $type       = sanitize_text_field( $type );
        $accepted_types = array( 'strict', 'thirdparty', 'advanced' );
        if ( $type  && in_array( $type, $accepted_types ) ) :
            $gdpr_content   = new Moove_GDPR_Content();
            $php_cookies    = $gdpr_content->gdpr_get_php_cookies();
            $response       = $php_cookies && isset( $php_cookies[ $type ] ) && $php_cookies[ $type ] ? true : false;
        endif;
        return $response;
    }
endif;