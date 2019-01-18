<div class="moove-gdpr-branding-cnt">
    <?php
        if ( $content->is_enabled ) :
            echo apply_filters( 'moove_gdpr_footer_branding_text', $content->text );
        endif;
    ?>
</div>
<!--  .moove-gdpr-branding -->