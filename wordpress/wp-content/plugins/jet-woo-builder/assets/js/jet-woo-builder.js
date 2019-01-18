( function( $, elementorFrontend ) {

	"use strict";

	var JetWooBuilder = {

		init: function() {


			var widgets = {
				'jet-single-images.default' : JetWooBuilder.productImages,
				'jet-single-add-to-cart.default' : JetWooBuilder.addToCart,
				'jet-single-tabs.default' : JetWooBuilder.productTabs,
				'jet-woo-products.default' : JetWooBuilder.widgetProducts,
				'jet-woo-categories.default' : JetWooBuilder.widgetCategories,
			};

			$.each( widgets, function( widget, callback ) {
				elementorFrontend.hooks.addAction( 'frontend/element_ready/' + widget, callback );
			});

			$( document ).on( 'jet-filter-content-rendered', JetWooBuilder.reInitCarousel );

		},

		productImages: function( $scope ) {

			$scope.find( '.jet-single-images__loading' ).remove();

			if ( ! window.elementor ) {
				return;
			}

			$scope.find( '.woocommerce-product-gallery' ).each( function() {
				$( this ).wc_product_gallery();
			} );
		},

		addToCart: function( $scope ) {

			if ( ! window.elementor ) {
				return;
			}

			if ( typeof wc_add_to_cart_variation_params !== 'undefined' ) {
				$scope.find( '.variations_form' ).each( function() {
					$( this ).wc_variation_form();
				});
			}

		},

		productTabs: function( $scope ) {

			var hash  = window.location.hash;
			var url   = window.location.href;
			var $tabs = $scope.find( '.wc-tabs, ul.tabs' ).first();

			$scope.find( '.jet-single-tabs__loading' ).remove();
			$tabs.find( 'a' ).addClass( 'elementor-clickable' );

			if ( ! window.elementor ) {
				return;
			}

			$scope.find( '.wc-tab, .woocommerce-tabs .panel:not(.panel .panel)' ).hide();

			if ( hash.toLowerCase().indexOf( 'comment-' ) >= 0 || hash === '#reviews' || hash === '#tab-reviews' ) {
				$tabs.find( 'li.reviews_tab a' ).click();
			} else if ( url.indexOf( 'comment-page-' ) > 0 || url.indexOf( 'cpage=' ) > 0 ) {
				$tabs.find( 'li.reviews_tab a' ).click();
			} else if ( hash === '#tab-additional_information' ) {
				$tabs.find( 'li.additional_information_tab a' ).click();
			} else {
				$tabs.find( 'li:first a' ).click();
			}

		},

		widgetProducts: function ( $scope ) {

			var $target = $scope.find( '.jet-woo-carousel' );

			if ( ! $target.length ) {
				return;
			}

			JetWooBuilder.initCarousel( $target.find( '.jet-woo-products' ), $target.data( 'slider_options' ) );

		},

		widgetCategories: function ( $scope ) {

			var $target = $scope.find( '.jet-woo-carousel' );

			if ( ! $target.length ) {
				return;
			}

			JetWooBuilder.initCarousel( $target.find( '.jet-woo-categories' ), $target.data( 'slider_options' ) );

		},

		reInitCarousel: function( event, $scope ) {
			JetWooBuilder.widgetProducts( $scope );
		},

		initCarousel: function( $target, options ) {

			var tabletSlides, mobileSlides, defaultOptions, slickOptions;

			if ( options.slidesToShow.tablet ) {
				tabletSlides = options.slidesToShow.tablet;
			} else {
				tabletSlides = 1 === options.slidesToShow.desktop ? 1 : 2;
			}

			if ( options.slidesToShow.mobile ) {
				mobileSlides = options.slidesToShow.mobile;
			} else {
				mobileSlides = 1;
			}

			options.slidesToShow = options.slidesToShow.desktop;

			defaultOptions = {
				customPaging: function(slider, i) {
					return $( '<span />' ).text( i + 1 );
				},
				dotsClass: 'jet-slick-dots',
				responsive: [
					{
						breakpoint: 1025,
						settings: {
							slidesToShow: tabletSlides,
						}
					},
					{
						breakpoint: 768,
						settings: {
							slidesToShow: mobileSlides,
							slidesToScroll: 1
						}
					}
				]
			};

			slickOptions = $.extend( {}, defaultOptions, options );

			$target.slick( slickOptions );
		},

	};

	$( window ).on( 'elementor/frontend/init', JetWooBuilder.init );

}( jQuery, window.elementorFrontend ) );