<?php
$post_meta = get_post_meta(get_option('page_for_posts'));
$sidebar = !empty($post_meta['page_options_sidebar'][0]) ? $post_meta['page_options_sidebar'][0] : 'no-sidebar';
$sidebar_position = !empty($post_meta['page_options_sidebar_position'][0]) ? $post_meta['page_options_sidebar_position'][0] : 'left';
?>

<?php if ($sidebar != 'no-sidebar'): ?>
	<div class="grid-row linearise">
		<div class="grid-item seven-tenth <?php echo $sidebar_position == 'left' ? 'right' : 'left'; ?>">
<?php endif; ?>

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
<table>
<?php while (have_posts()) : the_post(); ?>
        <tr><td style="border:none;">
	<article <?php post_class('archive traditional') ?>>

		<?php euged_load_post_format_template(get_post_format()) ?>

	</article>
        </td></tr>
<?php endwhile; ?>
</table>
<?php if ( $wp_query->max_num_pages > 1 ) : ?>
	<nav class="pagination archive">
		<div class="prev"><?php next_posts_link( __( '<div class="icon icon-chevron-left"></div>', 'euged' ) ); ?></div>
		<div class="next"><?php previous_posts_link( __( '<div class="icon icon-chevron-right"></div>', 'euged' ) ); ?></div>
	</nav>
<?php endif; ?>

<?php if ($sidebar != 'no-sidebar'): ?>
		</div>
		<div id="sidebar" class="grid-item three-tenth <?php echo $sidebar_position; ?>">
			<?php dynamic_sidebar( $sidebar ); ?>
		</div>
	</div>
<?php endif; ?>