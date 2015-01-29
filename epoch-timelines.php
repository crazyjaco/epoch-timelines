<?php

/*
Plugin Name: Epoch Timelines
Description: Create timelines of events and epochs in WordPress
Author: Crazy Jaco
Author URI: http://github.com/crazyjaco
*/


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Include core plugin class
require plugin_dir_path( __FILE__ ) . 'inc/class-timeline-timelines.php';
require plugin_dir_path( __FILE__ ) . 'inc/class-timeline-events.php';
