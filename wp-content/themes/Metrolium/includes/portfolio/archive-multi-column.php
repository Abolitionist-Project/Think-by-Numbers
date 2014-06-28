<?php
global $global_admin_options;
$template = $global_admin_options['portfolio_number_of_columns'];
$layout_mode = $global_admin_options['portfolio_archive_layout'] ? $global_admin_options['portfolio_archive_layout'] : 'fitRows';
$lightbox_enabled = $global_admin_options['portfolio_enable_lightbox'] ? $global_admin_options['portfolio_enable_lightbox'] : 'true';
if(isset($_GET[sanitize_key('layout_mode')])) $layout_mode = $_GET[sanitize_key('layout_mode')];
if(isset($_GET[sanitize_key('column_override')])) $template = $_GET[sanitize_key('column_override')];
?>
<div class="portfolio archive grid isotope-grid portfolio-<?php echo $template; ?>" data-layoutmode="<?php echo $layout_mode ?>">

	<?php while (have_posts()) : the_post(); ?>

		<?php
		$terms = get_the_terms( $post->ID, 'portfolio_category' );
		if( !empty( $terms ) )
		{
			$filter_tags = '';
			foreach( $terms as $term )
			{
				$filter_tags .= ' filter-' . strtolower( str_replace( ' ', '-', $term->slug ) );
			}
		}
		?>

		<div class="isotope-item<?php echo !empty($filter_tags) ? $filter_tags : '';?>">

			<article <?php post_class('archive grid'); ?>>

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

				<div class="meta">
					<h3 class="title"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h3>
					<p class="datetime"><?php the_time(get_option('date_format')) ?></p>
				</div>

			</article>

		</div>

	<?php endwhile; ?>

</div>