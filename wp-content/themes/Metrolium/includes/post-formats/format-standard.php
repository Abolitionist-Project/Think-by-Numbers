<?php if(is_single()) : ?>

	<?php if(has_post_thumbnail()) : ?>
		<header>
			<?php the_post_thumbnail('blogImageSize') ?>
		</header>
	<?php endif ?>

<?php else : ?>

	<?php if(has_post_thumbnail()) : ?>
		<header style="float:left; margin-right: 20px;">
			<a href="<?php the_permalink(); ?>" title="Permalink to <?php the_title(); ?>"><?php the_post_thumbnail('blogImageSize') ?></a>
		</header>
	<?php endif ?>

	<div class="content">
		
		<h2><a href="<?php the_permalink(); ?>" title="Permalink to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
		
		<?php //euged_post_mini_meta() ?>

		<div class="typography">
			<?php the_excerpt(); ?>
		</div>

		<p class="continue" style="display:none;">
			<a href="<?php the_permalink() ?>" class="button xsmall"><?php _e( 'Read more', 'euged' ) ?></a>
			<?php if( comments_open() ) : ?>
				<a href="<?php the_permalink() ?>/#comments"><i class="icon-comment"></i> <?php comments_number(__('Leave a comment','euged'), __('One Comment','euged'), __('% Comments','euged') ) ?></a>
			<?php endif ?>
		</p>

	</div>

<?php endif ?>