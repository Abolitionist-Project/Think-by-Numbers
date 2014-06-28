<?php if( is_author() ) : the_post(); ?>

	<?php if( get_the_author_meta( 'description' ) ) : ?>
	<div class="author-info detail box">

		<div class="author-avatar">
			<?php echo get_avatar( get_the_author_meta( 'user_email' ), 200 ); ?>
		</div>

		<div class="author-description">
			<h2><?php echo get_the_author(); ?></h2>
			<?php echo apply_filters( 'the_content', get_the_author_meta( 'description' ) ) ; ?>
		</div>

	</div>
	<?php endif; rewind_posts(); ?>

<?php endif ?>

<?php if( !have_posts() ) : ?>
	<p class="notice warning"><?php _e('No posts to display', 'euged') ?></p>
<?php endif ?>

<div class="post archive isotope-grid isotope" data-layoutmode="masonry">

	<?php while (have_posts()) : the_post(); ?>

		<div class="isotope-item">

			<article <?php post_class('masonry archive') ?>>

				<?php euged_load_post_format_template(get_post_format()) ?>

			</article>

		</div>

	<?php endwhile; ?>

</div>

<?php if ( $wp_query->max_num_pages > 1 ) : ?>
	<nav class="pagination archive">
		<div class="prev"><?php next_posts_link( __( '<div class="icon icon-chevron-left"></div>', 'euged' ) ); ?></div>
		<div class="next"><?php previous_posts_link( __( '<div class="icon icon-chevron-right"></div>', 'euged' ) ); ?></div>
	</nav>
<?php endif; ?>