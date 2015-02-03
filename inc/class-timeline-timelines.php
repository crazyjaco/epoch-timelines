<?php

class Class_Timeline_Timelines {
	private static $instance = false;
	private $timeline_post_type = 'et_timelines';

	public static function instance(){
		if ( ! self::$instance ) {
			self::$instance = new Class_Timeline_Timelines;
		}
		return self::$instance;
	}

	function __construct() {
		add_action( 'init',                       array( $this, 'create_cpt_et_timelines' ) );
		add_action( 'add_meta_boxes',             array( $this, 'et_add_timeline_meta_box' ) );
		add_action( 'save_post',                  array( $this, 'et_save_timeline' ) );
		add_action( 'admin_enqueue_scripts',      array( $this, 'et_enqueue_scripts_styles' ) );
		add_action( 'wp_ajax_update_event_order', array( $this, 'ajax_update_event_order' ) );
	}

	/**
	 * Create the 'Timeline' custom post type
	 * @return [type] [description]
	 */
	function create_cpt_et_timelines() {
		// creating (registering) the custom type
		register_post_type( $this->timeline_post_type, /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
		 	// let's now add all the options for this post type
			array(
				'labels' => array(
						'name'               => __( 'Timeline',                       'epoch-timeline' ), /* This is the Title of the Group */
						'singular_name'      => __( 'Timeline',                       'epoch-timeline' ), /* This is the individual type */
						'all_items'          => __( 'All Timelines',                  'epoch-timeline' ), /* the all items menu item */
						'add_new'            => __( 'Add Timeline',                   'epoch-timeline' ), /* The add new menu item */
						'add_new_item'       => __( 'Add New Timeline',               'epoch-timeline' ), /* Add New Display Title */
						'edit'               => __( 'Edit',                           'epoch-timeline' ), /* Edit Dialog */
						'edit_item'          => __( 'Edit Timeline',                  'epoch-timeline' ), /* Edit Display Title */
						'new_item'           => __( 'New Timeline',                   'epoch-timeline' ), /* New Display Title */
						'view_item'          => __( 'View Timeline',                  'epoch-timeline' ), /* View Display Title */
						'search_items'       => __( 'Search Timelines',               'epoch-timeline' ), /* Search Custom Type Title */
						'not_found'          => __( 'Nothing found in the Database.', 'epoch-timeline' ), /* This displays if there are no entries yet */
						'not_found_in_trash' => __( 'Nothing found in Trash',         'epoch-timeline' ), /* This displays if there is nothing in the trash */
						'parent_item_colon'  => '',
					), /* end of arrays */
				'description'           => __( 'Timeline', 'epoch-timeline' ), /* Custom Type Description */
				'public'                => true,
				'publicly_queryable'    => true,
				'exclude_from_search'   => false,
				'show_ui'               => true,
				'query_var'             => true,
				'menu_position'         => 7, /* this is what order you want it to appear in on the left hand side menu */
				'menu_icon'             => 'dashicons-clock', /* the icon for the custom post type menu */
				'rewrite'	            => array(
						'slug'       => 'timeline',
						'with_front' => false,
					), /* you can specify its url slug */
				'has_archive'           => false, /* you can rename the slug here */
				'capability_type'       => 'page',
				'hierarchical'          => false,
				/* the next one is important, it tells what's enabled in the post editor */
				'supports' => array(
						'title',
						'editor',
						'excerpt',
						'sticky',
					)
			) /* end of options */
		); /* end of register post type */

	} // end function create_cpt_et_events

	function et_enqueue_scripts_styles( $hook_suffix ){
		global $post_type;

		if ( ! in_array( $hook_suffix, array( 'post-new.php', 'post.php' ) ) ) {
			return;
		}

		if ( ! ( $this->timeline_post_type === $post_type ) ) {
			return;
		}

		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script( 'et-timelines-js', plugins_url( '../js/epoch-timelines.js', __FILE__ ), array( 'jquery-ui-sortable', 'jquery' ), '1.0', true );
		wp_enqueue_style( 'et-timelines-css', plugins_url( '../css/epoch-timelines.css', __FILE__ ) );
		//wp_enqueue_style( 'wp-jquery-ui' );
		//wp_enqueue_style( 'apm-jquery-custom-ui', plugins_url( '/css/smoothness/jquery-ui-1.8.14.custom.css' , __FILE__ ) );
	}

	function et_add_timeline_meta_box( $post_type ) {

		if ( ! is_admin() ) {
			return;
		}

		if ( $this->timeline_post_type == $post_type ) {
			add_meta_box(
				'timeline_meta_box',
				__( 'Timeline', 'epoch-timeline' ),
				array( $this, 'render_timeline_meta_box_contents' ),
				$this->timeline_post_type,
				'advanced',
				'high'
			);
		}
	} // end function et_add_timeline_meta_box

	function et_save_timeline() {
		// Check for nonce
		if ( ! isset( $_POST['timeline_nonce'] ) ) {
			return;
		}

		// Verify nonce is valid
		if ( ! wp_verify_nonce( $_POST['timeline_nonce'], 'myplugin_meta_box' ) ) {
			return;
		}

		// Check if autosave and return if so
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Check user permissions
		if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return;
			}
		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
		}

		// Verify data is set
		if ( ! isset( $_POST['myplugin_new_field'] ) ) {
			return;
		}

		// Sanitize input

		// Update post meta
		update_post_meta( $post_id, '_my_meta_value_key', $my_data );

	} // end function et_save_timeline

	function render_timeline_meta_box_contents( $post ) {
		$events = get_children(array(
			'post_parent' => $post->ID,
			'post_type'   => 'et_events',
			'post_status' => 'publish',
			'orderby'     => 'menu_order',
			'order'       => 'ASC',
		) );
		printf( '<ul class="et-event-list" id="%d">', $post->ID );
		foreach ( $events as $event ){
			printf( '<li class="et-event-item" id="event_%d"><span class="et-event-title draggable-ui-icon">%s</span></li>', $event->ID, $event->post_title );
		}
		?>
		</ul>
		<?php
	} // end function render_timeline_meta_box_contents

	function ajax_update_event_order() {
		$ordered_events = $_POST['event'];
		error_log( print_r( $ordered_events, true ) );
		foreach ( $ordered_events as $key => $event_id ) {
			wp_update_post( array(
				'ID'         => $event_id,
				'menu_order' => $key,
			));
		}

	} // end function ajax_update_event_order

} // end Class_Timeline_Timelines
Class_Timeline_Timelines::instance();