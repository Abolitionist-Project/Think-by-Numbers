;(function($) {

	$(document).ready(function() {

		// Post Format Meta Boxes
		var sortables = $('#normal-sortables'),
			audio_settings = $('#audio_settings'),
			link_settings = $('#link_settings'),
			quote_settings = $('#quote_settings'),
			video_settings = $('#video_settings');

		function show_metaboxes() {
			var post_format = $('#post-formats-select input:checked').val();

			// Remove post format specific meta boxes by default
			audio_settings.remove();
			link_settings.remove();
			quote_settings.remove();
			video_settings.remove();

			// Competitions Meta Box
			if (post_format === 'audio') {
				sortables.prepend(audio_settings);
			}
			else if (post_format === 'link') {
				sortables.prepend(link_settings);
			}
			else if (post_format === 'quote') {
				sortables.prepend(quote_settings);
			}
			else if (post_format === 'video') {
				sortables.prepend(video_settings);
			}
		}

		// Fire the function immediately
		show_metaboxes();

		$('#post-formats-select input').on('change', show_metaboxes);

	});

})(jQuery);