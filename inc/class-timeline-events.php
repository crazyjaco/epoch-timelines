<?php
/**
 * Class Timeline Events
 *
 * @link       https://wordpress.org/plugins/epoch-timelines/
 * @since      1.0.0
 *
 * @package    epoch-timelines
 * @subpackage epoch-timelines/inc
 */

/**
 * Class handling the Timeline Event custom post type.
 */
class Class_Timeline_Events {
	/**
	 * Instance of the class; False if not instantiated yet.
	 *
	 * @var boolean
	 */
	private static $instance = false;

	/**
	 * String constant containing name of the custom post type.
	 *
	 * @var string
	 */
	public $timeline_post_type = 'et_events';

	/**
	 * Instantiates the Singleton if not already done and return it.
	 *
	 * @return obj  Instance of this class; false on failure
	 */
	public static function instance() {
		if ( ! self::$instance ) {
			self::$instance = new Class_Timeline_Events;
		}
		return self::$instance;
	}

	/**
	 * Class constructor
	 */
	function __construct() {
		add_action( 'init',                  array( $this, 'create_cpt_et_events' ) );
		add_action( 'add_meta_boxes',        array( $this, 'et_add_timeline_select_meta_box' ) );

		/* add_action( 'admin_enqueue_scripts', array( $this, 'et_enqueue_admin_scripts_styles' ) ); */
	}

	/**
	 * Retrieve the post type for this class.
	 *
	 * @return string Post Type for this class.
	 */
	public function get_post_type() {
		return $this->timeline_post_type;
	}

	/**
	 * Create the Timeline 'Event' custom post type
	 *
	 * @return void
	 */
	function create_cpt_et_events() {
		// Creating (registering) the custom type.
		register_post_type( $this->timeline_post_type,
		 	// Let's now add all the options for this post type.
			array(
				'labels' => array(
						'name'               => __( 'Timeline Event',                 'epoch-timeline' ), /* This is the Title of the Group */
						'singular_name'      => __( 'Timeline Event',                 'epoch-timeline' ), /* This is the individual type */
						'all_items'          => __( 'All Timeline Events',            'epoch-timeline' ), /* the all items menu item */
						'add_new'            => __( 'Add Timeline Event',             'epoch-timeline' ), /* The add new menu item */
						'add_new_item'       => __( 'Add New Timeline Event',         'epoch-timeline' ), /* Add New Display Title */
						'edit'               => __( 'Edit',                           'epoch-timeline' ), /* Edit Dialog */
						'edit_item'          => __( 'Edit Timeline Event',            'epoch-timeline' ), /* Edit Display Title */
						'new_item'           => __( 'New Timeline Event',             'epoch-timeline' ), /* New Display Title */
						'view_item'          => __( 'View Timeline Event',            'epoch-timeline' ), /* View Display Title */
						'search_items'       => __( 'Search Timeline Events',         'epoch-timeline' ), /* Search Custom Type Title */
						'not_found'          => __( 'Nothing found in the Database.', 'epoch-timeline' ), /* This displays if there are no entries yet */
						'not_found_in_trash' => __( 'Nothing found in Trash',         'epoch-timeline' ), /* This displays if there is nothing in the trash */
						'parent_item_colon'  => '',
					), /* end of arrays */
				'description'           => __( 'Timeline Event', 'epoch-timeline' ), /* Custom Type Description */
				'public'                => true,
				'publicly_queryable'    => true,
				'exclude_from_search'   => false,
				'show_ui'               => true,
				'query_var'             => true,
				'menu_position'         => 8, /* this is what order you want it to appear in on the left hand side menu */
				'menu_icon'             => 'dashicons-clock', /* the icon for the custom post type menu */
				'rewrite'	            => array(
						'slug'       => 'event',
						'with_front' => false,
					), /* you can specify its url slug */
				'has_archive'           => true, /* you can rename the slug here */
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

	/**
	 * Add meta box for timeline selector.
	 * Based on post found here:
	 * http://justintadlock.com/archives/2013/10/07/post-relationships-parent-to-child
	 *
	 * @return void
	 */
	function et_add_timeline_select_meta_box() {
		add_meta_box(
			'timeline_meta_box',
			'Timeline',
			array( $this, 'render_mb_timeline_select_contents' ),
			$this->timeline_post_type,
			'side',
			'core'
		);
	}

	/**
	 * Meta box callback to render the form for the timeline selector
	 * Based on post found here:
	 * http://justintadlock.com/archives/2013/10/07/post-relationships-parent-to-child
	 *
	 * @param  object $post Post object for currently edited Timeline event.
	 * @return void
	 */
	function render_mb_timeline_select_contents( $post ) {
		$parents = get_posts(
			array(
				'post_type'   => 'et_timelines',
				'orderby'     => 'title',
				'order'       => 'ASC',
				'numberposts' => -1,
			)
		);

		if ( ! empty( $parents ) ) {

			echo '<select name="parent_id" class="widefat">';

			foreach ( $parents as $parent ) {
				printf( '<option value="%s"%s>%s</option>', esc_attr( $parent->ID ), selected( $parent->ID, $post->post_parent, false ), esc_html( $parent->post_title ) );
			}

			echo '</select>';
		}
	} // end function render_mb_timeline_select_contents

} // end Class_Timeline_Events

Class_Timeline_Events::instance();
