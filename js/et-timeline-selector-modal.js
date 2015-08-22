// Epoch Timelines
// JavaScript for admin pages that are NOT
//   New or Edit post for the Timeline post_type

jQuery( document ).ready( function(){
	// jQuery('#insert-timeline-button').on('click', function( event ) {
	// 	event.preventDefault();
	// 	console.log('toggle.');
	// 	jQuery('#et-timelines-modal').show();
	// });
	
	jQuery('#et-timelines-modal').dialog({
		autoOpen: true,
		height: 400,
		width: 640,
		modal: false,
		title: 'Select Product',
		open: function() {
			//$(this).scrollTop(0);
			//$('#apm_search_query').focus();
		},
		buttons: {
			Cancel: function() {
				jQuery(this).dialog('close');
			}
		},
		close: function() {
			jQuery(this).dialog('close');
		}

	});

	var openTimelineSelector = function( e ) {
		e.preventDefault();
		jQuery('#et-timelines-modal').dialog('open');
	}

	jQuery('#insert-timeline-button').on('click', openTimelineSelector );

});