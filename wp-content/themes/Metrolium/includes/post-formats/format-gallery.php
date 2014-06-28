<?php if(is_single()) : ?>

<?php else : ?>

	<header>
	<?php
	$images = euged_get_gallery_images_array();
	if(!empty($images)) :
	?>

		<div class="flexslider default">
			<div class="slides">
				<?php
				foreach($images as $image)
					{
					echo '<div class="slide">';
					echo wp_get_attachment_image($image, 'full');
					echo '</div>';
					}
				?>
			</div>
		</div>

	<?php else : ?>

		<p class="notice warning"><?php _e('No image attachements in this post found', 'euged') ?></p>

	<?php endif ?>

	</header>

	<div class="content">
		
		<h2><a href="<?php the_permalink(); ?>" title="Permalink to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
		
		<?php euged_post_mini_meta() ?>

		<div class="typography">
			<?php the_excerpt(); ?>
		</div>

		<p class="continue">
			<a href="<?php the_permalink() ?>" class="button xsmall"><?php _e( 'Read more', 'euged' ) ?></a>
			<?php if( comments_open() ) : ?>
				<a href="<?php the_permalink() ?>/#comments"><i class="icon-comment"></i> <?php comments_number(__('Leave a comment','euged'), __('One Comment','euged'), __('% Comments','euged') ) ?></a>
			<?php endif ?>
		</p>

	</div>

<?php endif ?>