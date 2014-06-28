<?php get_header() ?>

<?php the_post() ?>

<div id="content">
	<div class="band padded default">
		<div class="inner">

			<article <?php post_class('single') ?>>

				<h1><?php the_title(); ?></h1>

				<div class="attachment">

					<?php echo wp_get_attachment_image($post->ID,'full') ?>

					<?php if(!empty($post->post_excerpt)) : ?>
						<div class="typography">
							<?php the_excerpt() ?>
						</div>
					<?php endif ?>

				</div>

			</article>

		</div>
	</div>
</div>

<?php get_footer() ?>