<?php
// TODO: Turn this call into an ajax request to lazy load timelines
$timelines = Class_Timeline_Timelines::get_timeline_listing();
$odd_count = '';
?>
<div id="et-timelines-modal">
	<div id="inner wrap">
		<ul id="et-timelines-results">
			<?php
			foreach ($timelines as $key => $value ) {
				// error_log( 'Key: ' . print_r( $key, true ) );
				// error_log( 'Value: ' . print_r( $value, true ) );
				$odd = $odd_count % 2 ? 'odd' : '';
				echo '<li class="' . $odd . '"data-post-id=' . esc_html( $key ) . '>' . esc_html( $value ) . '</li>';
				$odd_count += 1;
			}
			?>
		</ul>
	</div>
</div>