<?php get_header() ?>

<?php get_template_part('includes/titlebar') ?>

<?php the_post() ?>

<div id="content">
	<div class="band padded default">
		<div class="inner">

			<?php
			$template = get_post_meta($post->ID, 'portfolio_options_style', true);
			$template = !empty($template) ? $template : 'single-wide';
			get_template_part('includes/portfolio/' . $template);
			?>

		</div>
	</div>
</div>

<?php get_footer() ?>