<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Jet_Popup_Conditions_Manager' ) ) {

	/**
	 * Define Jet_Popup_Conditions_Manager class
	 */
	class Jet_Popup_Conditions_Manager {

		private $_conditions         = [];
		private $_matched_conditions = [];
		private $_processed_childs   = [];
		public  $conditions_key      = 'jet_popup_conditions';
		public  $page_origin_data    = [];
		public  $attached_popups     = [];

		/**
		 * [__construct description]
		 */
		public function __construct() {

			$this->register_conditions();

			add_action( 'elementor/frontend/builder_content_data', array( $this, 'get_builder_content_data' ) );

			add_action( 'elementor/editor/after_save', array( $this, 'update_site_conditions' ) );

			add_action( 'wp_trash_post', array( $this, 'remove_post_from_site_conditions' ) );
		}

		/**
		 * [update_site_conditions description]
		 * @param  [type] $post_id [description]
		 * @return [type]          [description]
		 */
		public function update_site_conditions( $post_id ) {

			$post = get_post( $post_id );

			if ( jet_popup()->post_type->slug() !== $post->post_type ) {
				return;
			}

			$type      = get_post_meta( $post_id, '_elementor_template_type', true );
			$sanitized = $this->get_post_conditions( $post_id );
			$saved     = get_option( $this->conditions_key, array() );

			if ( ! isset( $saved[ $type ] ) ) {
				$saved[ $type ] = array();
			}

			$saved[ $type ][ $post_id ] = $sanitized;

			update_option( $this->conditions_key, $saved, true );

		}

		/**
		 * [get_site_conditions description]
		 * @return [type] [description]
		 */
		public function get_site_conditions() {
			return get_option( $this->conditions_key, array() );
		}

		/**
		 * [get_post_conditions description]
		 * @param  [type] $post_id [description]
		 * @return [type]          [description]
		 */
		public function get_post_conditions( $post_id ) {

			$group      = '';
			$conditions = get_post_meta( $post_id, '_elementor_page_settings', true );
			$sanitized  = array();

			if ( ! $conditions ) {
				$conditions = array();
			}

			foreach ( $conditions as $condition => $value ) {

				if ( false === strpos( $condition, 'conditions_' ) ) {
					continue;
				}

				if ( 'conditions_top' === $condition ) {
					$group             = $value;
					$sanitized['main'] = $group;
					continue;
				}

				if ( 'conditions_sub_' . $group === $condition ) {
					$sanitized[ $value ] = $this->get_condition_args( $value, $conditions );
					continue;
				}

			}

			return $sanitized;

		}

		/**
		 * Check if post currently presented in conditions array and remove it if yes.
		 *
		 * @param  integer $post_id    [description]
		 * @param  array   $conditions [description]
		 * @return [type]              [description]
		 */
		public function remove_post_from_conditions_array( $post_id = 0, $conditions = array() ) {

			foreach ( $conditions as $type => $type_conditions ) {
				if ( array_key_exists( $post_id, $type_conditions ) ) {
					unset( $conditions[ $type ][ $post_id ] );
				}
			}

			return $conditions;

		}

		public function remove_post_from_site_conditions( $post_id = 0 ) {

			$conditions = get_option( $this->conditions_key, array() );
			$conditions = $this->remove_post_from_conditions_array( $post_id, $conditions );

			update_option( $this->conditions_key, $conditions, true );
		}

		/**
		 * Find condition arguments in saved data
		 *
		 * @param  [type] $cid        [description]
		 * @param  [type] $conditions [description]
		 * @return [type]             [description]
		 */
		public function get_condition_args( $cid, $conditions ) {

			$args   = array();
			$prefix = 'conditions_' . $cid . '_';

			foreach ( $conditions as $condition => $value ) {

				if ( false === strpos( $condition, $prefix ) ) {
					continue;
				}

				$args[ str_replace( $prefix, '', $condition ) ] = $value;
			}

			return $args;
		}

		public function register_conditions() {

			$base_path = jet_popup()->plugin_path( 'includes/conditions/' );

			require $base_path . 'base.php';

			$default = array(

				// Singular conditions
				'Jet_Popup_Conditions_Front'                       => $base_path . 'singular-front-page.php',
				'Jet_Popup_Conditions_Singular_Post_Type'          => $base_path . 'singular-post-type.php',
				'Jet_Popup_Conditions_Singular_Post'               => $base_path . 'singular-post.php',
				'Jet_Popup_Conditions_Singular_Post_From_Category' => $base_path . 'singular-post-from-cat.php',
				'Jet_Popup_Conditions_Singular_Post_From_Tag'      => $base_path . 'singular-post-from-tag.php',
				'Jet_Popup_Conditions_Singular_Page'               => $base_path . 'singular-page.php',
				'Jet_Popup_Conditions_Singular_Page_Child'         => $base_path . 'singular-page-child.php',
				'Jet_Popup_Conditions_Singular_Page_Template'      => $base_path . 'singular-page-template.php',
				'Jet_Popup_Conditions_Singular_404'                => $base_path . 'singular-404.php',

				// Archive conditions
				'Jet_Popup_Conditions_Archive_All'                 => $base_path . 'archive-all.php',
				'Jet_Popup_Conditions_Archive_Post_Type'           => $base_path . 'archive-post-type.php',
				'Jet_Popup_Conditions_Archive_Category'            => $base_path . 'archive-category.php',
				'Jet_Popup_Conditions_Archive_Tag'                 => $base_path . 'archive-tag.php',
			);

			foreach ( $default as $class => $file ) {
				require $file;

				$this->register_condition( $class );
			}

			/**
			 * You could register custom conditions on this hook.
			 * Note - each condition should be presented like instance of class 'Jet_Popup_Conditions_Base'
			 */
			do_action( 'jet-popup/conditions/register', $this );

		}

		/**
		 * [register_condition description]
		 * @param  [type] $class [description]
		 * @return [type]        [description]
		 */
		public function register_condition( $class ) {
			$instance = new $class;
			$this->_conditions[ $instance->get_id() ] = $instance;
		}

		/**
		 * [get_condition description]
		 * @param  [type] $condition_id [description]
		 * @return [type]               [description]
		 */
		public function get_condition( $condition_id ) {
			return isset( $this->_conditions[ $condition_id ] ) ? $this->_conditions[ $condition_id ] : false;
		}

		/**
		 * Returns conditions groups
		 *
		 * @return void
		 */
		public function get_groups() {
			return array(
				'entire'   => __( 'Entire Site', 'jet-popup' ),
				'singular' => __( 'Singular', 'jet-popup' ),
				'archive'  => __( 'Archive', 'jet-popup' ),
			);
		}

		/**
		 * Regsiter apropriate condition controls
		 *
		 * @return [type] [description]
		 */
		public function register_condition_controls( $controls_manager ) {

			if ( ! $controls_manager ) {
				return;
			}

			$prepared_data = $this->prepare_conditions_for_controls();
			$default       = array( '' => esc_html__( 'Not Selected', 'jet-popup' ) );
			$general       = $default + $this->get_groups();

			$controls_manager->add_control(
				'conditions_top',
				array(
					'label'   => esc_html__( 'General', 'jet-popup' ),
					'type'    => Elementor\Controls_Manager::SELECT,
					'default' => '',
					'options' => $general,
				)
			);

			foreach ( $prepared_data as $group => $options ) {

				if ( empty( $options ) ) {
					continue;
				}

				$condition = array(
					'conditions_top' => $group,
				);

				$control_name = 'conditions_sub_' . $group;

				$controls_manager->add_control(
					$control_name,
					array(
						'label'     => $general[ $group ],
						'type'      => Elementor\Controls_Manager::SELECT,
						'default'   => '',
						'options'   => $this->esc_options( $options ),
						'condition' => $condition,
					)
				);

				$this->register_child_options_group( $options, $controls_manager, $control_name, $condition );

			}

		}

		/**
		 * Get options list from options data
		 *
		 * @param  [type] $data [description]
		 * @return [type]       [description]
		 */
		public function esc_options( $data ) {

			$result = array();

			foreach ( $data as $id => $item ) {
				$result[ $id ] = $item['label'];
			}

			return $result;
		}

		public function esc_child_options( $childs ) {

			$result = array();

			foreach ( $childs as $child ) {
				$instance = $this->get_condition( $child );
				$result[ $child ] = $instance->get_label();
			}

			return $result;
		}

		/**
		 * [register_child_options_group description]
		 * @param  [type] $options          [description]
		 * @param  [type] $controls_manager [description]
		 * @param  [type] $parent_id        [description]
		 * @param  [type] $parent_condition [description]
		 * @return [type]                   [description]
		 */
		public function register_child_options_group( $options, $controls_manager, $parent_id, $parent_condition ) {

			foreach ( $options as $cid => $data ) {

				$this->register_child_controls( $cid, $controls_manager, $parent_id, $parent_condition );

				if ( empty( $data['childs'] ) ) {
					continue;
				}

				$condition = array_merge(
					$parent_condition,
					array(
						$parent_id => $cid
					)
				);

				$instance     = $this->get_condition( $cid );
				$control_name = 'conditions_sub_' . $cid;

				$controls_manager->add_control(
					$control_name,
					array(
						'label'     => $instance->get_label(),
						'type'      => Elementor\Controls_Manager::SELECT,
						'default'   => '',
						'options'   => $this->esc_child_options( $data['childs'] ),
						'condition' => $condition,
					)
				);

				$this->register_child_options_item( $data['childs'], $controls_manager, $control_name, $condition );

			}

		}

		/**
		 * [register_child_options_item description]
		 * @param  [type] $items            [description]
		 * @param  [type] $controls_manager [description]
		 * @param  [type] $parent_id        [description]
		 * @param  [type] $parent_condition [description]
		 * @return [type]                   [description]
		 */
		public function register_child_options_item( $items, $controls_manager, $parent_id, $parent_condition ) {

			foreach ( $items as $cid ) {

				$instance = $this->get_condition( $cid );
				$childs   = $instance->get_childs();

				$this->register_child_controls( $cid, $controls_manager, $parent_id, $parent_condition );

				if ( empty( $childs ) ) {
					continue;
				}

				$condition = array_merge(
					$parent_condition,
					array(
						$parent_id => $cid
					)
				);

				$control_name = 'conditions_sub_' . $cid;

				$controls_manager->add_control(
					$control_name,
					array(
						'label'     => $instance->get_label(),
						'type'      => Elementor\Controls_Manager::SELECT,
						'default'   => '',
						'options'   => $this->esc_child_options( $childs ),
						'condition' => $condition,
					)
				);

				$this->register_child_options_item( $childs, $controls_manager, $control_name, $condition );

			}

		}

		/**
		 * [register_child_controls description]
		 * @param  [type] $condition_id     [description]
		 * @param  [type] $controls_manager [description]
		 * @param  [type] $parent_id        [description]
		 * @param  [type] $parent_condition [description]
		 * @return [type]                   [description]
		 */
		public function register_child_controls( $condition_id, $controls_manager, $parent_id, $parent_condition ) {

			$instance = $this->get_condition( $condition_id );
			$controls = $instance->get_controls();

			if ( empty( $controls ) ) {
				return;
			}

			foreach ( $controls as $control_id => $control_options ) {

				$id = 'conditions_' . $condition_id . '_' . $control_id;

				$control_options['condition'] = array_merge(
					array( $parent_id => $condition_id ),
					$parent_condition
				);

				$controls_manager->add_control( $id, $control_options );
			}

		}

		/**
		 * Prepare registerred conditions for controls
		 *
		 * @return array
		 */
		public function prepare_conditions_for_controls() {

			$sorted_conditions = array();

			foreach ( $this->_conditions as $cid => $instance ) {

				if ( in_array( $cid, $this->_processed_childs ) ) {
					continue;
				}

				$group  = $instance->get_group();
				$childs = $instance->get_childs();

				if ( ! isset( $sorted_conditions[ $group ] ) ) {
					$sorted_conditions[ $group ] = array();
				}

				$current = array(
					'label' => $instance->get_label(),
				);

				if ( ! empty( $childs ) ) {
					$current['childs'] = $this->add_condition_childs( $childs );
				}

				$sorted_conditions[ $group ][ $cid ] = $current;

			}

			return $sorted_conditions;
		}

		/**
		 * Add child conditions to stack
		 */
		public function add_condition_childs( $childs ) {

			$result = array();

			foreach ( $childs as $cid ) {
				$instance = $this->get_condition( $cid );
				$childs   = $instance->get_childs();
				$current  = array(
					'label' => $instance->get_label(),
				);

				if ( ! empty( $childs ) ) {
					$current['childs'] = $this->add_condition_childs( $childs );
				}

				$result[ $cid ] = $current;

				if ( ! in_array( $cid, $this->_processed_childs ) ) {
					$this->_processed_childs[] = $cid;
				}
			}

			return $result;

		}

		/**
		 * Run condtions check for passed type. Return {template_id} on firs condition match.
		 * If not matched - return false
		 *
		 * @return int|bool
		 */
		public function find_matched_conditions( $type ) {

			if ( isset( $this->_matched_conditions[ $type ] ) ) {
				return $this->_matched_conditions[ $type ];
			}

			$conditions = get_option( $this->conditions_key, array() );

			if ( empty( $conditions[ $type ] ) ) {
				$this->_matched_conditions[ $type ] = false;
				return false;
			}

			$popup_id_list = array();

			foreach ( $conditions[ $type ] as $template_id => $template_conditions ) {

				if ( empty( $template_conditions['main'] ) ) {
					continue;
				}

				if ( 'entire' === $template_conditions['main'] ) {
					$this->_matched_conditions[ $type ] = $template_id;
					$popup_id_list[] = $template_id;
					continue;
				}

				foreach ( $template_conditions as $cid => $args ) {

					$instance = $this->get_condition( $cid );

					if ( ! $instance ) {
						continue;
					}

					$check = call_user_func( array( $instance, 'check' ), $args );

					if ( true === $check ) {
						$this->_matched_conditions[ $type ] = $template_id;
						$popup_id_list[] = $template_id;

						continue;
					}

				}

			}

			if ( ! empty( $popup_id_list ) ) {
				return $popup_id_list;
			}

			$this->_matched_conditions[ $type ] = false;
			return false;

		}

		/**
		 * Get active conditions for passed post
		 *
		 * @param  [type] $post_id [description]
		 * @return [type]          [description]
		 */
		public function post_conditions_verbose( $post_id = null ) {

			$conditions = $this->get_post_conditions( $post_id );

			if ( empty( $conditions['main'] ) ) {
				return;
			}

			if ( 'entire' === $conditions['main'] ) {
				return __( 'Entire Site', 'jet-popup' );
			}

			unset( $conditions['main'] );

			$condition_keys = array_keys( $conditions );
			$verbose        = '';

			foreach ( $condition_keys as $key ) {

				$instance     = $this->get_condition( $key );
				$verbose_args = $instance->verbose_args( $conditions[ $key ] );

				if ( ! empty( $verbose_args ) ) {
					$verbose_args = ': ' . $verbose_args;
				}

				$verbose .= sprintf( '<div>%1$s%2$s</div>', $instance->get_label(), $verbose_args );

			}

			return $verbose;

		}

		/**
		 * [get_attached_popups description]
		 * @return [type] [description]
		 */
		public function get_attached_popups() {
			return ( is_array( $this->attached_popups ) && ! empty( $this->attached_popups ) ) ? $this->attached_popups : false;
		}

		/**
		 * [get_builder_content_data description]
		 * @param  [type] $data [description]
		 * @return [type]       [description]
		 */
		public function get_builder_content_data( $origin_data ) {

			$section_list = $origin_data;

			$this->find_widget_popup_attachment( $section_list );

			return $origin_data;
		}

		/**
		 * [find_widget_popup_attachment description]
		 * @param  [type] $sections [description]
		 * @return [type]           [description]
		 */
		public function find_widget_popup_attachment( $sections ) {

			if ( ! empty( $sections ) ) {
				foreach ( $sections as $key => $section ) {
					$this->find_attached_popup_in_section( $section );
				}
			}

		}

		/**
		 * [find_attached_popup_in_section description]
		 * @param  [type] $section [description]
		 * @return [type]          [description]
		 */
		public function find_attached_popup_in_section( $section ) {

			if ( empty( $section ) || ! is_array( $section ) ) {
				return false;
			}

			if ( empty( $section['elements'] ) ) {
				return false;
			}

			foreach ( $section['elements'] as $key => $column ) {
				if ( ! empty( $column['elements'] ) ) {
					foreach ( $column['elements'] as $key => $element ) {
						$element_type = $element['elType'];

						if ( 'widget' === $element_type && ! empty( $element['settings']['jet_attached_popup'] ) ) {
							$this->attached_popups[] = $element['settings']['jet_attached_popup'];
						}

						if ( 'section' === $element_type ) {
							$this->find_attached_popup_in_section( $element );
						}

					}
				}
			}

		}


	}

}
