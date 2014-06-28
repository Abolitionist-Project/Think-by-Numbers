<?php get_header() ?>

<div id="content">
	<div class="band padded default">
		<div class="inner">

			<div class="narrow">
				<h1><?php _e('Error 404', 'euged'); ?></h1>
				<h3><?php _e('It appears this page cannot be found', 'euged'); ?></h3>
				<p><?php _e('Unfortunatly the page you are looking for has either moved location or been removed all together.', 'euged'); ?></p>
				<p><?php _e('You can try searching for it below using the form.', 'euged'); ?></p>

				<hr class="shadow" />

				<div class="widget widget_search">
					<?php get_search_form() ?>
				</div>
				<p class="textright"><a href="<?php echo home_url() ?>"><?php _e('Return home', 'euged'); ?></a></p>
			</div>

		</div>
	</div>
</div>

<?php get_footer() ?>