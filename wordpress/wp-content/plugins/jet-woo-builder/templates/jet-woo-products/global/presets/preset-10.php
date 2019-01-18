<?php
/**
 * Products loop item layout 10
 */
?>
<div class="jet-woo-products__thumb-wrap">
	<div class="jet-woo-product-img-overlay"></div>
	<?php include $this->get_template( 'item-thumb' ); ?>
	<div class="jet-woo-products__item-content">
		<?php include $this->get_template( 'item-categories' );
		include $this->get_template( 'item-title' );
		include $this->get_template( 'item-price' );
		?>
		<div class="hovered-content">
			<?php
			include $this->get_template( 'item-rating' );
			include $this->get_template( 'item-content' );
			include $this->get_template( 'item-button' );
			include $this->get_template( 'item-tags' );
			?>
		</div>
	</div>
</div>