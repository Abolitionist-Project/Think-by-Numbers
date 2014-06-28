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

$titlebar_cta = 'off';
if (!empty($post_meta['page_options_show_titlebar_cta'][0])) {
	$titlebar_cta = $post_meta['page_options_show_titlebar_cta'][0];
}

if (!empty($post_meta['page_options_titlebar_cta_link'][0])) {
	$titlebar_cta_link = $post_meta['page_options_titlebar_cta_link'][0];
}

if (!empty($post_meta['page_options_titlebar_cta_text'][0])) {
	$titlebar_cta_text = $post_meta['page_options_titlebar_cta_text'][0];
}

$titlebar_textalign = 'left';
if (!empty($post_meta['page_options_titlebar_textalign'][0])) {
	$titlebar_textalign = $post_meta['page_options_titlebar_textalign'][0];
}

$show_subtitle = 'false';
if (!empty($post_meta['page_options_show_subtitle'][0])) {
	$show_subtitle = $post_meta['page_options_show_subtitle'][0];
}
?>

<div id="titlebar" class="band v1">
	<div class="inner<?php echo ($titlebar_textalign == 'center') ? ' textcenter' : '';?>">

		<?php
		printf(
			'%s%s%s%s',
			$titlebar_textalign == 'left' ? '<div class="content">' : '',
			euged_the_title('<h1 class="main-heading">','</h1>'),
			$show_subtitle == 'on' ? euged_the_sub_title('<h2 class="sub-heading">','</h2>') : '',
			$titlebar_textalign == 'left' ? '</div>' : ''
		);
		?>

		<?php
		if ( $titlebar_textalign == 'left' && $titlebar_cta == 'on' && !empty($titlebar_cta_link) && !empty($titlebar_cta_text) )
		{
			global $Euged;
			printf(
				'<div class="cta"><a href="%s" class="button large">%s</a></div>',
				$Euged->parse_url($titlebar_cta_link),
				$titlebar_cta_text
			);
		}
		?>

	</div>
</div>
