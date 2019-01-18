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
                if ( isset( $_POST['moove_gdpr_floating_button_enable'] ) ) :
                    $value  = 1;
                else :
                    $value  = 0;
                endif;
                $gdpr_options['moove_gdpr_floating_button_enable'] = $value;
                update_option( $option_name, $gdpr_options );
                $gdpr_options = get_option( $option_name );
                
                foreach ( $_POST as $form_key => $form_value ) :
                    if ( $form_key !== 'moove_gdpr_floating_button_enable' ) :
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
<form action="?page=moove-gdpr&amp;tab=floating_button" method="post" id="moove_gdpr_tab_floating_button">
    <?php wp_nonce_field( 'moove_gdpr_nonce_field', 'moove_gdpr_nonce' ); ?>
    <h2><?php _e('Floating Button','gdpr-cookie-compliance'); ?></h2>
    <hr />

    <table class="form-table">
        <tbody>
            <tr>
                <th scope="row">
                    <label for="moove_gdpr_floating_button_enable"><?php _e('Enable Floating Button','gdpr-cookie-compliance'); ?></label>
                </th>
                <td>
                    <fieldset>
                        <legend class="screen-reader-text"><span><?php _e('Enable','gdpr-cookie-compliance'); ?></span></legend>
                        <label for="moove_gdpr_floating_button_enable">
                            <input name="moove_gdpr_floating_button_enable" type="checkbox" <?php echo isset( $gdpr_options['moove_gdpr_floating_button_enable'] ) ? ( intval( $gdpr_options['moove_gdpr_floating_button_enable'] ) === 1  ? 'checked' : '' ) : ''; ?> id="moove_gdpr_floating_button_enable" value="1">
                            <?php _e('Enable','gdpr-cookie-compliance'); ?></label>
                    </fieldset>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="moove_gdpr_floating_button_label"><?php _e('Button - Hover Label','gdpr-cookie-compliance'); ?></label>
                </th>
                <td>
                    <input name="moove_gdpr_floating_button_label<?php echo $wpml_lang; ?>" type="text" id="moove_gdpr_floating_button_label" value="<?php echo isset( $gdpr_options['moove_gdpr_floating_button_label'.$wpml_lang] ) && $gdpr_options['moove_gdpr_floating_button_label'.$wpml_lang] ? $gdpr_options['moove_gdpr_floating_button_label'.$wpml_lang] : __('Change cookie settings','gdpr-cookie-compliance'); ?>" class="regular-text">
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="moove_gdpr_floating_button_position"><?php _e('Button - Custom Position (CSS)','gdpr-cookie-compliance'); ?></label>
                </th>
                <td>
                    <input name="moove_gdpr_floating_button_position" type="text" id="moove_gdpr_floating_button_position" value="<?php echo isset( $gdpr_options['moove_gdpr_floating_button_position'] ) && $gdpr_options['moove_gdpr_floating_button_position'] ? $gdpr_options['moove_gdpr_floating_button_position'] : 'bottom: 20px; left: 20px;'; ?>" class="regular-text">
                    <p class="description" id="moove_gdpr_floating_button_position-description"><?php _e('You can align the position eg.: <strong>top: 20px; right: 20px;</strong>','gdpr-cookie-compliance'); ?></p>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="moove_gdpr_floating_button_background_colour"><?php _e('Button - Background Colour','gdpr-cookie-compliance'); ?></label>
                </th>
                <td>
                    <div class="iris-colorpicker-group-cnt">
                        <?php $color = isset( $gdpr_options['moove_gdpr_floating_button_background_colour'] ) && $gdpr_options['moove_gdpr_floating_button_background_colour'] ? $gdpr_options['moove_gdpr_floating_button_background_colour'] : '373737'; ?>
                        <input class="iris-colorpicker regular-text" name="moove_gdpr_floating_button_background_colour" value="<?php echo $color; ?>" style="background-color: <?php echo $color; ?>;" >
                        <span class="iris-selectbtn"><?php _e('Select','gdpr-cookie-compliance'); ?></span>
                    </div>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="moove_gdpr_floating_button_hover_background_colour"><?php _e('Button - Hover Background Colour','gdpr-cookie-compliance'); ?></label>
                </th>
                <td>
                    <div class="iris-colorpicker-group-cnt">
                        <?php $color = isset( $gdpr_options['moove_gdpr_floating_button_hover_background_colour'] ) && $gdpr_options['moove_gdpr_floating_button_hover_background_colour'] ? $gdpr_options['moove_gdpr_floating_button_hover_background_colour'] : '000000';; ?>
                        <input class="iris-colorpicker regular-text" name="moove_gdpr_floating_button_hover_background_colour" value="<?php echo $color ?>" style="background-color: <?php echo $color; ?>;" >
                        <span class="iris-selectbtn"><?php _e('Select','gdpr-cookie-compliance'); ?></span>
                    </div>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="moove_gdpr_floating_button_font_colour"><?php _e('Button - Font Colour','gdpr-cookie-compliance'); ?></label>
                </th>
                <td>
                    <div class="iris-colorpicker-group-cnt">
                        <?php $color = isset( $gdpr_options['moove_gdpr_floating_button_font_colour'] ) && $gdpr_options['moove_gdpr_floating_button_font_colour'] ? $gdpr_options['moove_gdpr_floating_button_font_colour'] : 'ffffff'; ?>
                        <input class="iris-colorpicker regular-text" name="moove_gdpr_floating_button_font_colour" value="<?php echo $color; ?>" style="background-color: <?php echo $color; ?>;" >
                        <span class="iris-selectbtn"><?php _e('Select','gdpr-cookie-compliance'); ?></span>
                    </div>
                </td>
            </tr>

            <?php do_action('gdpr_cc_floating_button_settings'); ?>

        </tbody>
    </table>

    <br />
    <hr />
    <br />
    <button type="submit" class="button button-primary"><?php _e('Save changes','gdpr-cookie-compliance'); ?></button>
    <?php do_action('gdpr_cc_floating_button_settings'); ?>
</form>