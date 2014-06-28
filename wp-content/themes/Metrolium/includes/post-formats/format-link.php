<?php if(is_single()) : ?>

	<header>
		<?php
		$link_title = get_post_meta($post->ID, 'link_settings_title', true);
		$link_url = get_post_meta($post->ID, 'link_settings_url', true);
		$link_target = get_post_meta($post->ID, 'link_settings_target', true);
		if($link_title && $link_url)
		{
			echo '<h2><a href="'.$link_url.'" target="'.$link_target.'">'.$link_title.' <i class="icon-angle-right"></i></a></h2>';
			echo '<p class="url">'.$link_url.'</p>';
		}
		else
		{
			echo '<p class="notice warning">'. __( 'Missing either link title, link URL or both', 'euged' ) .'</p>';
		}
		?>
	</header>

<?php else : ?>

	<header>
		<?php
		$Euged = new Euged();
		$link_title = get_post_meta($post->ID, 'link_settings_title', true);
		$link_url = $Euged->parse_url(get_post_meta($post->ID, 'link_settings_url', true));
		$link_target = get_post_meta($post->ID, 'link_settings_target', true);
		if($link_title && $link_url)
		{
			echo '<h2><a href="'.$link_url.'" target="'.$link_target.'">'.$link_title.' <i class="icon-angle-right"></i></a></h2>';
			echo '<p class="url">'.$link_url.'</p>';
		}
		else
		{
			echo '<p class="notice warning">'. __( 'Missing either link title, link URL or both', 'euged' ) .'</p>';
		}
		?>
	</header>

	<div class="content">

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