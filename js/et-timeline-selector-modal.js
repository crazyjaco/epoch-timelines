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
		autoOpen: false,
		height: 400,
		width: 640,
		modal: false,
		title: 'Select Timeline',
		dialogClass: 'et-timeline-dialog',
		open: function() {
			jQuery(this).dialog('moveToTop');
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

	// Do what needs to be done to open dialog
	var openTimelineSelector = function( e ) {
		e.preventDefault();
		jQuery('#et-timelines-modal').dialog('open');
	}

	var selectTimeline = function( e ) {
		e.preventDefault();
		//var selected = '';
		//selected = tinyMCE.activeEditor.selection.getContent();
		var shortcode = '[timeline id=' + this.dataset.postId + ']';
		console.log( this.dataset.postId );
		tinymce.execCommand('mceInsertContent', false, shortcode );
		jQuery('#et-timelines-modal').dialog('close');
	}

	// Open dialog when clicking the Add Timeline button
	jQuery('#insert-timeline-button').on('click', openTimelineSelector );

	// When a timeline in the dialog is selected, do stuff
	jQuery("#et-timelines-results").on('click', 'li', selectTimeline );

});