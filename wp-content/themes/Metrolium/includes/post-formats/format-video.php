<?php if(is_single()) : ?>

	<header>
		<div class="fitvid">
			<?php
			$embed_code = get_post_meta($post->ID, 'video_settings_embed_code', true);
			if($embed_code)
			{
				echo $embed_code;
			}
			else
			{
				echo '<p class="notice warning">'. __( 'No video embed code detected', 'euged' ) .'</p>';
			}
			?>
		</div>
	</header>

<?php else : ?>

	<header>
		<div class="fitvid">
			<?php
			$embed_code = get_post_meta($post->ID, 'video_settings_embed_code', true);
			if($embed_code)
			{
				echo $embed_code;
			}
			else
			{
				echo '<p class="notice warning">'. __( 'No video embed code detected', 'euged' ) .'</p>';
			}
			?>
		</div>
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