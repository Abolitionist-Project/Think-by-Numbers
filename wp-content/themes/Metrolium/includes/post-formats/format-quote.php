<?php if(is_single()) : ?>

	<header>
		<?php
		$quote_content = get_post_meta($post->ID, 'quote_settings_content', true);
		$quote_author = get_post_meta($post->ID, 'quote_settings_author', true);
		if($quote_content) :
		?>
			<figure class="blockquote">
				<blockquote>
					<?php echo apply_filters('the_content', $quote_content) ?>
				</blockquote>
				<?php if($quote_author) : ?>
					<figcaption>
						<p class="author"><?php echo $quote_author ?></p>
					</figcaption>
				<?php endif ?>
			</figure>

		<?php else : ?>

			<p class="notice warning"><?php _e( 'Missing either quote content, quote author or both', 'euged' ) ?></p>

		<?php endif ?>
	</header>

<?php else : ?>

	<header>
		<?php
		$quote_content = get_post_meta($post->ID, 'quote_settings_content', true);
		$quote_author = get_post_meta($post->ID, 'quote_settings_author', true);
		if($quote_content) :
		?>
			<figure class="blockquote">
				<blockquote>
					<?php echo apply_filters('the_content', $quote_content) ?>
				</blockquote>
				<?php if($quote_author) : ?>
					<figcaption>
						<p class="author"><?php echo $quote_author ?></p>
					</figcaption>
				<?php endif ?>
			</figure>

		<?php else : ?>

			<p class="notice warning"><?php _e( 'Missing either quote content, quote author or both', 'euged' ) ?></p>

		<?php endif ?>
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