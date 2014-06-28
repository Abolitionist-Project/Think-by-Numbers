<?php
global $global_admin_options;
$lightbox_enabled = $global_admin_options['portfolio_enable_lightbox'] ? $global_admin_options['portfolio_enable_lightbox'] : 'true';
?>
<div class="portfolio archive slat isotope-grid">

	<?php while (have_posts()) : the_post(); ?>

		<?php
		$terms = get_the_terms( $post->ID, 'portfolio_category' );
		if( !empty( $terms ) )
		{
			$filter_tags = '';
			foreach( $terms as $term )
			{
				$filter_tags .= ' filter-' . strtolower( str_replace( ' ', '-', $term->name ) );
			}
		}
		?>

		<div class="isotope-item<?php echo !empty($filter_tags) ? $filter_tags : '';?>">

			<article <?php post_class('archive slat detail') ?>>

				<div class="grid-row linearise">

					<div class="grid-item one-half">

						<?php $post_thumbnail = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) ); ?>

						<div class="image">
							<img src="<?php echo $post_thumbnail ?>">
							<div class="hover">
								<a class="action" href="<?php the_permalink() ?>"><i class="icon-chevron-right"></i></a>
								<?php if( $lightbox_enabled == 'true' ) : ?>
									<a class="action fancybox" href="<?php echo $post_thumbnail ?>"><i class="icon-search"></i></a>
								<?php endif ?>
							</div>
						</div>

					</div>

					<div class="grid-item one-half">

						<div class="typography">
							<h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
							<?php the_excerpt(); ?>
							<a href="<?php the_permalink() ?>" class="button"><?php _e('View project','euged') ?></a>
						</div>

					</div>

				</div>

			</article>

		</div>

	<?php endwhile; ?>

</div>