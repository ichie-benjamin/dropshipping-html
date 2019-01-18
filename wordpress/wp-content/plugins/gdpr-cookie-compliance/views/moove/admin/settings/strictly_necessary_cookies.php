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
                $value  = 1;
                if ( isset( $_POST['moove_gdpr_strictly_necessary_cookies_functionality'] ) && intval( $_POST['moove_gdpr_strictly_necessary_cookies_functionality'] ) ) :
                    $value  = intval( $_POST['moove_gdpr_strictly_necessary_cookies_functionality'] );
                endif;

                $gdpr_options['moove_gdpr_strictly_necessary_cookies_functionality'] = $value;
                update_option( $option_name, $gdpr_options );
                $gdpr_options = get_option( $option_name );
                foreach ( $_POST as $form_key => $form_value ) :
                    if ( $form_key === 'moove_gdpr_strict_necessary_cookies_tab_content' ) :
                        $value  = wp_unslash( $form_value );
                        $gdpr_options[$form_key.$wpml_lang] = $value;
                        update_option( $option_name, $gdpr_options );
                        $gdpr_options = get_option( $option_name );
                    elseif ( $form_key === 'moove_gdpr_strictly_necessary_cookies_warning' ) :
                        $value  = wp_unslash( $form_value );
                        $gdpr_options[$form_key.$wpml_lang] = $value;
                        update_option( $option_name, $gdpr_options );
                        $gdpr_options = get_option( $option_name );
                    elseif ( $form_key !== 'moove_gdpr_strictly_necessary_cookies_functionality' ) :
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
    $nav_label  = isset( $gdpr_options['moove_gdpr_strictly_necessary_cookies_tab_title'.$wpml_lang] ) && $gdpr_options['moove_gdpr_strictly_necessary_cookies_tab_title'.$wpml_lang] ? $gdpr_options['moove_gdpr_strictly_necessary_cookies_tab_title'.$wpml_lang] : __('Strictly Necessary Cookies','gdpr-cookie-compliance');
?>
<h2><?php echo $nav_label; ?></h2>
<hr />
<form action="?page=moove-gdpr&amp;tab=strictly_necessary_cookies" method="post" id="moove_gdpr_tab_strictly_necessary_cookies">
    <?php wp_nonce_field( 'moove_gdpr_nonce_field', 'moove_gdpr_nonce' ); ?>
    <table class="form-table">
        <tbody>
            <tr>
                <th scope="row">
                    <label for="moove_gdpr_strictly_necessary_cookies_functionality"><?php _e('Choose functionality','gdpr-cookie-compliance'); ?></label>
                </th>
                <td>

                    <input name="moove_gdpr_strictly_necessary_cookies_functionality" type="radio" value="1" id="moove_gdpr_strictly_necessary_cookies_functionality_1" <?php echo isset( $gdpr_options['moove_gdpr_strictly_necessary_cookies_functionality'] ) ? ( intval( $gdpr_options['moove_gdpr_strictly_necessary_cookies_functionality'] ) === 1  ? 'checked' : '' ) : 'checked'; ?> class="on-off"> <label for="moove_gdpr_strictly_necessary_cookies_functionality_1"><?php _e('Optional (user selects their preferences)','gdpr-cookie-compliance'); ?></label> <span class="separator"></span><br /><br />

                    <input name="moove_gdpr_strictly_necessary_cookies_functionality" type="radio" value="2" id="moove_gdpr_strictly_necessary_cookies_functionality_2" <?php echo isset( $gdpr_options['moove_gdpr_strictly_necessary_cookies_functionality'] ) ? ( intval( $gdpr_options['moove_gdpr_strictly_necessary_cookies_functionality'] ) === 2  ? 'checked' : '' ) : ''; ?> class="on-off"> <label for="moove_gdpr_strictly_necessary_cookies_functionality_2"><?php _e('Always enabled (user cannot disable it but can see the content)','gdpr-cookie-compliance'); ?></label><br /><br />

                    <input name="moove_gdpr_strictly_necessary_cookies_functionality" type="radio" value="3" id="moove_gdpr_strictly_necessary_cookies_functionality_3" <?php echo isset( $gdpr_options['moove_gdpr_strictly_necessary_cookies_functionality'] ) ? ( intval( $gdpr_options['moove_gdpr_strictly_necessary_cookies_functionality'] ) === 3  ? 'checked' : '' ) : ''; ?> class="on-off"> <label for="moove_gdpr_strictly_necessary_cookies_functionality_3"><?php _e('Always enabled and content hidden from user','gdpr-cookie-compliance'); ?></label><br /><br />
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="moove_gdpr_strictly_necessary_cookies_tab_title"><?php _e('Tab Title','gdpr-cookie-compliance'); ?></label>
                </th>
                <td>
                    <input name="moove_gdpr_strictly_necessary_cookies_tab_title<?php echo $wpml_lang; ?>" type="text" id="moove_gdpr_strictly_necessary_cookies_tab_title" value="<?php echo $nav_label; ?>" class="regular-text">
                </td>
            </tr>

            <tr>
                <th scope="row" colspan="2" style="padding-bottom: 0;">
                    <label for="moove_gdpr_strict_necessary_cookies_tab_content"><?php _e('Tab Content','gdpr-cookie-compliance'); ?></label>
                </th>
            </tr>
            <tr class="moove_gdpr_table_form_holder">
                <th colspan="2" scope="row">
                    <?php
                        $content =  isset( $gdpr_options['moove_gdpr_strict_necessary_cookies_tab_content'.$wpml_lang] ) && $gdpr_options['moove_gdpr_strict_necessary_cookies_tab_content'.$wpml_lang] ? wp_unslash( $gdpr_options['moove_gdpr_strict_necessary_cookies_tab_content'.$wpml_lang] ) : false;
                        if ( ! $content ) :
                            $content    = $gdpr_default_content->moove_gdpr_get_strict_necessary_content();
                        endif;
                        ?>
                    <?php
                        $settings = array (
                            'media_buttons'     =>  false,
                            'editor_height'     =>  150,
                        );
                        wp_editor( $content, 'moove_gdpr_strict_necessary_cookies_tab_content', $settings );
                    ?>
                </th>
            </tr>

            <tr>
                <th scope="row" style="padding-bottom: 0;" colspan="2">
                    <label for="moove_gdpr_strictly_necessary_cookies_warning"><?php _e('Tab Warning Message','gdpr-cookie-compliance'); ?></label>
                </th>
            </tr>
            <tr>
                <th style="padding-top: 10px;"  colspan="2">
                    <?php $content = isset( $gdpr_options['moove_gdpr_strictly_necessary_cookies_warning'.$wpml_lang] ) && $gdpr_options['moove_gdpr_strictly_necessary_cookies_warning'.$wpml_lang] ? $gdpr_options['moove_gdpr_strictly_necessary_cookies_warning'.$wpml_lang] : $gdpr_default_content->moove_gdpr_get_strict_necessary_warning(); ?>
                    <?php
                        $settings = array (
                            'media_buttons'     =>  false,
                            'editor_height'     =>  50,
                        );
                        wp_editor( $content, 'moove_gdpr_strictly_necessary_cookies_warning', $settings );
                    ?>
                    <p class="description" id="moove_gdpr_strictly_necessary_cookies_warning-description"><?php _e('Will be displayed below the Checkbox in the front-end!','gdpr-cookie-compliance'); ?></p>
                </th>
            </tr>
        </tbody>
    </table>

    <hr />
    <br />
    <button type="submit" class="button button-primary"><?php _e('Save changes','gdpr-cookie-compliance'); ?></button>
</form>