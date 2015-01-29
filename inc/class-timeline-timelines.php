<?php

class Class_Timeline_Timelines {
	private static $instance = false;

	public static function instance(){
		if ( ! self::$instance ) {
			self::$instance = new Class_Timeline_Timelines;
		}
		return self::$instance;
	}

	function __construct() {
		add_action( 'init', array( $this, 'create_cpt_et_timelines' ) );
	}

	/**
	 * Create the 'Timeline' custom post type
	 * @return [type] [description]
	 */
	function create_cpt_et_timelines() {
		// creating (registering) the custom type
		register_post_type( 'et_timelines', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
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
				'hierarchical'          => true,
				/* the next one is important, it tells what's enabled in the post editor */
				'supports' => array(
						'title',
						'editor',
						'excerpt',
						'custom-fields',
						'sticky',
					)
			) /* end of options */
		); /* end of register post type */

	} // end function create_cpt_et_events

} // end Class_Timeline_Timelines
Class_Timeline_Timelines::instance();