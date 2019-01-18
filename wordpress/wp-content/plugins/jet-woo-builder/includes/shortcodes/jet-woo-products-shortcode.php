<?php

/**
 * Products shortcode class
 */
class Jet_Woo_Products_Shortcode extends Jet_Woo_Builder_Shortcode_Base {

	/**
	 * Shortocde tag
	 *
	 * @return string
	 */
	public function get_tag() {
		return 'jet-woo-products';
	}

	/**
	 * Shortocde attributes
	 *
	 * @return array
	 */
	public function get_atts() {

		$columns = jet_woo_builder_tools()->get_select_range( 6 );

		return apply_filters( 'jet-woo-builder/shortcodes/jet-woo-products/atts', array(
			'presets'           => array(
				'type'    => 'select',
				'label'   => esc_html__( 'Product Presets', 'jet-woo-builder' ),
				'default' => 'preset-1',
				'options' => array(
					'preset-1' => esc_html__( 'Preset 1', 'jet-woo-builder' ),
					'preset-2' => esc_html__( 'Preset 2', 'jet-woo-builder' ),
					'preset-3' => esc_html__( 'Preset 3', 'jet-woo-builder' ),
					'preset-4' => esc_html__( 'Preset 4', 'jet-woo-builder' ),
					'preset-5' => esc_html__( 'Preset 5', 'jet-woo-builder' ),
					'preset-6' => esc_html__( 'Preset 6', 'jet-woo-builder' ),
					'preset-7' => esc_html__( 'Preset 7 ', 'jet-woo-builder' ),
					'preset-8' => esc_html__( 'Preset 8 ', 'jet-woo-builder' ),
					'preset-9' => esc_html__( 'Preset 9 ', 'jet-woo-builder' ),
					'preset-10' => esc_html__( 'Preset 10', 'jet-woo-builder' ),
				),
			),
			'columns'           => array(
				'type'       => 'select',
				'responsive' => true,
				'label'      => esc_html__( 'Columns', 'jet-woo-builder' ),
				'default'    => 3,
				'options'    => $columns,
			),
			'columns_tablet'    => array(
				'default' => 2,
			),
			'columns_mobile'    => array(
				'default' => 1,
			),
			'equal_height_cols' => array(
				'label'        => esc_html__( 'Equal Columns Height', 'jet-woo-builder' ),
				'type'         => 'switcher',
				'label_on'     => esc_html__( 'Yes', 'jet-woo-builder' ),
				'label_off'    => esc_html__( 'No', 'jet-woo-builder' ),
				'return_value' => 'true',
				'default'      => '',
			),
			'columns_gap'       => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Add gap between columns', 'jet-woo-builder' ),
				'label_on'     => esc_html__( 'Yes', 'jet-woo-builder' ),
				'label_off'    => esc_html__( 'No', 'jet-woo-builder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			),
			'rows_gap'          => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Add gap between rows', 'jet-woo-builder' ),
				'label_on'     => esc_html__( 'Yes', 'jet-woo-builder' ),
				'label_off'    => esc_html__( 'No', 'jet-woo-builder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			),
			'number'            => array(
				'type'      => 'number',
				'label'     => esc_html__( 'Products Number', 'jet-woo-builder' ),
				'default'   => 3,
				'min'       => - 1,
				'max'       => 1000,
				'step'      => 1,
				'separator' => 'before'
			),
			'products_query'    => array(
				'type'    => 'select',
				'label'   => esc_html__( 'Query products by', 'jet-woo-builder' ),
				'default' => 'all',
				'options' => $this->get_products_query_type()
			),
			'products_ids'      => array(
				'type'      => 'text',
				'label'     => esc_html__( 'Set comma separated IDs list (10, 22, 19 etc.)', 'jet-woo-builder' ),
				'default'   => '',
				'condition' => array(
					'products_query' => array( 'ids' ),
				),
			),
			'products_cat'      => array(
				'type'      => 'select2',
				'label'     => esc_html__( 'Category', 'jet-woo-builder' ),
				'default'   => '',
				'multiple'  => true,
				'options'   => $this->get_product_categories(),
				'condition' => array(
					'products_query' => array( 'category' ),
				),
			),
			'products_tag'      => array(
				'type'      => 'select2',
				'label'     => esc_html__( 'Tag', 'jet-woo-builder' ),
				'default'   => '',
				'multiple'  => true,
				'options'   => $this->get_product_tags(),
				'condition' => array(
					'products_query' => array( 'tag' ),
				),
			),
			'products_order'    => array(
				'type'    => 'select',
				'label'   => esc_html__( 'Order by', 'jet-woo-builder' ),
				'default' => 'default',
				'options' => array(
					'default' => esc_html__( 'Date', 'jet-woo-builder' ),
					'price'   => esc_html__( 'Price', 'jet-woo-builder' ),
					'rand'    => esc_html__( 'Random', 'jet-woo-builder' ),
					'sales'   => esc_html__( 'Sales', 'jet-woo-builder' ),
					'rated'   => esc_html__( 'Top rated', 'jet-woo-builder' ),
				),
			),
			'show_title'        => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Show Products Title', 'jet-woo-builder' ),
				'label_on'     => esc_html__( 'Yes', 'jet-woo-builder' ),
				'label_off'    => esc_html__( 'No', 'jet-woo-builder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before'
			),
			'title_length'      => array(
				'type'      => 'number',
				'label'     => esc_html__( 'Title Words Count', 'jet-woo-builder' ),
				'min'       => 1,
				'default'   => 10,
				'condition' => array(
					'show_title' => array( 'yes' )
				)
			),
			'thumb_size'        => array(
				'type'    => 'select',
				'label'   => esc_html__( 'Featured Image Size', 'jet-woo-builder' ),
				'default' => 'woocommerce_thumbnail',
				'options' => jet_woo_builder_tools()->get_image_sizes(),
			),
			'show_badges'       => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Show Badges', 'jet-woo-builder' ),
				'label_on'     => esc_html__( 'Yes', 'jet-woo-builder' ),
				'label_off'    => esc_html__( 'No', 'jet-woo-builder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			),
			'sale_badge_text'   => array(
				'type'      => 'text',
				'label'     => esc_html__( 'Set sale badge text', 'jet-woo-builder' ),
				'default'   => esc_html__( 'Sale!', 'jet-woo-builder' ),
				'condition' => array(
					'show_badges' => array( 'yes' ),
				),
			),
			'show_excerpt'      => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Show Product Excerpt', 'jet-woo-builder' ),
				'label_on'     => esc_html__( 'Yes', 'jet-woo-builder' ),
				'label_off'    => esc_html__( 'No', 'jet-woo-builder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => array(
					'presets!' => array( 'preset-4' )
				)
			),
			'excerpt_length'    => array(
				'type'      => 'number',
				'label'     => esc_html__( 'Excerpt Words Count', 'jet-woo-builder' ),
				'min'       => 1,
				'default'   => 10,
				'condition' => array(
					'show_excerpt' => array( 'yes' )
				)
			),
			'show_cat'          => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Show Product Categories', 'jet-woo-builder' ),
				'label_on'     => esc_html__( 'Yes', 'jet-woo-builder' ),
				'label_off'    => esc_html__( 'No', 'jet-woo-builder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			),
			'show_tag'          => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Show Product Tags', 'jet-woo-builder' ),
				'label_on'     => esc_html__( 'Yes', 'jet-woo-builder' ),
				'label_off'    => esc_html__( 'No', 'jet-woo-builder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			),
			'show_price'        => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Show Product Price', 'jet-woo-builder' ),
				'label_on'     => esc_html__( 'Yes', 'jet-woo-builder' ),
				'label_off'    => esc_html__( 'No', 'jet-woo-builder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			),
			'show_rating'       => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Show Product Rating', 'jet-woo-builder' ),
				'label_on'     => esc_html__( 'Yes', 'jet-woo-builder' ),
				'label_off'    => esc_html__( 'No', 'jet-woo-builder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			),
			'show_button'       => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Show Add To Cart Button', 'jet-woo-builder' ),
				'label_on'     => esc_html__( 'Yes', 'jet-woo-builder' ),
				'label_off'    => esc_html__( 'No', 'jet-woo-builder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			),
			'button_use_ajax_style' => array(
				'label'        => esc_html__( 'Use default ajax add to cart styles', 'jet-woo-builder' ),
				'description'  => esc_html__( 'This option enables default WooCommerce styles for \'Add to Cart\' ajax button (\'Loading\' and \'Added\' statements)', 'jet-woo-builder' ),
				'type'         => 'switcher',
				'label_on'     => esc_html__( 'Yes', 'jet-woo-builder' ),
				'label_off'    => esc_html__( 'No', 'jet-woo-builder' ),
				'return_value' => 'yes',
				'default'      => '',
				'condition' => array(
					'show_button' => array( 'yes' )
				)
			)
		) );

	}

	/**
	 * Return list query types
	 *
	 * @return array
	 */
	public function get_products_query_type() {
		$args = array(
			'all'      => esc_html__( 'All', 'jet-woo-builder' ),
			'featured' => esc_html__( 'Featured', 'jet-woo-builder' ),
			'sale'     => esc_html__( 'Sale', 'jet-woo-builder' ),
			'tag'      => esc_html__( 'Tag', 'jet-woo-builder' ),
			'category' => esc_html__( 'Category', 'jet-woo-builder' ),
			'ids'      => esc_html__( 'Specific IDs', 'jet-woo-builder' ),
			'viewed'   => esc_html__( 'Recently Viewed', 'jet-woo-builder' ),
		);

		$single_product_args = array(
			'related'     => esc_html__( 'Related', 'jet-woo-builder' ),
			'up-sells'    => esc_html__( 'Up Sells', 'jet-woo-builder' ),
			'cross-sells' => esc_html__( 'Cross Sells', 'jet-woo-builder' ),
		);

		if ( is_product() ) {
			$args = wp_parse_args( $single_product_args, $args );
		}

		return $args;
	}

	/**
	 * Get categories list.
	 *
	 * @return array
	 */
	public function get_product_categories() {

		$categories = get_terms( 'product_cat' );

		if ( empty( $categories ) || ! is_array( $categories ) ) {
			return array();
		}

		return wp_list_pluck( $categories, 'name', 'term_id' );

	}

	/**
	 * Get categories list.
	 *
	 * @return array
	 */
	public function get_product_tags() {

		$tags = get_terms( 'product_tag' );

		if ( empty( $tags ) || ! is_array( $tags ) ) {
			return array();
		}

		return wp_list_pluck( $tags, 'name', 'term_id' );

	}

	/**
	 * Get preset template
	 *
	 * @param  [type] $name [description]
	 *
	 * @return [type]       [description]
	 */
	public function get_product_preset_template() {
		return jet_woo_builder()->get_template( $this->get_tag() . '/global/presets/' . $this->get_attr( 'presets' ) . '.php' );
	}

	/**
	 * Query products by attributes
	 *
	 * @return object
	 */
	public function query() {

		$defaults = apply_filters( 'jet-woo-builder/shortcodes/jet-woo-products/query-args', array(
			'post_status'   => 'publish',
			'post_type'     => 'product',
			'no_found_rows' => 1,
			'meta_query'    => array(),
			'tax_query'     => array(
				'relation' => 'AND',
			)
		), $this );

		$query_type                   = $this->get_attr( 'products_query' );
		$query_order                  = $this->get_attr( 'products_order' );
		$query_args['posts_per_page'] = intval( $this->get_attr( 'number' ) );
		$product_visibility_term_ids  = wc_get_product_visibility_term_ids();
		$viewed_products              = ! empty( $_COOKIE['woocommerce_recently_viewed'] ) ? (array) explode( '|', wp_unslash( $_COOKIE['woocommerce_recently_viewed'] ) ) : array();
		$viewed_products              = array_reverse( array_filter( array_map( 'absint', $viewed_products ) ) );

		if ( ( 'viewed' === $query_type ) && empty( $viewed_products ) ) {
			return false;
		}

		if ( $this->is_single_linked_products( $query_type ) ) {
			global $product;
			$product = wc_get_product();

			if ( ! $product ) {
				return false;
			}

			switch ( $query_type ) {
				case 'related':
					$query_args['post__in'] = wc_get_related_products( $product->get_id(), $query_args['posts_per_page'], $product->get_upsell_ids() );
					$query_args['orderby']  = 'post__in';
					break;
				case 'up-sells':
					$query_args['post__in'] = $product->get_upsell_ids();
					$query_args['orderby']  = 'post__in';
					break;
				case 'cross-sells':
					$query_args['post__in'] = $product->get_cross_sell_ids();
					$query_args['orderby']  = 'post__in';
					break;
			}

			if ( empty( $query_args['post__in'] ) ) {
				return false;
			}
		}

		switch ( $query_type ) {
			case 'category':
				if ( '' !== $this->get_attr( 'products_cat' ) ) {
					$query_args['tax_query'][] =  array(
						'taxonomy' => 'product_cat',
						'field'    => 'term_id',
						'terms'    => explode( ',', $this->get_attr( 'products_cat' ) ),
						'operator' => 'IN',
					);
				}
				break;
			case 'tag':
				if ( '' !== $this->get_attr( 'products_tag' ) ) {
					$query_args['tax_query'][] = array(
						'taxonomy' => 'product_tag',
						'field'    => 'term_id',
						'terms'    => explode( ',', $this->get_attr( 'products_tag' ) ),
						'operator' => 'IN',
					);
				}
				break;
			case 'ids':
				if ( '' !== $this->get_attr( 'products_ids' ) ) {
					$query_args['post__in'] = explode(
						',',
						str_replace( ' ', '', $this->get_attr( 'products_ids' ) )
					);
				}
				break;
			case 'featured':
				$query_args['tax_query'][] = array(
					'taxonomy' => 'product_visibility',
					'field'    => 'term_taxonomy_id',
					'terms'    => $product_visibility_term_ids['featured'],
				);
				break;
			case 'sale':
				$product_ids_on_sale    = wc_get_product_ids_on_sale();
				$product_ids_on_sale[]  = 0;
				$query_args['post__in'] = $product_ids_on_sale;
				break;
			case 'viewed':
				$query_args['post__in'] = $viewed_products;
				$query_args['orderby']  = 'post__in';
		}

		switch ( $query_order ) {
			case 'price' :
				$query_args['meta_key'] = '_price';
				$query_args['orderby']  = 'meta_value_num';
				break;
			case 'rand' :
				$query_args['orderby'] = 'rand';
				break;
			case 'sales' :
				$query_args['meta_key'] = 'total_sales';
				$query_args['orderby']  = 'meta_value_num';
				break;
			case 'rated':
				$query_args['meta_key'] = '_wc_average_rating';
				$query_args['orderby']  = 'meta_value_num';
				break;
			default :
				$query_args['orderby'] = 'date';
		}

		$query_args = wp_parse_args( $query_args, $defaults );

		return new WP_Query( $query_args );
	}

	/**
	 * Return true if linked products query type
	 *
	 * @param $query_type
	 *
	 * @return bool
	 */
	public function is_single_linked_products( $query_type ) {

		if ( 'related' === $query_type || 'up-sells' === $query_type || 'cross-sells' === $query_type ) {
			return true;
		}

		return false;

	}

	/**
	 * Products shortocde function
	 *
	 * @param  array $atts Attributes array.
	 *
	 * @return string
	 */
	public function _shortcode( $content = null ) {
		$query = $this->query();

		if ( false === $query ) {
			return;
		}

		if ( empty( $query ) || is_wp_error( $query ) ) {
			echo sprintf( '<h3 class="jet-woo-products__not-found">%s</h3>', esc_html__( 'Products not found', 'jet-woo-builder' ) );

			return false;
		}

		$loop_start = $this->get_template( 'loop-start' );
		$loop_item  = $this->get_template( 'loop-item' );
		$loop_end   = $this->get_template( 'loop-end' );

		global $post;

		ob_start();

		/**
		 * Hook before loop start template included
		 */
		do_action( 'jet-woo-builder/shortcodes/jet-woo-products/loop-start' );

		include $loop_start;

		while ( $query->have_posts() ) {

			$query->the_post();
			$post = $query->post;

			setup_postdata( $post );

			/**
			 * Hook before loop item template included
			 */
			do_action( 'jet-woo-builder/shortcodes/jet-woo-products/loop-item-start' );

			include $loop_item;

			/**
			 * Hook after loop item template included
			 */
			do_action( 'jet-woo-builder/shortcodes/jet-woo-products/loop-item-end' );

		}

		include $loop_end;

		/**
		 * Hook after loop end template included
		 */
		do_action( 'jet-woo-builder/shortcodes/jet-woo-products/loop-end' );

		wp_reset_postdata();

		return ob_get_clean();

	}

}
