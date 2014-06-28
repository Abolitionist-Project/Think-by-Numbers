<div id="titlebar" class="band slider">
	<?php
	if( isset($post->ID) )
	{
		$shortcode = get_post_meta($post->ID, 'page_options_slider_shortcode', true );
	}

	if( is_tag() || is_category() || is_singular('post') || is_home() || is_author() || is_archive() || is_search() )
	{
		$shortcode = get_post_meta( get_option('page_for_posts'), 'page_options_slider_shortcode', true );
	}

	if( is_tax('portfolio_category') || is_post_type_archive('portfolio') )
	{
		global $global_admin_options;
		$shortcode = get_post_meta( $global_admin_options['portfolio_page_for_portfolio'], 'page_options_slider_shortcode', true );
	}

	echo do_shortcode( html_entity_decode( $shortcode ) ) ?>
</div>