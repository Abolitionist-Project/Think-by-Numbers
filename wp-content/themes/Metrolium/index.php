<?php get_header() ?>

<?php get_template_part('includes/titlebar') ?>

<div id="content">
	<div class="band padded default">
		<div class="inner">

			<?php
			global $global_admin_options;
			$blog_template = !empty($global_admin_options['blog_archive_layout']) ? $global_admin_options['blog_archive_layout'] : 'traditional';
			if(isset($_GET[sanitize_key('template_override')])) $blog_template = $_GET[sanitize_key('template_override')];
			get_template_part('includes/blog/blog-' . $blog_template);
			?>

		</div>
	</div>
</div>

<?php get_footer() ?>