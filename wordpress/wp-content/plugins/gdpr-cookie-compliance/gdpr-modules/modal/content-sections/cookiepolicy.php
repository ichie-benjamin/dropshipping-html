<?php if ( $content->show ) : ?>
    <div id="cookie_policy_modal" class="moove-gdpr-tab-main" <?php echo $content->visibility; ?>>
        <h3 class="tab-title"><?php echo $content->tab_title; ?></h3>
        <div class="moove-gdpr-tab-main-content">
            <?php echo $content->tab_content; ?>
        </div>
        <!--  .moove-gdpr-tab-main-content -->
    </div>
<?php endif; ?>