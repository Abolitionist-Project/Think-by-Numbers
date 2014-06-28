<?php
global $global_admin_options;
if( !empty( $global_admin_options['portfolio_page_for_portfolio'] ) && is_page( $global_admin_options['portfolio_page_for_portfolio'] ) )
{
	get_template_part( 'archive','portfolio' );
	die;
}
?>

<?php get_header() ?>

<?php get_template_part('includes/titlebar') ?>

<?php the_post() ?>

<?php
$post_meta = get_post_meta($post->ID);
$sidebar = !empty($post_meta['page_options_sidebar'][0]) ? $post_meta['page_options_sidebar'][0] : 'no-sidebar';
$sidebar_position = !empty($post_meta['page_options_sidebar_position'][0]) ? $post_meta['page_options_sidebar_position'][0] : 'left';
?>

<div id="content">
	<div class="band default">
		<div class="inner">

			<?php if ($sidebar != 'no-sidebar'): ?>
				<div class="grid-row linearise">
					<div class="grid-item seven-tenth <?php echo $sidebar_position == 'left' ? 'right' : 'left'; ?>">
			<?php endif; ?>

						<div class="typography">
							<?php the_content() ?>
						</div>

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