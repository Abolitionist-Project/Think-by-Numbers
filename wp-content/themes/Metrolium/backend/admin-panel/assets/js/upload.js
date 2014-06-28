jQuery(document).ready(function($) {

	$('#upload_ad_image_button').on('click', function() {

		tb_show('Upload a banner', 'media-upload.php?referer=jrb-new-ad-image&type=image&TB_iframe=true&post_id=0', false);
		return false;
	});

	window.send_to_editor = function(html) {
		// html returns a link like this:
		// <a href="{server_uploaded_image_url}"><img src="{server_uploaded_image_url}" alt="" title="" width="" height"" class="alignzone size-full wp-image-125" /></a>
		var image_url = $('img', html).attr('src');
		// alert(html);
		$('#image_url').val(image_url);
		tb_remove();
		$('#ad_preview').attr('src',image_url);

		//$('#submit_options_form').trigger('click');
		// $('#uploaded_logo').val('uploaded');
	};

});