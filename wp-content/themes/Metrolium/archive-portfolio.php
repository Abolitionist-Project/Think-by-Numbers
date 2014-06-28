<?php get_header() ?>

<?php get_template_part('includes/titlebar') ?>

<?php the_post() ?>

<div id="content">
	<div class="band padded default">
		<div class="inner">

			<?php get_template_part('includes/portfolio-filter'); ?>

			<?php $wp_query = new WP_Query( array( 'post_type' => 'portfolio', 'posts_per_page' => -1 ) ); ?>

			<?php if (!have_posts()) : ?>
				<p class="notice warning"><?php _e('No projects to display', 'euged') ?></p>
			<?php endif ?>

			<?php
			global $global_admin_options;
			$template = $global_admin_options['portfolio_number_of_columns'];
			if(isset($_GET[sanitize_key('column_override')])) $template = $_GET[sanitize_key('column_override')];
			switch($template)
			{
				case '1c'	: $filename = 'archive-1c'; break;
				default		: $filename = 'archive-multi-column';
			}

			get_template_part('includes/portfolio/' . $filename);
			?>

		</div>
	</div>
</div>

<?php get_footer() ?>