<?php
    $gdpr_default_content = new Moove_GDPR_Content();
    $option_name    = $gdpr_default_content->moove_gdpr_get_option_name();
    $gdpr_options   = get_option( $option_name );
    $wpml_lang      = $gdpr_default_content->moove_gdpr_get_wpml_lang();
    $gdpr_options   = is_array( $gdpr_options ) ? $gdpr_options : array();
    if ( isset( $_POST ) && isset( $_POST['moove_gdpr_nonce'] ) ) :
        $nonce = sanitize_key( $_POST['moove_gdpr_nonce'] );
        if ( ! wp_verify_nonce( $nonce, 'moove_gdpr_nonce_field' ) ) :
            die( 'Security check' );
        else :
            if ( is_array( $_POST ) ) :               
                foreach ( $_POST as $form_key => $form_value ) :
                    if ( $form_key === 'moove_gdpr_info_bar_content' ) :
                        $value  = wpautop( wp_unslash( $form_value ) );
                        $gdpr_options[$form_key.$wpml_lang] = $value;
                        update_option( $option_name, $gdpr_options );
                        $gdpr_options = get_option( $option_name );
                    elseif ( $form_key === 'moove_gdpr_modal_strictly_secondary_notice' . $wpml_lang ) :
                        $value  = wpautop( wp_unslash( $form_value ) );
                        $gdpr_options[$form_key] = $value;
                        update_option( $option_name, $gdpr_options );
                        $gdpr_options = get_option( $option_name );
                    elseif ( $form_key !== 'moove_gdpr_floating_button_enable' ) :
                        $value  = sanitize_text_field( wp_unslash( $form_value ) );
                        $gdpr_options[$form_key] = $value;
                        update_option( $option_name, $gdpr_options );
                        $gdpr_options = get_option( $option_name );
                    endif;
                endforeach;
            endif;
            do_action('gdpr_cookie_filter_settings');
            ?>
                <script>
                    jQuery('#moove-gdpr-setting-error-settings_updated').show();
                </script>
            <?php
        endif;
    endif;
