<?php
/**
 * Cherry addons tools class
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Jet_Woo_Builder_Tools' ) ) {

	/**
	 * Define Jet_Woo_Builder_Tools class
	 */
	class Jet_Woo_Builder_Tools {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @var   object
		 */
		private static $instance = null;

		/**
		 * Returns columns classes string
		 *
		 * @param  [type] $columns [description]
		 *
		 * @return [type]          [description]
		 */
		public function col_classes( $columns = array() ) {

			$columns = wp_parse_args( $columns, array(
				'desk' => 1,
				'tab'  => 1,
				'mob'  => 1,
			) );

			$classes = array();

			foreach ( $columns as $device => $cols ) {
				if ( ! empty( $cols ) ) {
					$classes[] = sprintf( 'col-%1$s-%2$s', $device, $cols );
				}
			}

			return implode( ' ', $classes );
		}

		/**
		 * Returns disable columns gap nad rows gap classes string
		 *
		 * @param  string $use_cols_gap [description]
		 * @param  string $use_rows_gap [description]
		 *
		 * @return [type]               [description]
		 */
		public function gap_classes( $use_cols_gap = 'yes', $use_rows_gap = 'yes' ) {

			$result = array();

			foreach ( array( 'cols' => $use_cols_gap, 'rows' => $use_rows_gap ) as $element => $value ) {
				if ( 'yes' !== $value ) {
					$result[] = sprintf( 'disable-%s-gap', $element );
				}
			}

			return implode( ' ', $result );

		}

		/**
		 * Returns image size array in slug => name format
		 *
		 * @return  array
		 */
		public function get_image_sizes() {

			global $_wp_additional_image_sizes;

			$sizes  = get_intermediate_image_sizes();
			$result = array();

			foreach ( $sizes as $size ) {
				if ( in_array( $size, array( 'thumbnail', 'medium', 'medium_large', 'large' ) ) ) {
					$result[ $size ] = ucwords( trim( str_replace( array( '-', '_' ), array( ' ', ' ' ), $size ) ) );
				} else {
					$result[ $size ] = sprintf(
						'%1$s (%2$sx%3$s)',
						ucwords( trim( str_replace( array( '-', '_' ), array( ' ', ' ' ), $size ) ) ),
						$_wp_additional_image_sizes[ $size ]['width'],
						$_wp_additional_image_sizes[ $size ]['height']
					);
				}
			}

			return array_merge( array( 'full' => esc_html__( 'Full', 'jet-woo-builder' ), ), $result );
		}

		/**
		 * Get categories list.
		 *
		 * @return array
		 */
		public function get_categories() {

			$categories = get_categories();

			if ( empty( $categories ) || ! is_array( $categories ) ) {
				return array();
			}

			return wp_list_pluck( $categories, 'name', 'term_id' );

		}

		/**
		 * Returns icons data list.
		 *
		 * @return array
		 */
		public function get_theme_icons_data() {

			$default = array(
				'icons'  => false,
				'format' => 'fa %s',
				'file'   => false,
			);

			/**
			 * Filter default icon data before useing
			 *
			 * @var array
			 */
			$icon_data = apply_filters( 'jet-woo-builder/controls/icon/data', $default );
			$icon_data = array_merge( $default, $icon_data );

			return $icon_data;
		}

		/**
		 * Returns allowed order by fields for options
		 *
		 * @return array
		 */
		public function orderby_arr() {
			return array(
				'none'          => esc_html__( 'None', 'jet-woo-builder' ),
				'ID'            => esc_html__( 'ID', 'jet-woo-builder' ),
				'author'        => esc_html__( 'Author', 'jet-woo-builder' ),
				'title'         => esc_html__( 'Title', 'jet-woo-builder' ),
				'name'          => esc_html__( 'Name (slug)', 'jet-woo-builder' ),
				'date'          => esc_html__( 'Date', 'jet-woo-builder' ),
				'modified'      => esc_html__( 'Modified', 'jet-woo-builder' ),
				'rand'          => esc_html__( 'Rand', 'jet-woo-builder' ),
				'comment_count' => esc_html__( 'Comment Count', 'jet-woo-builder' ),
				'menu_order'    => esc_html__( 'Menu Order', 'jet-woo-builder' ),
			);
		}

		/**
		 * Returns allowed order fields for options
		 *
		 * @return array
		 */
		public function order_arr() {

			return array(
				'desc' => esc_html__( 'Descending', 'jet-woo-builder' ),
				'asc'  => esc_html__( 'Ascending', 'jet-woo-builder' ),
			);

		}

		/**
		 * Returns allowed order by fields for options
		 *
		 * @return array
		 */
		public function verrtical_align_attr() {
			return array(
				'baseline'    => esc_html__( 'Baseline', 'jet-woo-builder' ),
				'top'         => esc_html__( 'Top', 'jet-woo-builder' ),
				'middle'      => esc_html__( 'Middle', 'jet-woo-builder' ),
				'bottom'      => esc_html__( 'Bottom', 'jet-woo-builder' ),
				'sub'         => esc_html__( 'Sub', 'jet-woo-builder' ),
				'super'       => esc_html__( 'Super', 'jet-woo-builder' ),
				'text-top'    => esc_html__( 'Text Top', 'jet-woo-builder' ),
				'text-bottom' => esc_html__( 'Text Bottom', 'jet-woo-builder' ),
			);
		}

		/**
		 * Returns array with numbers in $index => $name format for numeric selects
		 *
		 * @param  integer $to Max numbers
		 *
		 * @return array
		 */
		public function get_select_range( $to = 10 ) {
			$range = range( 1, $to );

			return array_combine( $range, $range );
		}

		/**
		 * Rturns image tag or raw SVG
		 *
		 * @param  string $url image URL.
		 * @param  array $attr [description]
		 *
		 * @return string
		 */
		public function get_image_by_url( $url = null, $attr = array() ) {

			$url = esc_url( $url );

			if ( empty( $url ) ) {
				return;
			}

			$ext  = pathinfo( $url, PATHINFO_EXTENSION );
			$attr = array_merge( array( 'alt' => '' ), $attr );

			if ( 'svg' !== $ext ) {
				return sprintf( '<img src="%1$s"%2$s>', $url, $this->get_attr_string( $attr ) );
			}

			$base_url = network_site_url( '/' );
			$svg_path = str_replace( $base_url, ABSPATH, $url );
			$key      = md5( $svg_path );
			$svg      = get_transient( $key );

			if ( ! $svg ) {
				$svg = file_get_contents( $svg_path );
			}

			if ( ! $svg ) {
				return sprintf( '<img src="%1$s"%2$s>', $url, $this->get_attr_string( $attr ) );
			}

			set_transient( $key, $svg, DAY_IN_SECONDS );

			unset( $attr['alt'] );

			return sprintf( '<div%2$s>%1$s</div>', $svg, $this->get_attr_string( $attr ) );;
		}

		/**
		 * Return attributes string from attributes array.
		 *
		 * @param  array $attr Attributes string.
		 *
		 * @return string
		 */
		public function get_attr_string( $attr = array() ) {

			if ( empty( $attr ) || ! is_array( $attr ) ) {
				return;
			}

			$result = '';

			foreach ( $attr as $key => $value ) {
				$result .= sprintf( ' %s="%s"', esc_attr( $key ), esc_attr( $value ) );
			}

			return $result;
		}

		/**
		 * Returns carousel arrow
		 *
		 * @param  array $classes Arrow additional classes list.
		 *
		 * @return string
		 */
		public function get_carousel_arrow( $classes ) {

			$format = apply_filters( 'jet_woo_builder/carousel/arrows_format', '<i class="%s jet-arrow"></i>', $classes );

			return sprintf( $format, implode( ' ', $classes ) );
		}

		/**
		 * Get post types options list
		 *
		 * @return array
		 */
		public function get_post_types() {

			$post_types = get_post_types( array( 'public' => true ), 'objects' );

			$deprecated = apply_filters(
				'jet-woo-builder/post-types-list/deprecated',
				array( 'attachment', 'elementor_library' )
			);

			$result = array();

			if ( empty( $post_types ) ) {
				return $result;
			}

			foreach ( $post_types as $slug => $post_type ) {

				if ( in_array( $slug, $deprecated ) ) {
					continue;
				}

				$result[ $slug ] = $post_type->label;

			}

			return $result;

		}

		/**
		 * Return availbale arrows list
		 * @return [type] [description]
		 */
		public function get_available_prev_arrows_list() {

			return apply_filters(
				'jet_woo_builder/carousel/available_arrows/prev',
				array(
					'fa fa-angle-left'          => __( 'Angle', 'jet-woo-builder' ),
					'fa fa-chevron-left'        => __( 'Chevron', 'jet-woo-builder' ),
					'fa fa-angle-double-left'   => __( 'Angle Double', 'jet-woo-builder' ),
					'fa fa-arrow-left'          => __( 'Arrow', 'jet-woo-builder' ),
					'fa fa-caret-left'          => __( 'Caret', 'jet-woo-builder' ),
					'fa fa-long-arrow-left'     => __( 'Long Arrow', 'jet-woo-builder' ),
					'fa fa-arrow-circle-left'   => __( 'Arrow Circle', 'jet-woo-builder' ),
					'fa fa-chevron-circle-left' => __( 'Chevron Circle', 'jet-woo-builder' ),
					'fa fa-caret-square-o-left' => __( 'Caret Square', 'jet-woo-builder' ),
				)
			);

		}

		/**
		 * Return availbale arrows list
		 * @return [type] [description]
		 */
		public function get_available_next_arrows_list() {

			return apply_filters(
				'jet_woo_builder/carousel/available_arrows/next',
				array(
					'fa fa-angle-right'          => __( 'Angle', 'jet-woo-builder' ),
					'fa fa-chevron-right'        => __( 'Chevron', 'jet-woo-builder' ),
					'fa fa-angle-double-right'   => __( 'Angle Double', 'jet-woo-builder' ),
					'fa fa-arrow-right'          => __( 'Arrow', 'jet-woo-builder' ),
					'fa fa-caret-right'          => __( 'Caret', 'jet-woo-builder' ),
					'fa fa-long-arrow-right'     => __( 'Long Arrow', 'jet-woo-builder' ),
					'fa fa-arrow-circle-right'   => __( 'Arrow Circle', 'jet-woo-builder' ),
					'fa fa-chevron-circle-right' => __( 'Chevron Circle', 'jet-woo-builder' ),
					'fa fa-caret-square-o-right' => __( 'Caret Square', 'jet-woo-builder' ),
				)
			);

		}

		/**
		 * Return availbale rating icon list
		 * @return [type] [description]
		 */
		public function get_available_rating_icons_list() {

			return apply_filters(
				'jet_woo_builder/available_rating_list/icons',
				array(
					'jetwoo-front-icon-rating-1'  => __( 'Rating 1', 'jet-woo-builder' ),
					'jetwoo-front-icon-rating-2'  => __( 'Rating 2', 'jet-woo-builder' ),
					'jetwoo-front-icon-rating-3'  => __( 'Rating 3', 'jet-woo-builder' ),
					'jetwoo-front-icon-rating-4'  => __( 'Rating 4', 'jet-woo-builder' ),
					'jetwoo-front-icon-rating-5'  => __( 'Rating 5', 'jet-woo-builder' ),
					'jetwoo-front-icon-rating-6'  => __( 'Rating 6', 'jet-woo-builder' ),
					'jetwoo-front-icon-rating-7'  => __( 'Rating 7', 'jet-woo-builder' ),
					'jetwoo-front-icon-rating-8'  => __( 'Rating 8', 'jet-woo-builder' ),
					'jetwoo-front-icon-rating-9'  => __( 'Rating 9', 'jet-woo-builder' ),
					'jetwoo-front-icon-rating-10' => __( 'Rating 10', 'jet-woo-builder' ),
					'jetwoo-front-icon-rating-11' => __( 'Rating 11', 'jet-woo-builder' ),
					'jetwoo-front-icon-rating-12' => __( 'Rating 12', 'jet-woo-builder' ),
					'jetwoo-front-icon-rating-13' => __( 'Rating 13', 'jet-woo-builder' ),
					'jetwoo-front-icon-rating-14' => __( 'Rating 14', 'jet-woo-builder' ),
				)
			);

		}

		/**
		 * Apply carousel wrappers for shortcode content if carousel is enabled.
		 *
		 * @param  string $content Module content.
		 * @param  array $settings Module settings.
		 *
		 * @return string
		 */
		public function get_carousel_wrapper_atts( $content = null, $settings = array() ) {

			if ( 'yes' !== $settings['carousel_enabled'] ) {
				return $content;
			}

			$carousel_settings = array(
				'columns'          => $settings['columns'],
				'columns_tablet'   => $settings['columns_tablet'],
				'columns_mobile'   => $settings['columns_mobile'],
				'autoplay_speed'   => $settings['autoplay_speed'],
				'autoplay'         => $settings['autoplay'],
				'infinite'         => $settings['infinite'],
				'pause_on_hover'   => $settings['pause_on_hover'],
				'speed'            => $settings['speed'],
				'arrows'           => $settings['arrows'],
				'dots'             => $settings['dots'],
				'slides_to_scroll' => $settings['slides_to_scroll'],
				'prev_arrow'       => $settings['prev_arrow'],
				'next_arrow'       => $settings['next_arrow'],
				'effect'           => isset( $settings['effect'] ) ? $settings['effect'] : 'slide',
			);

			$options = apply_filters( 'jet-woo-builder/tools/carousel/pre-options', $carousel_settings, $settings );

			$options = array(
				'slidesToShow'   => array(
					'desktop' => absint( $carousel_settings['columns'] ),
					'tablet'  => absint( $carousel_settings['columns_tablet'] ),
					'mobile'  => absint( $carousel_settings['columns_mobile'] ),
				),
				'autoplaySpeed'  => absint( $carousel_settings['autoplay_speed'] ),
				'autoplay'       => filter_var( $carousel_settings['autoplay'], FILTER_VALIDATE_BOOLEAN ),
				'infinite'       => filter_var( $carousel_settings['infinite'], FILTER_VALIDATE_BOOLEAN ),
				'pauseOnHover'   => filter_var( $carousel_settings['pause_on_hover'], FILTER_VALIDATE_BOOLEAN ),
				'speed'          => absint( $carousel_settings['speed'] ),
				'arrows'         => filter_var( $carousel_settings['arrows'], FILTER_VALIDATE_BOOLEAN ),
				'dots'           => filter_var( $carousel_settings['dots'], FILTER_VALIDATE_BOOLEAN ),
				'slidesToScroll' => absint( $carousel_settings['slides_to_scroll'] ),
				'prevArrow'      => $this->get_carousel_arrow(
					array( $carousel_settings['prev_arrow'], 'prev-arrow' )
				),
				'nextArrow'      => $this->get_carousel_arrow(
					array( $carousel_settings['next_arrow'], 'next-arrow' )
				),
			);

			if ( 1 === absint( $carousel_settings['columns'] ) ) {
				$options['fade'] = ( 'fade' === $carousel_settings['effect'] );
			}

			$options = apply_filters( 'jet-woo-builder/tools/carousel/options', $options, $settings );

			return sprintf(
				'<div class="jet-woo-carousel elementor-slick-slider" data-slider_options="%1$s" dir="ltr">%2$s</div>',
				htmlspecialchars( json_encode( $options ) ), $content
			);
		}

		/**
		 * Get term permalink.
		 *
		 * @since  1.0.0
		 * @return string
		 */
		public function get_term_permalink( $id = 0 ) {
			return esc_url( get_category_link( $id ) );
		}

		/**
		 * Trim text
		 *
		 * @since  1.0.0
		 * @return string
		 */
		public function trim_text( $text = '', $length = - 1, $trimmed_type = 'word', $after ) {

			if ( '' === $text ) {
				return $text;
			}

			if ( 0 === $length || '' === $length ) {
				return '';
			}

			if ( - 1 !== $length ) {
				if ( 'word' === $trimmed_type ) {
					$text = wp_trim_words( $text, $length, $after );
				} else {
					$text = wp_html_excerpt( $text, $length, $after );
				}
			}

			return $text;
		}

		public function is_builder_content_save() {

			if ( ! isset( $_REQUEST['action'] ) || 'elementor_ajax' !== $_REQUEST['action'] ) {
				return false;
			}

			if ( empty( $_REQUEST['actions'] ) ) {
				return false;
			}

			if ( false === strpos( $_REQUEST['actions'], 'save_builder' ) ) {
				return false;
			}

			return true;

		}

		/**
		 * Returns the instance.
		 *
		 * @since  1.0.0
		 * @return object
		 */
		public static function get_instance( $shortcodes = array() ) {

			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self( $shortcodes );
			}

			return self::$instance;
		}
	}

}

/**
 * Returns instance of Jet_Woo_Builder_Tools
 *
 * @return object
 */
function jet_woo_builder_tools() {
	return Jet_Woo_Builder_Tools::get_instance();
}
