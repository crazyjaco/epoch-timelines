<?php

class Class_Widget_Timeline_Timelines extends WP_Widget {

	function __construct(){
		parent::__construct(
			'widget-timeline-timelines', // Base ID
			__('Epoch Timeline', 'text_domain'), // Name
			array( 
				'description' => __( 'Display the timeline.', 'text_domain' ), 
			) // Args
		);
	}

	/**
	 *  Output the content of the widget
	 *
	 * @param array $args 
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );

		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
		do_shortcode( '[timeline id=187]' );

		echo __( 'Hello, World!', 'text_domain' );
		echo $args['after_widget'];		
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param  array $instance The widget options
	 */
	public function form( $instance ) {
		$title       = isset( $instance[ 'title' ] )       ? $instance[ 'title' ]       : __( 'New title', 'text_domain' );
		$timeline_id = isset( $instance[ 'timeline_id' ] ) ? $instance[ 'timeline_id' ] : '';
		error_log( 'timeline id: ' . $timeline_id );
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php

		// Retrieve listing of timelines
		$timelines = get_posts(
			array(
				'post_type'   => 'et_timelines',
				'orderby'     => 'title',
				'order'       => 'ASC',
				'numberposts' => -1,
			)
		);

		if ( ! empty( $timelines ) ) {
			// Create select input to choose timeline
			echo '<select id="' . $this->get_field_id( 'timeline_id' ) . '" name="' . $this->get_field_name( 'timeline_id' ) . '" class="widefat">';
			foreach ( $timelines as $timeline ) {
				printf( 
					'<option value="%s"%s>%s</option>', 
					esc_attr( $timeline->ID ), 
					selected( $timeline->ID, $timeline_id, false ), 
					esc_html( $timeline->post_title ) 
				);
			}
			echo '</select>';
		} else {
			echo 'Please create a timeline.';
		}	
	}

	/**
	 * Processing widget options on save
	 *
	 * @param  array $new_instance The new options
	 * @param  array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {
		$instance          = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['timeline_id'] = ( ! empty( $new_instance['timeline_id'] ) ) ? strip_tags( $new_instance['timeline_id'] ) : '';
		return $instance;
	}

}

// register widget
function register_this_widget() {
    register_widget( 'Class_Widget_Timeline_Timelines' );
}
add_action( 'widgets_init', 'register_this_widget' );