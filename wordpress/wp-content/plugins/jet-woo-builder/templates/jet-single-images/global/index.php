<?php
/**
 * Images template
 */
echo '<div class="jet-single-images__wrap">';
	printf( '<div class="jet-single-images__loading">%s</div>', __( 'Loading...', 'jet-woo-builder' ) );
	woocommerce_show_product_images();
echo '</div>';
