(function( $ ) {

	'use strict';

	var JetWooTemplatePopup = {

		init: function() {

			var self = this;

			$( document )
				.on( 'click.JetWooTemplatePopup', '.page-title-action', self.openPopup )
				.on( 'click.JetWooTemplatePopup', '.jet-template-popup__overlay', self.closePopup )
				.on( 'change.JetWooTemplatePopup', '#template_type', self.switchTemplates )
				.on( 'click.JetWooTemplatePopup', '.jet-template-popup__item--uncheck', self.uncheckItem )
				.on( 'click.JetWooTemplatePopup', '.jet-template-popup__label', self.isCheckedItem );

		},

		switchTemplates: function() {
			var $this = $( this ),
				value = $this.find( 'option:selected' ).val();

			if ( '' !== value ) {
				$( '.predesigned-row.template-' + value ).addClass( 'is-active' ).siblings().removeClass( 'is-active' );
			}
		},

		isCheckedItem: function() {
			var $this = $( this ),
				value = $this.find('input'),
				checked = value.prop( "checked" );

			JetWooTemplatePopup.uncheckAll();

			if( checked ){
				$this.addClass( 'is--checked');
			}
		},

		uncheckAll: function() {
			var item = $( '.jet-template-popup__label' );

			if( item.hasClass('is--checked') ){
				item.removeClass('is--checked');
				item.find('input').prop( "checked", false );
			}
		},

		uncheckItem: function() {
			var $this = $( this ),
				label = $this.parent().find('.jet-template-popup__label'),
				input = label.find('input'),
				checked = input.prop( "checked" );

			if( checked ){
				input.prop( "checked", false );
				label.removeClass('is--checked');
			}
		},

		openPopup: function( event ) {
			event.preventDefault();
			$( '.jet-template-popup' ).addClass( 'jet-template-popup-active' );

			JetWooTemplatePopup.uncheckAll();
		},

		closePopup: function() {
			$( '.jet-template-popup' ).removeClass( 'jet-template-popup-active' );
		}

	};

	JetWooTemplatePopup.init();

})( jQuery );