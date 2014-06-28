<?php
function euged_metrolium_activate()
{
	function get_ID_by_slug($slug)
	{
		$page = get_page_by_path($slug);
		if($page)
		{
			return $page->ID;
		}
		return false;
	}

	/****************************************************
	* Create Pages
	****************************************************/
	// Welcome Page
	$welcome_page = array(
		'post_title'		=> 'Welcome',
		'post_content'		=> '<h1 style="margin-bottom:0">Welcome</h1><h2>to Metrolium</h2><p>Sed non lectus vel lacus rhoncus imperdiet ut feugiat augue. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis non neque quam. Praesent eget molestie sapien. Nulla tincidunt ligula a augue hendrerit pharetra. Nunc egestas, urna vitae elementum varius, lacus.</p>',
		'post_status'		=> 'publish',
		'post_author'		=> 1,
		'post_name'			=> 'welcome',
		'post_type'			=> 'page',
		'comment_status'	=> 'closed',
		'ping_status'		=> 'closed'
	);
	$welcome_page_id = get_ID_by_slug('welcome');
	if($welcome_page_id === false)
	{
		$welcome_page_id = wp_insert_post( $welcome_page );
	}

	// Blog Page
	$blog_page = array(
		'post_title'		=> 'Blog',
		'post_content'		=> '',
		'post_status'		=> 'publish',
		'post_author'		=> 1,
		'post_name'			=> 'blog',
		'post_type'			=> 'page'
	);
	$blog_page_id = get_ID_by_slug('blog');
	if($blog_page_id === false)
	{
		$blog_page_id = wp_insert_post( $blog_page );
	}

	// Portfolio Page
	$portfolio_page = array(
		'post_title'		=> 'Portfolio',
		'post_content'		=> '',
		'post_status'		=> 'publish',
		'post_author'		=> 1,
		'post_name'			=> 'portfolio',
		'post_type'			=> 'page'
	);
	$portfolio_page_id = get_ID_by_slug('portfolio');
	if($portfolio_page_id === false)
	{
		$portfolio_page_id = wp_insert_post( $portfolio_page );
	}

	/****************************************************
	* Assign Pages
	****************************************************/
	// Assign Welcome Page as page_on_front
	update_option( 'page_on_front', $welcome_page_id );

	// Assign Blog Page as page_for_posts
	update_option( 'page_for_posts', $blog_page_id );

	// Assign Portfolio Page as portfolio_page_for_portfolio
	$euga_options = json_decode( get_option('euga_options'), true );
	$euga_options['portfolio_page_for_portfolio'] = $portfolio_page_id;
	$euga_options = json_encode( stripslashes_deep( $euga_options ) );
	update_option('euga_options', $euga_options);

	// Show page on front instead of posts
	update_option( 'show_on_front', 'page' );

	update_option('euged_metrolium_activated', '1');
}