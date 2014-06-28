<?php
if( isset($post->ID) )
{
	$post_meta = get_post_meta($post->ID);
}

// Get titlebar settings from blog page
if( is_tag() || is_category() || is_singular('post') || is_home() || is_author() || is_archive() || is_search() )
{
	$post_meta = get_post_meta( get_option('page_for_posts') );
}

// Get titlebar settings from project archive
if( is_tax('portfolio_category') || is_post_type_archive('portfolio') )
{
	global $global_admin_options;
	$post_meta = get_post_meta( $global_admin_options['portfolio_page_for_portfolio'] );
}

$breadcrumbs = !empty($post_meta['page_options_show_breadcrumbs'][0]) ? $post_meta['page_options_show_breadcrumbs'][0] : 'on';
$breadcrumbs_position = !empty($post_meta['page_options_breadcrumbs_position'][0]) ? $post_meta['page_options_breadcrumbs_position'][0] : 'above';
$titlebar = !empty($post_meta['page_options_titlebar_style'][0]) ? $post_meta['page_options_titlebar_style'][0] : 'hidden';

if ($breadcrumbs == 'on' && $breadcrumbs_position == 'above')
{
	euged_breadcrumbs();
}

if ($titlebar != 'hidden')
{
	get_template_part('includes/titlebars/' . $titlebar);
}

if ($breadcrumbs == 'on' && $breadcrumbs_position == 'below')
{
	euged_breadcrumbs();
}
?>