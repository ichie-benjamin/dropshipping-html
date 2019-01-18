<?php
    $gdpr_default_content   = new Moove_GDPR_Content();
    $option_name            = $gdpr_default_content->moove_gdpr_get_option_name();
    $gdpr_options           = get_option( $option_name );
    $wpml_lang              = $gdpr_default_content->moove_gdpr_get_wpml_lang();
    $gdpr_options           = is_array( $gdpr_options ) ? $gdpr_options : array();

    if ( isset( $_POST ) && isset( $_POST['moove_gdpr_nonce'] ) ) :
        $nonce = sanitize_key( $_POST['moove_gdpr_nonce'] );
        if ( ! wp_verify_nonce( $nonce, 'moove_gdpr_nonce_field' ) ) :
            die( 'Security check' );
        else :
            if ( is_array( $_POST ) ) :
                if ( isset( $_POST['moove_gdpr_cookie_policy_enable'] ) && intval( $_POST['moove_gdpr_cookie_policy_enable'] ) === 1 ) :
                    $value  = 1;
                else :
                    $value  = 0;
                endif;
                $gdpr_options['moove_gdpr_cookie_policy_enable'] = $value;
                update_option( $option_name, $gdpr_options );
                $gdpr_options = get_option( $option_name );
                foreach ( $_POST as $form_key => $form_value ) :
                    if ( $form_key === 'moove_gdpr_cookies_policy_tab_content' ) :
                        $value  = wp_unslash( $form_value );
                        $gdpr_options[$form_key.$wpml_lang] = $value;
                        update_option( $option_name, $gdpr_options );
                        $gdpr_options = get_option( $option_name );
                    elseif ( $form_key !== 'moove_gdpr_cookie_policy_enable' ) :
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
<?php
    $nav_label  = isset( $gdpr_options['moove_gdpr_cookie_policy_tab_nav_label'.$wpml_lang] ) && $gdpr_options['moove_gdpr_cookie_policy_tab_nav_label'.$wpml_lang] ? $gdpr_options['moove_gdpr_cookie_policy_tab_nav_label'.$wpml_lang] : __('Cookie Policy','gdpr-cookie-compliance');
?>
<h2><?php echo $nav_label; ?></h2>
<hr />
<form action="?page=moove-gdpr&amp;tab=cookie_policy" method="post" id="moove_gdpr_tab_cookie_policy">
    <?php wp_nonce_field( 'moove_gdpr_nonce_field', 'moove_gdpr_nonce' ); ?>
    <table class="form-table">
        <tbody>
            <tr>
                <th scope="row">
                    <label for="moove_gdpr_cookie_policy_enable"><?php _e('Turn','gdpr-cookie-compliance'); ?></label>
                </th>
                <td>
                    <input name="moove_gdpr_cookie_policy_enable" type="radio" value="1" id="moove_gdpr_cookie_policy_enable_on" <?php echo isset( $gdpr_options['moove_gdpr_cookie_policy_enable'] ) ? ( intval( $gdpr_options['moove_gdpr_cookie_policy_enable'] ) === 1  ? 'checked' : '' ) : 'checked'; ?> class="on-off"> <label for="moove_gdpr_cookie_policy_enable_on"><?php _e('On','gdpr-cookie-compliance'); ?></label> <span class="separator"></span>
                    <input name="moove_gdpr_cookie_policy_enable" type="radio" value="0" id="moove_gdpr_cookie_policy_enable_off" <?php echo isset( $gdpr_options['moove_gdpr_cookie_policy_enable'] ) ? ( intval( $gdpr_options['moove_gdpr_cookie_policy_enable'] ) === 0  ? 'checked' : '' ) : 'checked'; ?> class="on-off"> <label for="moove_gdpr_cookie_policy_enable_off"><?php _e('Off','gdpr-cookie-compliance'); ?></label>

                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="moove_gdpr_cookie_policy_tab_nav_label"><?php _e('Tab Title','gdpr-cookie-compliance'); ?></label>
                </th>
                <td>
                    <input name="moove_gdpr_cookie_policy_tab_nav_label<?php echo $wpml_lang; ?>" type="text" id="moove_gdpr_cookie_policy_tab_nav_label" value="<?php echo $nav_label; ?>" class="regular-text">
                </td>
            </tr>

            <tr>
                <th scope="row" colspan="2" style="padding-bottom: 0;">
                    <label for="moove_gdpr_cookies_policy_tab_content"><?php _e('Tab Content','gdpr-cookie-compliance'); ?></label>
                </th>
            </tr>
            <tr class="moove_gdpr_table_form_holder">
                <th colspan="2" scope="row">
                    <?php
                        $content =  isset( $gdpr_options['moove_gdpr_cookies_policy_tab_content'.$wpml_lang] ) && $gdpr_options['moove_gdpr_cookies_policy_tab_content'.$wpml_lang] ? wp_unslash( $gdpr_options['moove_gdpr_cookies_policy_tab_content'.$wpml_lang] ) : false;
                        if ( ! $content ) :
                            $_content   = $gdpr_default_content->moove_gdpr_get_cookie_policy_content();
                            $content    = $_content;
                        endif;
                        ?>
                    <?php
                        $settings = array (
                            'media_buttons'     =>  false,
                            'editor_height'     =>  150,
                        );
                        wp_editor( $content, 'moove_gdpr_cookies_policy_tab_content', $settings );
                    ?>
                </th>
            </tr>

        </tbody>
    </table>

    <hr />
    <br />
    <button type="submit" class="button button-primary"><?php _e('Save changes','gdpr-cookie-compliance'); ?></button>
</form>