?>
<form action="?page=moove-gdpr&amp;tab=banner_settings" method="post" id="moove_gdpr_tab_banner_settings">
    <?php wp_nonce_field( 'moove_gdpr_nonce_field', 'moove_gdpr_nonce' ); ?>
    <h2><?php _e('Cookie Banner Settings','gdpr-cookie-compliance'); ?></h2>
    <hr />

    <table class="form-table">
        <tbody>
            <tr>
                <th scope="row" colspan="2" style="padding-bottom: 0;">
                    <label for="moove_gdpr_info_bar_content"><?php _e('Cookie Banner Content','gdpr-cookie-compliance'); ?></label>
                </th>
            </tr>

            <tr class="moove_gdpr_table_form_holder">
                <th colspan="2" scope="row">
                    <?php
                        $content =  isset( $gdpr_options['moove_gdpr_info_bar_content'.$wpml_lang] ) && $gdpr_options['moove_gdpr_info_bar_content'.$wpml_lang] ? maybe_unserialize( $gdpr_options['moove_gdpr_info_bar_content'.$wpml_lang] ) : false;
                        if ( ! $content ) :
                            $_content   = __("<p>We are using cookies to give you the best experience on our website.</p><p>You can find out more about which cookies we are using or switch them off in [setting]settings[/setting].</p>","gdpr-cookie-compliance");
                            $content    = $_content;
                        endif;
                        ?>
                    <?php
                        $settings = array (
                            'media_buttons'     =>  false,
                            'editor_height'     =>  150,
                            'teeny'             =>  false
                        );
                        wp_editor( $content, 'moove_gdpr_info_bar_content', $settings );
                    ?>
                    <p class="description"><?php _e('You can use the following shortcut to link the settings modal:<br><span><strong>[setting]</strong>settings<strong>[/setting]</strong></span>','gdpr-cookie-compliance'); ?></p>
                </th>
            </tr>

            <tr>
                <th scope="row">
                    <label for="moove_gdpr_infobar_accept_button_label"><?php _e('Accept - Button Label','gdpr-cookie-compliance'); ?></label>
                </th>
                <td>
                    <input name="moove_gdpr_infobar_accept_button_label<?php echo $wpml_lang; ?>" type="text" id="moove_gdpr_infobar_accept_button_label" value="<?php echo isset( $gdpr_options['moove_gdpr_infobar_accept_button_label'.$wpml_lang] ) && $gdpr_options['moove_gdpr_infobar_accept_button_label'.$wpml_lang] ? $gdpr_options['moove_gdpr_infobar_accept_button_label'.$wpml_lang] : __('Accept','gdpr-cookie-compliance'); ?>" class="regular-text">
                </td>
            </tr>

            

            <tr>
                <th scope="row">
                    <label for="moove_gdpr_infobar_visibility"><?php _e('Select your preference for Cookie Banner','gdpr-cookie-compliance'); ?></label>
                </th>
                <td>
                    
                    <input name="moove_gdpr_infobar_visibility" type="radio" value="visible" id="moove_gdpr_infobar_visibility_top" <?php echo isset( $gdpr_options['moove_gdpr_infobar_visibility'] ) ? ( $gdpr_options['moove_gdpr_infobar_visibility'] === 'visible' ? 'checked' : '' ) : 'checked'; ?> class="on-top"> <label for="moove_gdpr_infobar_visibility_top"><?php _e('Visible','gdpr-cookie-compliance'); ?></label> 
                    <span class="separator"></span>

                    <input name="moove_gdpr_infobar_visibility" type="radio" value="hidden" id="moove_gdpr_infobar_visibility_bottom" <?php echo isset( $gdpr_options['moove_gdpr_infobar_visibility'] ) ? ( $gdpr_options['moove_gdpr_infobar_visibility']  === 'hidden' ? 'checked' : '' ) : ''; ?> class="on-off"> <label for="moove_gdpr_infobar_visibility_bottom"><?php _e('Hidden','gdpr-cookie-compliance'); ?></label>

                    <?php do_action('gdpr_cc_moove_gdpr_infobar_visibility_settings'); ?>
                    
                    
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="moove_gdpr_infobar_position"><?php _e('Cookie Banner position','gdpr-cookie-compliance'); ?></label>
                </th>
                <td>
                    
                    <input name="moove_gdpr_infobar_position" type="radio" value="top" id="moove_gdpr_infobar_position_top" <?php echo isset( $gdpr_options['moove_gdpr_infobar_position'] ) ? ( $gdpr_options['moove_gdpr_infobar_position'] === 'top' ? 'checked' : '' ) : ''; ?> class="on-top"> <label for="moove_gdpr_infobar_position_top"><?php _e('Top','gdpr-cookie-compliance'); ?></label> 
                    <span class="separator"></span>

                    <input name="moove_gdpr_infobar_position" type="radio" value="bottom" id="moove_gdpr_infobar_position_bottom" <?php echo isset( $gdpr_options['moove_gdpr_infobar_position'] ) ? ( $gdpr_options['moove_gdpr_infobar_position']  === 'bottom' ? 'checked' : '' ) : 'checked'; ?> class="on-off"> <label for="moove_gdpr_infobar_position_bottom"><?php _e('Bottom','gdpr-cookie-compliance'); ?></label>

                    <?php do_action('gdpr_cc_moove_gdpr_infobar_position_settings'); ?>
                    
                    
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="moove_gdpr_colour_scheme"><?php _e('Colour scheme','gdpr-cookie-compliance'); ?></label>
                </th>
                <td>
                    <fieldset>
                        <legend class="screen-reader-text"><span><?php _e('Enable','gdpr-cookie-compliance'); ?></span></legend>
                            <input name="moove_gdpr_colour_scheme" type="radio" <?php echo isset( $gdpr_options['moove_gdpr_colour_scheme'] ) ? ( intval( $gdpr_options['moove_gdpr_colour_scheme'] ) === 1  ? 'checked' : ( ! isset( $gdpr_options['moove_gdpr_colour_scheme'] ) ? 'checked' : '' ) ) : 'checked'; ?> id="moove_gdpr_colour_scheme_dark" value="1">
                            <label for="moove_gdpr_colour_scheme_dark"><?php _e('Dark','gdpr-cookie-compliance'); ?></label> <br>

                            <input name="moove_gdpr_colour_scheme" type="radio" <?php echo isset( $gdpr_options['moove_gdpr_colour_scheme'] ) ? ( intval( $gdpr_options['moove_gdpr_colour_scheme'] ) === 2  ? 'checked' : '' ) : ''; ?> id="moove_gdpr_colour_scheme_light" value="2">
                            <label for="moove_gdpr_colour_scheme_light"><?php _e('Light','gdpr-cookie-compliance'); ?></label>

                            <?php do_action('gdpr_cc_moove_gdpr_colour_scheme_settings'); ?>

                    </fieldset>
                </td>
            </tr>

            <?php do_action('gdpr_cc_infobar_settings'); ?>

        </tbody>
    </table>

    <br />
    <hr />
    <br />
    <button type="submit" class="button button-primary"><?php _e('Save changes','gdpr-cookie-compliance'); ?></button>
    <?php do_action('gdpr_cc_banner_buttons_settings'); ?>
</form>