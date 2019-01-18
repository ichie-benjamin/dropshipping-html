<li class="menu-item-on menu-item-privacy_overview menu-item-selected">
    <button data-href="#privacy_overview" class="moove-gdpr-tab-nav"><i class="moovegdpr-privacy-overview"></i> <span><?php echo $content->overview->nav_label; ?></span></button>
</li>

<?php if ( $content->strictly->show ) : ?>
    <li class="menu-item-strict-necessary-cookies menu-item-off">
        <button data-href="#strict-necessary-cookies" class="moove-gdpr-tab-nav"><i class="moovegdpr-strict-necessary"></i> <span><?php echo $content->strictly->nav_label; ?></span></button>
    </li>
<?php endif; ?>


<?php if ( $content->third_party->show ) : ?>
    <li class="menu-item-off menu-item-third_party_cookies">
        <button data-href="#third_party_cookies" class="moove-gdpr-tab-nav"><i class="moovegdpr-3rd-party"></i> <span><?php echo $content->third_party->nav_label; ?></span></button>
    </li>
<?php endif; ?>

<?php if ( $content->advanced->show ) : ?>
    <li class="menu-item-advanced-cookies menu-item-off">
        <button data-href="#advanced-cookies" class="moove-gdpr-tab-nav"><i class="moovegdpr-advanced"></i> <span><?php echo $content->advanced->nav_label; ?></span></button>
    </li>
<?php endif; ?>

<?php if ( $content->cookiepolicy->show ) : ?>
    <li class="menu-item-moreinfo menu-item-off">
        <button data-href="#cookie_policy_modal" class="moove-gdpr-tab-nav" rel="nofollow"><i class="moovegdpr-policy"></i> <span><?php echo $content->cookiepolicy->nav_label; ?></span></button>
    </li>
<?php endif; ?>