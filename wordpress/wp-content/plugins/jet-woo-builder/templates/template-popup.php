<?php
/**
 * Teamplte type popup
 */

$doc_types = jet_woo_builder()->documents->get_document_types();

?>
<div class="jet-template-popup">
	<div class="jet-template-popup__overlay"></div>
	<div class="jet-template-popup__content">
		<h3 class="jet-template-popup__heading"><?php
			esc_html_e( 'Add Template', 'jet-woo-builder' );
		?></h3>
		<form class="jet-template-popup__form" method="POST" action="<?php echo $action; ?>" >
			<div class="jet-template-popup__form-row plain-row">
				<label for="template_type"><?php esc_html_e( 'This template for:', 'jet-woo-builder' ); ?></label>
				<select id="template_type" name="template_type"><?php
					foreach ( $doc_types as $type ) {
						printf(
							'<option value="%1$s">%2$s</option>',
							$type['slug'],
							$type['name']
						);
					}
				?></select>
			</div>
			<div class="jet-template-popup__form-row plain-row">
				<label for="template_name"><?php esc_html_e( 'Template Name:', 'jet-woo-builder' ); ?></label>
				<input type="text" id="template_name" name="template_name" placeholder="<?php esc_html_e( 'Set template name', 'jet-woo-builder' ); ?>">
			</div>
			<h4 class="jet-template-popup__subheading"><?php
				esc_html_e( 'Start from Layout', 'jet-woo-builder' );
			?></h4>
			<div class="jet-template-popup__form-row predesigned-row template-<?php echo $doc_types['single']['slug']; ?> is-active"><?php
				foreach ( $this->predesigned_single_templates() as $id => $data ) {
					?>
					<div class="jet-template-popup__item">
						<label class="jet-template-popup__label">
							<input type="radio" name="template_single" value="<?php echo $id; ?>">
							<img src="<?php echo $data['thumb']; ?>" alt="">
						</label>
						<span class="jet-template-popup__item--uncheck"><span>×</span></span>
					</div>
					<?php
				}
			?></div>
			<div class="jet-template-popup__form-row predesigned-row template-<?php echo $doc_types['archive']['slug']; ?>"><?php
				foreach ( $this->predesigned_archive_templates() as $id => $data ) {
					?>
					<div class="jet-template-popup__item">
						<label class="jet-template-popup__label">
							<input type="radio" name="template_archive" value="<?php echo $id; ?>">
							<img src="<?php echo $data['thumb']; ?>" alt="">
						</label>
						<span class="jet-template-popup__item--uncheck"><span>×</span></span>
					</div>
					<?php
				}
			?></div>
			<div class="jet-template-popup__form-row predesigned-row template-<?php echo $doc_types['category']['slug']; ?>"><?php
		  foreach ( $this->predesigned_category_templates() as $id => $data ) {
			  ?>
						<div class="jet-template-popup__item">
							<label class="jet-template-popup__label">
								<input type="radio" name="template_category" value="<?php echo $id; ?>">
								<img src="<?php echo $data['thumb']; ?>" alt="">
							</label>
							<span class="jet-template-popup__item--uncheck"><span>×</span></span>
						</div>
			  <?php
		  }
		  ?></div>
			<div class="jet-template-popup__form-row predesigned-row template-<?php echo $doc_types['shop']['slug']; ?>">
				<div class="predesigned-templates__description"><?php esc_html_e( 'For creating this template , you need combine shop template and archive template in Jet Woo Builder settings', 'jet-woo-builder' ); ?></div>
					<?php
		  foreach ( $this->predesigned_shop_templates() as $id => $data ) {
			  ?>
						<div class="jet-template-popup__item">
							<label class="jet-template-popup__label">
								<input type="radio" name="template_shop" value="<?php echo $id; ?>">
								<img src="<?php echo $data['thumb']; ?>" alt="">
							</label>
							<span class="jet-template-popup__item--uncheck"><span>×</span></span>
						</div>
			  <?php
		  }
		  ?></div>
			<div class="jet-template-popup__form-actions">
				<button type="submit" id="templates_type_submit" class="button button-primary button-hero"><?php
					esc_html_e( 'Create Template', 'jet-woo-builder' );
				?></button>
			</div>
		</form>
	</div>
</div>