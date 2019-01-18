<?php
if ( ! defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly

/**
 * GDPR_Modules File Doc Comment
 *
 * @category GDPR_Modules
 * @package   gdpr-cookie-compliance
 * @author    Gaspar Nemes
 */

/**
 * GDPR_Modules Class Doc Comment
 *
 * @category Class
 * @package  Moove_Modules
 * @author   Gaspar Nemes
 */
class GDPR_Modules {
	protected $gdpr_options;
	protected $wpml_lang;
	/**
     * Construct function
     */
    public function __construct() {
    	$gdpr_default_content 	= new Moove_GDPR_Content();
	    $option_name    		= $gdpr_default_content->moove_gdpr_get_option_name();
	    $modal_options  		= get_option( $option_name );
	    $wpml_lang      		= $gdpr_default_content->moove_gdpr_get_wpml_lang();
	    $this->gdpr_options 	= $modal_options;
	    $this->wpml_lang 		= $wpml_lang;
    }

    public function get_floating_button() {
    	$view_controller 	= new GDPR_Modules_View();
    	$modal_options 		= $this->gdpr_options;
    	$wpml_lang 			= $this->wpml_lang;
	        
	    $floating_button_visibility    = 'display: block;';
	    $floating_button_class         = '';
	    $infobar_hidden                = isset( $modal_options['moove_gdpr_infobar_visibility'] ) && $modal_options['moove_gdpr_infobar_visibility'] === 'hidden' ? true : false;
	    if ( $infobar_hidden ) : 
	        $floating_button_class     = 'button-visible';
	    endif;
        $floating_button_position      = isset( $modal_options['moove_gdpr_floating_button_position'] ) ? $modal_options['moove_gdpr_floating_button_position'] : '';
	    $data               = new stdClass();
    	$data->options 		= $modal_options;
    	$data->wpml_lang 	= $wpml_lang;
    	$data->is_enabled 	= ( isset( $modal_options['moove_gdpr_floating_button_enable'] ) && intval( $modal_options['moove_gdpr_floating_button_enable'] ) === 1 ) ? true : false; 
    	$data->styles 		= $floating_button_visibility . $floating_button_position;
    	$data->class 		= $floating_button_class;
        if ( $floating_button_position ) :
            $data->class        = $floating_button_class .= ' gdpr-floating-button-custom-position';
        endif;
    	$data->label 		= ( isset( $modal_options['moove_gdpr_floating_button_label'.$wpml_lang] ) && $modal_options['moove_gdpr_floating_button_label'.$wpml_lang] ) ? $modal_options['moove_gdpr_floating_button_label'.$wpml_lang] : __('Change cookie settings','gdpr-cookie-compliance');

    	return $view_controller->load( 'infobar.floating-button', $data );
    }

    public function get_modal_base() {
        $view_controller        = new GDPR_Modules_View();
        $modal_options          = $this->gdpr_options;
        $wpml_lang              = $this->wpml_lang;
        $layout                 = isset( $modal_options['moove_gdpr_plugin_layout'] ) ? $modal_options['moove_gdpr_plugin_layout'] : 'v1';

        $tab_title              = isset( $modal_options['moove_gdpr_privacy_overview_tab_title'.$wpml_lang] ) && $modal_options['moove_gdpr_privacy_overview_tab_title'.$wpml_lang] ? $modal_options['moove_gdpr_privacy_overview_tab_title'.$wpml_lang] : __('Privacy Overview','gdpr-cookie-compliance');
        

        $data                   = new stdClass();
        $data->logo_position    = isset( $modal_options['moove_gdpr_logo_position'] ) ? $modal_options['moove_gdpr_logo_position'] : 'left';
        $data->theme            = $modal_theme    = 'moove_gdpr_modal_theme_' . $layout;
        $data->modal_title      = $layout === 'v1' ? false : $tab_title; 

        $view_type              = $layout === 'v1' ? 'tabs' : 'onepage';
        return $view_controller->load( 'modal.modal-base-' . $view_type, $data );
    }

    public function get_infobar_base() {
        $view_controller    = new GDPR_Modules_View();
        $modal_options      = $this->gdpr_options;
        $wpml_lang          = $this->wpml_lang;
        $data               = new stdClass();



        $infobar_classes    = array(
            'moove-gdpr-info-bar-hidden',
            'moove-gdpr-align-center',
        );
        $modal_scheme       = isset( $modal_options['moove_gdpr_colour_scheme'] ) ? ( ( intval( $modal_options['moove_gdpr_colour_scheme'] ) === 1 || intval( $modal_options['moove_gdpr_colour_scheme'] ) === 2 ) ? intval( $modal_options['moove_gdpr_colour_scheme'] ) : 1 ) : 1;

        $scheme_class       = $modal_scheme === 2 ? 'moove-gdpr-light-scheme' : 'moove-gdpr-dark-scheme';


        $infobar_position   = isset( $modal_options['moove_gdpr_infobar_position'] ) ? $modal_options['moove_gdpr_infobar_position'] : 'bottom';
        $infobar_classes[]  = $scheme_class;
        $infobar_classes[]  = 'gdpr_infobar_postion_' . $infobar_position;
        $infobar_classes    = apply_filters( 'gdpr_info_bar_class_extension', $infobar_classes );
        $infobar_hidden     = isset( $modal_options['moove_gdpr_infobar_visibility'] ) && $modal_options['moove_gdpr_infobar_visibility'] === 'hidden' ? true : false;

        $data->show         = $infobar_hidden ? false : true;
        $data->class        = implode( ' ', $infobar_classes );

   
        $infobar_content    = apply_filters( 'gdpr_info_bar_popup_content', $view_controller->load( 'infobar.infobar-base', $data ) );

        return $infobar_content;

    }

    public function get_infobar_content() {
        $view_controller    = new GDPR_Modules_View();
        $modal_options      = $this->gdpr_options;
        $wpml_lang          = $this->wpml_lang;
        
        $_content = '<p>'.__('We are using cookies to give you the best experience on our website.','gdpr-cookie-compliance').'</p>'.
        '<p>'.__('You can find out more about which cookies we are using or switch them off in [setting]settings[/setting].','gdpr-cookie-compliance').'</p>';
        $content = isset( $modal_options['moove_gdpr_info_bar_content'.$wpml_lang] ) && $modal_options['moove_gdpr_info_bar_content'.$wpml_lang] ? $modal_options['moove_gdpr_info_bar_content'.$wpml_lang] : $_content;
        $content = str_replace('[setting]', '<span data-href="#moove_gdpr_cookie_modal" class="change-settings-button">', $content);
        $content = str_replace('[/setting]', '</span>', $content);
        $content = apply_filters( 'gdpr_info_bar_notice_content', $content );
        $data               = new stdClass();
        $data->text_content = $content;
        return $view_controller->load( 'infobar.infobar-content', $data );
    }

    public function get_infobar_buttons() {    	
        $view_controller    = new GDPR_Modules_View();
        $modal_options      = $this->gdpr_options;
        $wpml_lang          = $this->wpml_lang;

        $data               = new stdClass();
        $data->button_label = isset( $modal_options['moove_gdpr_infobar_accept_button_label'.$wpml_lang] ) && $modal_options['moove_gdpr_infobar_accept_button_label'.$wpml_lang] ? $modal_options['moove_gdpr_infobar_accept_button_label'.$wpml_lang] : __('Accept','gdpr-cookie-compliance');
        return $view_controller->load( 'infobar.infobar-buttons', $data );

    }    

    public function get_company_logo() {
        $view_controller    = new GDPR_Modules_View();
        $modal_options      = $this->gdpr_options;
        $wpml_lang          = $this->wpml_lang;
        $data               = new stdClass();
        $data->options      = $modal_options;
        $data->wpml_lang    = $wpml_lang;
        $data->logo_url     = isset( $modal_options['moove_gdpr_company_logo'] ) && $modal_options['moove_gdpr_company_logo'] ? $modal_options['moove_gdpr_company_logo'] :  plugin_dir_url( __FILE__ ) . 'dist/images/gdpr-logo.png';
        $data->logo_url     = str_replace( plugin_dir_url( __FILE__ ) . 'dist/images/moove-logo.png', plugin_dir_url( __FILE__ ) . 'dist/images/gdpr-logo.png', $data->logo_url );
        $data->logo_alt     = gdpr_get_logo_alt( $data->logo_url );
        return $view_controller->load( 'modal.company-logo', $data );
    }

    public function get_gdpr_branding() {
        $view_controller    = new GDPR_Modules_View();
        $moove_actions_cnt  = new Moove_GDPR_Actions();
        $modal_options      = $this->gdpr_options;
        $wpml_lang          = $this->wpml_lang;
        $data               = new stdClass();
        $data->options      = $modal_options;
        $data->wpml_lang    = $wpml_lang;
        $data->text         = $moove_actions_cnt->moove_gdpr_footer_branding_content();        

        $data->is_enabled   = isset( $modal_options['moove_gdpr_modal_powered_by_disable'] ) && intval( $modal_options['moove_gdpr_modal_powered_by_disable'] === 1 ) ? false : true; 

        return $view_controller->load( 'modal.gdpr-branding', $data );
    }

    public function get_section_overview() {
        $view_controller        = new GDPR_Modules_View();
        $modal_options          = $this->gdpr_options;
        $wpml_lang              = $this->wpml_lang;
        $gdpr_default_content   = new Moove_GDPR_Content();

        $layout                 = isset( $modal_options['moove_gdpr_plugin_layout'] ) ? $modal_options['moove_gdpr_plugin_layout'] : 'v1';
        $tab_title              = isset( $modal_options['moove_gdpr_privacy_overview_tab_title'.$wpml_lang] ) && $modal_options['moove_gdpr_privacy_overview_tab_title'.$wpml_lang] ? $modal_options['moove_gdpr_privacy_overview_tab_title'.$wpml_lang] : __('Privacy Overview','gdpr-cookie-compliance');
        $tab_content  = isset( $modal_options['moove_gdpr_privacy_overview_tab_content'.$wpml_lang] ) && $modal_options['moove_gdpr_privacy_overview_tab_content'.$wpml_lang] ? $modal_options['moove_gdpr_privacy_overview_tab_content'.$wpml_lang] : $gdpr_default_content->moove_gdpr_get_privacy_overview_content();

        $data                   = new stdClass();
        $data->options          = $modal_options;
        $data->wpml_lang        = $wpml_lang;
        $data->tab_title        = $layout === 'v1' ? $tab_title : false;
        $data->tab_content      = wpautop( $tab_content );
        $data->visibility       = $layout === 'v1' ? 'style="display:none"' : '';

        return $view_controller->load( 'modal.content-sections.overview', $data );

    }
              
    public function get_section_strictly() {
        $view_controller        = new GDPR_Modules_View();
        $modal_options          = $this->gdpr_options;
        $wpml_lang              = $this->wpml_lang;
        $gdpr_default_content   = new Moove_GDPR_Content();

        $layout                 = isset( $modal_options['moove_gdpr_plugin_layout'] ) ? $modal_options['moove_gdpr_plugin_layout'] : 'v1';
        $tab_title              = isset( $modal_options['moove_gdpr_strictly_necessary_cookies_tab_title'.$wpml_lang] ) && $modal_options['moove_gdpr_strictly_necessary_cookies_tab_title'.$wpml_lang] ? $modal_options['moove_gdpr_strictly_necessary_cookies_tab_title'.$wpml_lang] : __('Strictly Necessary Cookies','gdpr-cookie-compliance');
        $tab_content            = isset( $modal_options['moove_gdpr_strict_necessary_cookies_tab_content'.$wpml_lang] ) && $modal_options['moove_gdpr_strict_necessary_cookies_tab_content'.$wpml_lang] ? $modal_options['moove_gdpr_strict_necessary_cookies_tab_content'.$wpml_lang] : $gdpr_default_content->moove_gdpr_get_strict_necessary_content();

        $strictly               = isset( $modal_options['moove_gdpr_strictly_necessary_cookies_functionality'] ) && intval( $modal_options['moove_gdpr_strictly_necessary_cookies_functionality'] ) ? intval( $modal_options['moove_gdpr_strictly_necessary_cookies_functionality'] ) : 1;
        $warning_msg            = isset( $modal_options['moove_gdpr_strictly_necessary_cookies_warning'.$wpml_lang] ) && $modal_options['moove_gdpr_strictly_necessary_cookies_warning'.$wpml_lang] ? $modal_options['moove_gdpr_strictly_necessary_cookies_warning'.$wpml_lang] : $gdpr_default_content->moove_gdpr_get_strict_necessary_warning();

        $data                           = new stdClass();
        $data->options                  = $modal_options;
        $data->wpml_lang                = $wpml_lang;
        $data->tab_title                = $tab_title;
        $data->tab_content              = wpautop( $tab_content );
        $data->show                     = $strictly !== 3;
        $data->is_checked               = $strictly !== 1 ? 'disabled checked="checked" ' : '';
        $data->text_enable              = isset( $modal_options['moove_gdpr_modal_enabled_checkbox_label'.$wpml_lang] ) && $modal_options['moove_gdpr_modal_enabled_checkbox_label'.$wpml_lang] ? $modal_options['moove_gdpr_modal_enabled_checkbox_label'.$wpml_lang] : __('Enabled','gdpr-cookie-compliance');
        $data->text_disable             = isset( $modal_options['moove_gdpr_modal_disabled_checkbox_label'.$wpml_lang] ) && $modal_options['moove_gdpr_modal_disabled_checkbox_label'.$wpml_lang] ? $modal_options['moove_gdpr_modal_disabled_checkbox_label'.$wpml_lang] : __('Disabled','gdpr-cookie-compliance');
        $data->warning_message_top      = $layout === 'v2' ? wpautop( $warning_msg ) : false;
        $data->warning_message_bottom   = $layout === 'v1' ? wpautop( $warning_msg ) : false;
        $data->checkbox_state           = $strictly !== 1 ? 'gdpr-checkbox-disabled checkbox-selected' : '';
        $data->visibility               = $layout === 'v1' ? 'style="display:none"' : '';

        return $view_controller->load( 'modal.content-sections.strictly', $data );
    }
            
    public function get_section_advanced() {
        $view_controller        = new GDPR_Modules_View();
        $modal_options          = $this->gdpr_options;
        $wpml_lang              = $this->wpml_lang;
        $gdpr_default_content   = new Moove_GDPR_Content();

        $layout                 = isset( $modal_options['moove_gdpr_plugin_layout'] ) ? $modal_options['moove_gdpr_plugin_layout'] : 'v1';
        $tab_title              = isset( $modal_options['moove_gdpr_advanced_cookies_tab_title'.$wpml_lang] ) && $modal_options['moove_gdpr_advanced_cookies_tab_title'.$wpml_lang] ? $modal_options['moove_gdpr_advanced_cookies_tab_title'.$wpml_lang] : __('Additional Cookies'.$wpml_lang,'gdpr-cookie-compliance');
        $tab_content            = isset( $modal_options['moove_gdpr_advanced_cookies_tab_content'.$wpml_lang] ) && $modal_options['moove_gdpr_advanced_cookies_tab_content'.$wpml_lang] ? $modal_options['moove_gdpr_advanced_cookies_tab_content'.$wpml_lang] : $gdpr_default_content->moove_gdpr_get_advanced_cookies_content();
        $strictly               = isset( $modal_options['moove_gdpr_strictly_necessary_cookies_functionality'] ) && intval( $modal_options['moove_gdpr_strictly_necessary_cookies_functionality'] ) ? intval( $modal_options['moove_gdpr_strictly_necessary_cookies_functionality'] ) : 1;

        $data                           = new stdClass();
        $data->options                  = $modal_options;
        $data->wpml_lang                = $wpml_lang;
        $data->tab_title                = $tab_title;
        $data->tab_content              = wpautop( $tab_content );
        $data->show                     = isset( $modal_options['moove_gdpr_advanced_cookies_enable'] ) && intval( $modal_options['moove_gdpr_advanced_cookies_enable'] ) === 1 ? true : false;
        $data->is_checked               = $strictly !== 1 ? '' : 'disabled';
        $data->fieldset                 = $strictly !== 1 ? 'fl-strenabled' : 'fl-disabled';
        $data->text_enable              = isset( $modal_options['moove_gdpr_modal_enabled_checkbox_label'.$wpml_lang] ) && $modal_options['moove_gdpr_modal_enabled_checkbox_label'.$wpml_lang] ? $modal_options['moove_gdpr_modal_enabled_checkbox_label'.$wpml_lang] : __('Enabled','gdpr-cookie-compliance');
        $data->text_disable             = isset( $modal_options['moove_gdpr_modal_disabled_checkbox_label'.$wpml_lang] ) && $modal_options['moove_gdpr_modal_disabled_checkbox_label'.$wpml_lang] ? $modal_options['moove_gdpr_modal_disabled_checkbox_label'.$wpml_lang] : __('Disabled','gdpr-cookie-compliance');
        $data->warning_message          = isset( $modal_options['moove_gdpr_modal_strictly_secondary_notice'.$wpml_lang] ) && $modal_options['moove_gdpr_modal_strictly_secondary_notice'.$wpml_lang] ? $modal_options['moove_gdpr_modal_strictly_secondary_notice'.$wpml_lang] : $gdpr_default_content->moove_gdpr_get_secondary_notice();
        $data->visibility               = $layout === 'v1' ? 'style="display:none"' : '';

        return $view_controller->load( 'modal.content-sections.advanced', $data );
    }
              
    public function get_section_third_party() {
        $view_controller        = new GDPR_Modules_View();
        $modal_options          = $this->gdpr_options;
        $wpml_lang              = $this->wpml_lang;
        $gdpr_default_content   = new Moove_GDPR_Content();

        $layout                 = isset( $modal_options['moove_gdpr_plugin_layout'] ) ? $modal_options['moove_gdpr_plugin_layout'] : 'v1';
        $tab_title              = isset( $modal_options['moove_gdpr_performance_cookies_tab_title'.$wpml_lang] ) && $modal_options['moove_gdpr_performance_cookies_tab_title'.$wpml_lang] ? $modal_options['moove_gdpr_performance_cookies_tab_title'.$wpml_lang] : __('3rd Party Cookies','gdpr-cookie-compliance');
        $tab_content            = isset( $modal_options['moove_gdpr_performance_cookies_tab_content'.$wpml_lang] ) && $modal_options['moove_gdpr_performance_cookies_tab_content'.$wpml_lang] ? $modal_options['moove_gdpr_performance_cookies_tab_content'.$wpml_lang] : $gdpr_default_content->moove_gdpr_get_third_party_content();
        $strictly               = isset( $modal_options['moove_gdpr_strictly_necessary_cookies_functionality'] ) && intval( $modal_options['moove_gdpr_strictly_necessary_cookies_functionality'] ) ? intval( $modal_options['moove_gdpr_strictly_necessary_cookies_functionality'] ) : 1;

        $data                           = new stdClass();
        $data->options                  = $modal_options;
        $data->wpml_lang                = $wpml_lang;
        $data->tab_title                = $tab_title;
        $data->tab_content              = wpautop( $tab_content );
        $data->show                     = isset( $modal_options['moove_gdpr_third_party_cookies_enable'] ) && intval( $modal_options['moove_gdpr_third_party_cookies_enable'] ) === 1 ? true : false;
        $data->is_checked               = $strictly !== 1 ? '' : 'disabled';
        $data->fieldset                 = $strictly !== 1 ? 'fl-strenabled' : 'fl-disabled';
        $data->text_enable              = isset( $modal_options['moove_gdpr_modal_enabled_checkbox_label'.$wpml_lang] ) && $modal_options['moove_gdpr_modal_enabled_checkbox_label'.$wpml_lang] ? $modal_options['moove_gdpr_modal_enabled_checkbox_label'.$wpml_lang] : __('Enabled','gdpr-cookie-compliance');
        $data->text_disable             = isset( $modal_options['moove_gdpr_modal_disabled_checkbox_label'.$wpml_lang] ) && $modal_options['moove_gdpr_modal_disabled_checkbox_label'.$wpml_lang] ? $modal_options['moove_gdpr_modal_disabled_checkbox_label'.$wpml_lang] : __('Disabled','gdpr-cookie-compliance');
        $data->warning_message          = isset( $modal_options['moove_gdpr_modal_strictly_secondary_notice'.$wpml_lang] ) && $modal_options['moove_gdpr_modal_strictly_secondary_notice'.$wpml_lang] ? $modal_options['moove_gdpr_modal_strictly_secondary_notice'.$wpml_lang] : $gdpr_default_content->moove_gdpr_get_secondary_notice();
        $data->visibility               = $layout === 'v1' ? 'style="display:none"' : '';
        
        return $view_controller->load( 'modal.content-sections.third_party', $data );
    }   

    public function get_branding_styles() {
        $view_controller        = new GDPR_Modules_View();
        $modal_options          = $this->gdpr_options;
        $wpml_lang              = $this->wpml_lang;
        $font_family            = false;
        if ( isset( $modal_options['moove_gdpr_plugin_font_type'] ) ) :
            if (  $modal_options['moove_gdpr_plugin_font_type'] === '1' ) :
                $font_family = "'Nunito', sans-serif";
            elseif ( $modal_options['moove_gdpr_plugin_font_type'] === '2' ) :
                $font_family = "inherit";
            else :
                $font_family = isset( $modal_options['moove_gdpr_plugin_font_family'] ) && $modal_options['moove_gdpr_plugin_font_family'] ? $modal_options['moove_gdpr_plugin_font_family'] : "'Nunito', sans-serif";
            endif;
        endif;

        $font_family        = $font_family ? $font_family : ( isset( $modal_options['moove_gdpr_plugin_font_family'] ) && $modal_options['moove_gdpr_plugin_font_family'] ? $modal_options['moove_gdpr_plugin_font_family'] : "'Nunito', sans-serif" );

        $data                       = new stdClass();
        $data->primary_colour       = isset( $modal_options['moove_gdpr_brand_colour'] ) && $modal_options['moove_gdpr_brand_colour'] ? $modal_options['moove_gdpr_brand_colour'] : '#0C4DA2';
        $data->secondary_colour     = isset( $modal_options['moove_gdpr_brand_secondary_colour'] ) && $modal_options['moove_gdpr_brand_secondary_colour'] ? $modal_options['moove_gdpr_brand_secondary_colour'] : '#000000';
        $data->button_bg            = isset( $modal_options['moove_gdpr_floating_button_background_colour'] ) && $modal_options['moove_gdpr_floating_button_background_colour'] ? $modal_options['moove_gdpr_floating_button_background_colour'] : '#373737';
        $data->button_hover_bg      = isset( $modal_options['moove_gdpr_floating_button_hover_background_colour'] ) && $modal_options['moove_gdpr_floating_button_hover_background_colour'] ? $modal_options['moove_gdpr_floating_button_hover_background_colour'] : '#000000';
        $data->button_font          = isset( $modal_options['moove_gdpr_floating_button_font_colour'] ) && $modal_options['moove_gdpr_floating_button_font_colour'] ? $modal_options['moove_gdpr_floating_button_font_colour'] : '#ffffff';
        $data->font_family          = $font_family;

        return $view_controller->load( 'branding-styles', $data );

    }
               
    public function get_section_cookiepolicy() {
        $view_controller        = new GDPR_Modules_View();
        $modal_options          = $this->gdpr_options;
        $wpml_lang              = $this->wpml_lang;
        $gdpr_default_content   = new Moove_GDPR_Content();

        $layout                 = isset( $modal_options['moove_gdpr_plugin_layout'] ) ? $modal_options['moove_gdpr_plugin_layout'] : 'v1';
        $tab_title              = isset( $modal_options['moove_gdpr_cookie_policy_tab_nav_label'.$wpml_lang] ) && $modal_options['moove_gdpr_cookie_policy_tab_nav_label'.$wpml_lang] ? $modal_options['moove_gdpr_cookie_policy_tab_nav_label'.$wpml_lang] : __('3rd Party Cookies','gdpr-cookie-compliance');
        $tab_content            = isset( $modal_options['moove_gdpr_cookies_policy_tab_content'.$wpml_lang] ) && $modal_options['moove_gdpr_cookies_policy_tab_content'.$wpml_lang] ? $modal_options['moove_gdpr_cookies_policy_tab_content'.$wpml_lang] : $gdpr_default_content->moove_gdpr_get_cookie_policy_content();

        $data                           = new stdClass();
        $data->options                  = $modal_options;
        $data->wpml_lang                = $wpml_lang;
        $data->tab_title                = $tab_title;
        $data->tab_content              = wpautop( $tab_content );
        $data->show                     = isset( $modal_options['moove_gdpr_cookie_policy_enable'] ) && intval( $modal_options['moove_gdpr_cookie_policy_enable'] ) === 1 ? true : false;
        $data->visibility               = $layout === 'v1' ? 'style="display:none"' : '';
        
        return $view_controller->load( 'modal.content-sections.cookiepolicy', $data );
    }
               


    public function get_tab_footer_buttons() {
    	$view_controller       = new GDPR_Modules_View();
        $modal_options          = $this->gdpr_options;
        $wpml_lang              = $this->wpml_lang;
        $data                   = new stdClass();
        $data->allow_label      = isset( $modal_options['moove_gdpr_modal_allow_button_label'.$wpml_lang] ) && $modal_options['moove_gdpr_modal_allow_button_label'.$wpml_lang] ? $modal_options['moove_gdpr_modal_allow_button_label'.$wpml_lang] : __('Enable All','gdpr-cookie-compliance');
        $data->settings_label   = isset( $modal_options['moove_gdpr_modal_save_button_label'.$wpml_lang] ) && $modal_options['moove_gdpr_modal_save_button_label'.$wpml_lang] ? $modal_options['moove_gdpr_modal_save_button_label'.$wpml_lang] : __('Save Settings','gdpr-cookie-compliance');

        return $view_controller->load( 'modal.tab-footer-buttons', $data );
    }

    public function get_tab_navigation() {
    	$view_controller           = new GDPR_Modules_View();
        $modal_options              = $this->gdpr_options;
        $wpml_lang                  = $this->wpml_lang;
        $strictly                   = isset( $modal_options['moove_gdpr_strictly_necessary_cookies_functionality'] ) && intval( $modal_options['moove_gdpr_strictly_necessary_cookies_functionality'] ) ? intval( $modal_options['moove_gdpr_strictly_necessary_cookies_functionality'] ) : 1;
        $data                       = new stdClass();
        $data->overview             = new stdClass();
        $data->strictly             = new stdClass();
        $data->advanced             = new stdClass();
        $data->third_party          = new stdClass();
        $data->cookiepolicy         = new stdClass();

        // OVERVIEW
        $data->overview->nav_label  = isset( $modal_options['moove_gdpr_privacy_overview_tab_title'.$wpml_lang] ) && $modal_options['moove_gdpr_privacy_overview_tab_title'.$wpml_lang] ? $modal_options['moove_gdpr_privacy_overview_tab_title'.$wpml_lang] : __('Privacy Overview','gdpr-cookie-compliance');

        // STRICTLY
        $data->strictly->show       = $strictly !== 3;
        $data->strictly->nav_label  = isset( $modal_options['moove_gdpr_strictly_necessary_cookies_tab_title'.$wpml_lang] ) && $modal_options['moove_gdpr_strictly_necessary_cookies_tab_title'.$wpml_lang] ? $modal_options['moove_gdpr_strictly_necessary_cookies_tab_title'.$wpml_lang] : __('Strictly Necessary Cookies','gdpr-cookie-compliance');

        // THIRD PARTY
        $data->third_party->show      = isset( $modal_options['moove_gdpr_third_party_cookies_enable'] ) && intval( $modal_options['moove_gdpr_third_party_cookies_enable'] ) === 1 ? true : false;
        $data->third_party->nav_label = isset( $modal_options['moove_gdpr_performance_cookies_tab_title'.$wpml_lang] ) && $modal_options['moove_gdpr_performance_cookies_tab_title'.$wpml_lang] ? $modal_options['moove_gdpr_performance_cookies_tab_title'.$wpml_lang] : __('3rd Party Cookies','gdpr-cookie-compliance');

        // ADVANCED
        $data->advanced->show       = isset( $modal_options['moove_gdpr_advanced_cookies_enable'] ) && intval( $modal_options['moove_gdpr_advanced_cookies_enable'] ) === 1 ? true : false;
        $data->advanced->nav_label  = isset( $modal_options['moove_gdpr_advanced_cookies_tab_title'.$wpml_lang] ) && $modal_options['moove_gdpr_advanced_cookies_tab_title'.$wpml_lang] ? $modal_options['moove_gdpr_advanced_cookies_tab_title'.$wpml_lang] : __('Additional Cookies','gdpr-cookie-compliance');

        // COOKIEPOLICY
        $data->cookiepolicy->show       = isset( $modal_options['moove_gdpr_cookie_policy_enable'] ) && intval( $modal_options['moove_gdpr_cookie_policy_enable'] ) === 1 ? true : false;
        $data->cookiepolicy->nav_label  = isset( $modal_options['moove_gdpr_cookie_policy_tab_nav_label'.$wpml_lang] ) && $modal_options['moove_gdpr_cookie_policy_tab_nav_label'.$wpml_lang] ? $modal_options['moove_gdpr_cookie_policy_tab_nav_label'.$wpml_lang] : __('Cookie Policy','gdpr-cookie-compliance');



        return $view_controller->load( 'modal.tab-navigation', $data );
    }

}