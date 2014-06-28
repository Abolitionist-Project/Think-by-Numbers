<?php get_header() ?>

<?php get_template_part('includes/titlebar') ?>

<?php the_post() ?>

<?php
$post_meta = get_post_meta(get_option('page_for_posts'));
$sidebar = !empty($post_meta['page_options_sidebar'][0]) ? $post_meta['page_options_sidebar'][0] : 'no-sidebar';
$sidebar_position = !empty($post_meta['page_options_sidebar_position'][0]) ? $post_meta['page_options_sidebar_position'][0] : 'left';
?>

<div id="content">
	<div class="band padded default">
		<div class="inner">

		<?php if ($sidebar != 'no-sidebar'): ?>
			<div class="grid-row linearise">
				<div class="grid-item seven-tenth <?php echo $sidebar_position == 'left' ? 'right' : 'left'; ?>">
		<?php endif; ?>

					<article <?php post_class('single') ?>>

						<?php euged_load_post_format_template(get_post_format()) ?>

						<?php if( !in_array( get_post_format(), array('link','quote') ) ) : ?>
							<?php the_title('<h2 class="h1">','</h2>') ?>
						<?php endif ?>

						<div class="meta datetime">
							<div class="icon"><i class="icon-calendar"></i></div>
							<p><time datetime="<?php the_time(get_option('date_format')) ?>" pubdate><?php
							printf(
								__( 'Posted on %s at %s', 'euged' ),
								get_the_time( get_option( 'date_format' ), $post->ID ),
								get_the_time( get_option( 'time_format' ), $post->ID )
							); ?></time></p>
						</div>

						<div class="typography">
							<?php the_content() ?>
						</div>

						<?php wp_link_pages(array('before' => '<nav class="pagination pages">'.__('Pages:'), 'after' => '</nav>')); ?>

						<?php
						global $global_admin_options;
						$blog_show_author = $global_admin_options['blog_show_author'] ? $global_admin_options['blog_show_author'] : 'true';
						$blog_show_category = $global_admin_options['blog_show_category'] ? $global_admin_options['blog_show_category'] : 'true';
						$blog_show_tags = $global_admin_options['blog_show_tags'] ? $global_admin_options['blog_show_tags'] : 'true';
						?>

						<?php if( $blog_show_author == 'true' || $blog_show_category == 'true' || $blog_show_tags == 'true' ) : ?>

							<div class="hr icon"><i class="icon-info-sign"></i></div>

						<?php endif ?>

						<?php if( $blog_show_author == 'true' ) : ?>

							<div class="meta author <?php echo get_option('show_avatars') ? 'avatar' : '' ?>">
								<?php echo get_avatar(get_the_author_meta('user_email'),160); ?>
								<?php the_author_meta('description'); ?>
								<a class="button square" href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>"><i class="icon-arrow-right"></i></a>
							</div>

						<?php endif ?>

						<?php if( $blog_show_category == 'true' ) : ?>

							<?php if(has_category()) : ?>
								<div class="meta category">
									<div class="icon"><i class="icon-folder-open"></i></div>
									<?php the_category(', ') ?>
								</div>
							<?php endif ?>

						<?php endif ?>

						<?php if( $blog_show_tags == 'true' ) : ?>

							<?php if(has_tag()) : ?>
								<div class="meta tags">
									<div class="icon"><i class="icon-tags"></i></div>
									<?php the_tags('','','') ?>
								</div>
							<?php endif ?>

						<?php endif ?>

					</article>

					<?php comments_template() ?>

		<?php if ($sidebar != 'no-sidebar'): ?>
				</div>
				<div id="sidebar" class="grid-item three-tenth <?php echo $sidebar_position; ?>">
					<?php dynamic_sidebar( $sidebar ); ?>
				</div>
			</div>
		<?php endif; ?>

		</div>
	</div>
</div>

<?php get_footer() ?>