jQuery( document ).ready( function() {
	console.log('dog');
	jQuery( '.et-event-list' ).sortable({
		items: '.et-event-item',
		axis: "y",
		containment: "parent",
		cursor: 'move',
		update: function() {
			var event_order = jQuery( this ).sortable( 'serialize' );
			var timeline    = jQuery( this ).attr('id');
			var qs          = event_order + '&tl=' + timeline + '&action=update_event_order';
			console.log( 'event order: ', event_order + '&tl=' + timeline + '&action=update_event_order' );	
			jQuery.post(ajaxurl, qs , function(response){
				console.log( response );
			});
		}
	});
	jQuery( '.et-event-list' ).disableSelection();
});