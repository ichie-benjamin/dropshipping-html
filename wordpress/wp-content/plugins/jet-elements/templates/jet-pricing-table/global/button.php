<?php
/**
 * Pricing table action button
 */

$this->add_render_attribute( 'button', array(
	'class' => array(
		'elementor-button',
		'elementor-size-md',
		'pricing-table-button',
		'button-' . $this->get_settings_for_display( 'button_size' ) . '-size',
	),
	'href' => $this->get_settings_for_display( 'button_url' ),
) );

?>
<a <?php echo $this->get_render_attribute_string( 'button' ); ?>><?php

	$position = $this->get_settings_for_display( 'button_icon_position' );
	$icon     = $this->get_settings_for_display( 'add_button_icon' );

	if ( $icon && 'left' === $position ) {
		echo $this->__html( 'button_icon', '<i class="button-icon %s"></i>' );
	}

	echo $this->__html( 'button_text' );

	if ( $icon && 'right' === $position ) {
		echo $this->__html( 'button_icon', '<i class="button-icon %s"></i>' );
	}

?></a>
