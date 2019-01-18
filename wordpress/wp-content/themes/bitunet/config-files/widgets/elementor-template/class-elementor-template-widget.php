<?php
/**
 * Adds Bitunet_Elementor_Template_Widget widget.
 */


class Bitunet_Elementor_Template_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {

		parent::__construct(
			'bitunet-elementor-template-widget', // Base ID
			esc_html__( 'Elementor Template', 'bitunet' ), // Name
			array(
				'description' => esc_html__( 'Display your Elementor Template.', 'bitunet' ),
				'classname'   => 'elementor-template-widget'
			) // Args
		);

	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {

		if ( ! $instance['template_id'] ) {
			return;
		}

		$content = Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $instance['template_id'] );

		echo $content;

	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	/* display widget in widgets panel */
	function form( $instance ) {

		$template_id = isset( $instance['template_id'] ) ? $instance['template_id'] : '';

		$template_list = $this->get_template_list();

		?>
			<p>
				<label for="<?php echo $this->get_field_id( 'template_id' ); ?>"><?php esc_html__( 'Select Template:' , 'bitunet'); ?></label>
				<select id="<?php echo $this->get_field_id( 'template_id' ); ?>" name="<?php echo $this->get_field_name( 'template_id' ); ?>">
			<?php
			foreach ( $template_list as $key => $value ) {
				echo '<option value="' . $key . '"'
				     . selected( $template_id, $key, false )
				     . '>' . $value . '</option>';
			}
			?>
				</select>
			</p>
		<?php
	}

	/**
	 * Get elementor template list.
	 *
	 * @return array
	 */
	public function get_template_list() {
		$result_list = array(
			'' => esc_html__( '-- Select template --', 'bitunet' ),
		);

		$templates = Elementor\Plugin::$instance->templates_manager->get_source( 'local' )->get_items();

		if ( $templates ) {
			foreach ( $templates as $template ) {
				$result_list[ $template['template_id'] ] = sprintf( '%1$s (%2$s)', $template['title'], $template['type'] );
			}
		}

		return $result_list;
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	/* saves options chosen from the widgets panel */
	function update( $new_instance, $old_instance ) {
		$instance                = $old_instance;
		$instance['template_id'] = (int) $new_instance['template_id'];

		return $instance;
	}

}
add_action( 'widgets_init', 'bitunet_elementor_template_widget_register' );
// Register the widget.
function bitunet_elementor_template_widget_register() {
	register_widget( 'Bitunet_Elementor_Template_Widget' );
}