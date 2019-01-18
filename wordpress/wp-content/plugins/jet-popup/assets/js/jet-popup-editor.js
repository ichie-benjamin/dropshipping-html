( function( $ ) {

	'use strict';

	var JetPopupEditor,
		JetPopupControlsViews;

	JetPopupControlsViews = {

		JetSearchView: null,

		init: function() {

			var self = this;

			self.JetSearchView = window.elementor.modules.controls.BaseData.extend( {

				onReady: function() {

					var action      = this.model.attributes.action,
						queryParams = this.model.attributes.query_params;

					this.ui.select.find( 'option' ).each(function(index, el) {
						$( this ).attr( 'selected', true );
					});

					this.ui.select.select2( {
						ajax: {
							url: function() {

								var query = '';

								if ( queryParams.length > 0 ) {
									$.each( queryParams, function( index, param ) {

										if ( window.elementor.settings.page.model.attributes[ param ] ) {
											query += '&' + param + '=' + window.elementor.settings.page.model.attributes[ param ];
										}
									});
								}

								return ajaxurl + '?action=' + action + query;
							},
							dataType: 'json'
						},
						placeholder: 'Please enter 3 or more characters',
						minimumInputLength: 3
					} );

				},

				onBeforeDestroy: function() {

					if ( this.ui.select.data( 'select2' ) ) {
						this.ui.select.select2( 'destroy' );
					}

					this.$el.remove();
				}

			} );

			window.elementor.addControlView( 'jet_popup_search', self.JetSearchView );

		}

	};

	JetPopupEditor = {
		init: function() {

			elementor.settings.page.model.on( 'change', JetPopupEditor.onPageSettingsChange );

			JetPopupControlsViews.init();
		},

		onPageSettingsChange: function( model ) {
			var iframe   = document.getElementById( 'elementor-preview-iframe' ),
				innerDoc = iframe.contentDocument || iframe.contentWindow.document;

			if ( model.changed.hasOwnProperty( 'close_button_icon' ) ) {
				var closeButton = $( '.jet-popup__close-button', innerDoc ),
					icon        = model.changed['close_button_icon'];

				$( 'i', closeButton ).attr( 'class', icon );
			}

			if ( model.changed.hasOwnProperty( 'use_close_button' ) ) {
				var useCloseButton = ( 'yes' === model.changed['use_close_button'] ) ? true : false,
					closeButton    = $( '.jet-popup__close-button', innerDoc );

				if ( useCloseButton ) {
					closeButton.removeClass( 'hidden' );
				} else {
					closeButton.addClass( 'hidden' );
				}
			}

			if ( model.changed.hasOwnProperty( 'use_overlay' ) ) {
				var useOverlay = ( 'yes' === model.changed['use_overlay'] ) ? true : false,
					$overlay   = $( '.jet-popup__overlay', innerDoc );

				if ( useOverlay ) {
					$overlay.removeClass( 'hidden' );
				} else {
					$overlay.addClass( 'hidden' );
				}
			}

			if ( model.changed.hasOwnProperty( 'jet_popup_animation' ) ) {
				var $popup = $( '.jet-popup', innerDoc );

				JetPopupEditor.animationPopup( $popup, model.changed['jet_popup_animation'] );
			}

		},

		animationPopup: function( $popup, effect ) {
			var animeContainer         = null,
				animeContainerSettings = jQuery.extend(
					{
						targets: $( '.jet-popup__container', $popup )[0]
					},
					JetPopupEditor.avaliableEffects[ effect ][ 'show' ]
				);

			animeContainer = anime( animeContainerSettings );
		},

		avaliableEffects: {
			'fade' : {
				'show': {
					delay: 200,
					opacity: {
						value: [ 0, 1 ],
						duration: 600,
						easing: 'easeOutQuart',
					},
				},
				'hide': {
					easing: 'easeOutQuart',
					opacity: {
						value: [ 1, 0 ],
						easing: 'easeOutQuart',
						duration: 400,
					},
				}
			},

			'zoom-in' : {
				'show': {
					duration: 500,
					delay: 200,
					easing: 'easeOutQuart',
					opacity: {
						value: [ 0, 1 ],

					},
					scale: {
						value: [ 0.75, 1 ],
					}
				},
				'hide': {
					duration: 400,
					easing: 'easeOutQuart',
					opacity: {
						value: [ 1, 0 ],
					},
					scale: {
						value: [ 1, 0.75 ],
					}
				}
			},

			'zoom-out' : {
				'show': {
					duration: 500,
					delay: 200,
					easing: 'easeOutQuart',
					opacity: {
						value: [ 0, 1 ],

					},
					scale: {
						value: [ 1.25, 1 ],
					}
				},
				'hide': {
					duration: 400,
					easing: 'easeOutQuart',
					opacity: {
						value: [ 1, 0 ],
					},
					scale: {
						value: [ 1, 1.25 ],
					}
				}
			},

			'rotate' : {
				'show': {
					duration: 500,
					delay: 200,
					easing: 'easeOutQuart',
					opacity: {
						value: [ 0, 1 ],

					},
					scale: {
						value: [ 0.75, 1 ],
					},
					rotate: {
						value: [ -65, 0 ],
					}
				},
				'hide': {
					duration: 400,
					easing: 'easeOutQuart',
					opacity: {
						value: [ 1, 0 ],
					},
					scale: {
						value: [ 1, 0.9 ],
					},
				}
			},

			'move-up' : {
				'show': {
					duration: 500,
					delay: 200,
					easing: 'easeOutExpo',
					opacity: {
						value: [ 0, 1 ],

					},
					translateY: {
						value: [ 50, 1 ],
					}
				},
				'hide': {
					duration: 400,
					easing: 'easeOutQuart',
					opacity: {
						value: [ 1, 0 ],
					},
					translateY: {
						value: [ 1, 50 ],
					}
				}
			},

			'flip-x' : {
				'show': {
					duration: 1000,
					delay: 200,
					easing: 'easeOutExpo',
					opacity: {
						value: [ 0, 1 ],

					},
					rotateX: {
						value: [ 65, 0 ],
					}
				},
				'hide': {
					duration: 400,
					easing: 'easeOutQuart',
					opacity: {
						value: [ 1, 0 ],
					}
				}
			},

			'flip-y' : {
				'show': {
					duration: 1000,
					delay: 200,
					easing: 'easeOutExpo',
					opacity: {
						value: [ 0, 1 ],

					},
					rotateY: {
						value: [ 65, 0 ],
					}
				},
				'hide': {
					duration: 400,
					easing: 'easeOutQuart',
					opacity: {
						value: [ 1, 0 ],
					}
				}
			},

			'bounce-in' : {
				'show': {
					delay: 200,
					opacity: {
						value: [ 0, 1 ],
						duration: 500,
						easing: 'easeOutQuart',
					},
					scale: {
						value: [ 0.2, 1 ],
						duration: 800,
						elasticity: function(el, i, l) {
							return (400 + i * 200);
						},
					}
				},
				'hide': {
					duration: 400,
					easing: 'easeOutQuart',
					opacity: {
						value: [ 1, 0 ],
					},
					scale: {
						value: [ 1, 0.8 ],
					}
				}
			},

			'bounce-out' : {
				'show': {
					delay: 200,
					opacity: {
						value: [ 0, 1 ],
						duration: 500,
						easing: 'easeOutQuart',
					},
					scale: {
						value: [ 1.8, 1 ],
						duration: 800,
						elasticity: function(el, i, l) {
							return (400 + i * 200);
						},
					}
				},
				'hide': {
					duration: 400,
					easing: 'easeOutQuart',
					opacity: {
						value: [ 1, 0 ],
					},
					scale: {
						value: [ 1, 1.5 ],
					}
				}
			},

			'slide-in-up' : {
				'show': {
					delay: 200,
					opacity: {
						value: [ 0, 1 ],
						duration: 400,
						easing: 'easeOutQuart',
					},
					translateY: {
						value: ['100vh', 0],
						duration: 750,
						easing: 'easeOutQuart',
					}
				},
				'hide': {
					duration: 400,
					easing: 'easeInQuart',
					opacity: {
						value: [ 1, 0 ],
					},
					translateY: {
						value: [0,'100vh'],
					}
				}
			},

			'slide-in-right' : {
				'show': {
					delay: 200,
					opacity: {
						value: [ 0, 1 ],
						duration: 400,
						easing: 'easeOutQuart',
					},
					translateX: {
						value: ['100vw', 0],
						duration: 750,
						easing: 'easeOutQuart',
					}
				},
				'hide': {
					duration: 400,
					easing: 'easeInQuart',
					opacity: {
						value: [ 1, 0 ],
					},
					translateX: {
						value: [0,'100vw'],
					}
				}
			},

			'slide-in-down' : {
				'show': {
					delay: 200,
					opacity: {
						value: [ 0, 1 ],
						duration: 400,
						easing: 'easeOutQuart',
					},
					translateY: {
						value: ['-100vh', 0],
						duration: 750,
						easing: 'easeOutQuart',
					}
				},
				'hide': {
					duration: 400,
					easing: 'easeInQuart',
					opacity: {
						value: [ 1, 0 ],
					},
					translateY: {
						value: [0,'-100vh'],
					}
				}
			},

			'slide-in-left' : {
				'show': {
					delay: 200,
					opacity: {
						value: [ 0, 1 ],
						duration: 400,
						easing: 'easeOutQuart',
					},
					translateX: {
						value: ['-100vw', 0],
						duration: 750,
						easing: 'easeOutQuart',
					}
				},
				'hide': {
					duration: 400,
					easing: 'easeInQuart',
					opacity: {
						value: [ 1, 0 ],
					},
					translateX: {
						value: [0,'-100vw'],
					}
				}
			}

		}

	};

	$( window ).on( 'elementor:init', JetPopupEditor.init );

}( jQuery ) );


