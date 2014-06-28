<?php
/****************************************************
* Accordion
****************************************************/

if (!function_exists('euged_shortcode_accordions'))
{
	function euged_shortcode_accordions($atts, $content = null)
	{
		extract(
			shortcode_atts(
				array(
					'active_panel' => false
				),
				$atts
			)
		);

		$content = str_replace("]<br />", "]", (substr($content,0,6) == "<br />" ? substr($content,6) : $content));

		$active_panel = (int) $active_panel;

		if( $active_panel > 0 )
		{
			$data = sprintf( 'data-active-panel="%s"', $active_panel );
		}
		else
		{
			$date = '';
		}

		return '<div id="random-accordion-id-' . rand(1000,9999) . '" class="accordions" '.$data.'>' . do_shortcode($content) . '</div>';
	}
}

// Accordion
if (!function_exists('euged_shortcode_accordion'))
{
	function euged_shortcode_accordion($atts, $content = null)
	{
		extract(shortcode_atts(array('title' => ''),$atts));
		if ($title) {
			return '<div class="header detail"><a href="#" id=""><i class="icon-plus"></i> ' . $title . '</a></div><div class="content detail"><div class="typography">' . do_shortcode($content) . '</div></div>';
		} else {
			return '<p class="notice warning">Missing title attribute, proper usage is: [accordion title="title name"]accordion content[/accordion]</p>';
		}
	}
}


/****************************************************
* Band
****************************************************/

if (!function_exists('euged_shortcode_band'))
{
	function euged_shortcode_band($atts, $content = null)
	{
		extract(
			shortcode_atts(
				array(
					'variation' => 'default',
					'inset' => 'no',
					'backgroundimage' => '',
					'bordertop' => '',
					'borderbottom' => '',
					'paddingtop' => '',
					'paddingbottom' => ''
				),
				$atts
			)
		);

		if (!in_array($inset, array('yes', 'no')))
		{
			$inset = 'no';
		}

		// Classes
		$classes = array();

		if (in_array($variation, array('default', 'alternative')))
		{
			$classes[] = $variation;
		}

		if ($inset == 'yes')
		{
			$classes[] = 'inset';
		}

		if (!empty($classes))
		{
			$classes = implode($classes, ' ');
		}
		else
		{
			$classes = '';
		}

		// Overrides
		$overrides = array();

		if ($backgroundimage != '')
		{
			$overrides[] = 'background-image:url('.$backgroundimage.')';
		}

		if ($bordertop != '')
		{
			$overrides[] = 'border-top:'.$bordertop;
		}

		if ($borderbottom != '')
		{
			$overrides[] = 'border-bottom:'.$borderbottom;
		}

		if ($paddingtop != '')
		{
			$overrides[] = 'padding-top:'.$paddingtop;
		}

		if ($paddingbottom != '')
		{
			$overrides[] = 'padding-bottom:'.$paddingbottom;
		}

		if (!empty($overrides))
		{
			$overrides = 'style="'.implode($overrides, ';').'"';
		}
		else
		{
			$overrides = '';
		}

		return '</div></div></div><div class="band padded '.$classes.'" '.$overrides.'><div class="inner"><div class="typography">';
	}
	add_shortcode('band','euged_shortcode_band');
}


/****************************************************
* Blockquote
****************************************************/

if (!function_exists('euged_shortcode_blockquote'))
{
	function euged_shortcode_blockquote($atts, $content = null)
	{
		extract(
			shortcode_atts(
				array(
					'type' => 'blockquote',
					'author' => '',
					'role' => '',
					'image' => ''
				),
				$atts
			)
		);

		if (!in_array($type, array('blockquote','testimonial')))
		{
			$type = 'blockquote';
		}

		$out = '<figure class="'.$type.' clearfix">';

		switch($type)
			{
			case 'blockquote' :
				$out .= '<blockquote>'.do_shortcode($content).'</blockquote>';
				if (!empty($author))
					{
					$out .= '<figcaption>';
					$out .= '<p class="author">'.$author.'</p>';
					$out .= '</figcaption>';
					}
			break;
			case 'testimonial' :
				$out .= '<blockquote>'.do_shortcode($content).'</blockquote>';
				if (!empty($author))
					{
					if ($image != '') $has_image = 'class="has-image"';
					$out .= '<figcaption '.$has_image.'>';
					if ($image != '') $out .= '<img src="'.$image.'" class="avatar" />';
					$out .= '<p class="author">'.$author.'</p>';
					if ($role != '') $out .= '<p class="role">'.$role.'</p>';
					$out .= '</figcaption>';
					}
			break;
			}
		$out .= '</figure>';
		return $out;
	}
}


/****************************************************
* Blog
****************************************************/

if (!function_exists('euged_shortcode_blog'))
{
	function euged_shortcode_blog($atts, $content = null)
	{
		extract(
			shortcode_atts(
				array(
					'columns' => '4',
					'load' => '4',
					'orderby' => 'date',
					'order' => 'desc',
					'category' => '',
					'post_format' => '',
					'id' => '',
					'showimage' => 'yes',
					'showtitle' => 'yes',
					'showdate' => 'yes',
					'showexcerpt' => 'yes',
					'excerpt_length' => '20',
					'boxed' => 'yes',
					'showbiz' => 'no',
					'sb_entry_size_offset' => '',
					'sb_container_offset_right' => '',
					'sb_height_offset_bottom' => '',
					'sb_carousel' => '',
					'sb_visible_elements_array' => '',
					'sb_drag_and_scroll' => '',
					'sb_navigation_align' => ''
				),
				$atts
			)
		);

		// Validation
		if (!in_array($columns, array('2','3','4','5'))) {
			$columns = '4';
		}

		if (!is_numeric($load)) {
			$load = '4';
		}

		if (!in_array($orderby, array('title','date','rand','random','menu_order','ID','author','none','modified','comment_count'))) {
			$orderby = 'date';
		}

		if ($orderby == 'random') {
			$orderby = 'rand';
		}

		if (!in_array($order, array('asc','desc'))) {
			$order = 'desc';
		}

		$tax_query = array();

		// Category
		if (!empty($category))
		{
			$categories = explode(',',$category);

			foreach($categories as $key => $value) {
				$categories[$key] = trim($value);
			}

			$tax_query[] = array(
				'taxonomy' => 'category',
				'field' => 'slug',
				'terms' => $categories
			);
		}

		// Post Format
		if (!empty($post_format))
		{
			$post_formats = explode(',',$post_format);

			foreach($post_formats as $key => $value) {
				$post_formats[$key] = 'post-format-'.trim($value);
			}

			$tax_query[] = array(
				'taxonomy' => 'post_format',
				'field' => 'slug',
				'terms' => $post_formats
			);
		}

		// ID's
		if (!empty($id)) {
			$ids = explode(',',$id);

			foreach($ids as $key => $value) {
				$ids[$key] = trim($value);
			}

			$post__in = $ids;
		} else {
			$post__in = array();
		}

		if (!in_array($showimage, array('yes','no'))) {
			$showimage = 'no';
		}

		if (!in_array($showtitle, array('yes','no'))) {
			$showtitle = 'yes';
		}

		if (!in_array($showdate, array('yes','no'))) {
			$showdate = 'yes';
		}

		if (!in_array($showexcerpt, array('yes','no'))) {
			$showexcerpt = 'yes';
		}

		if (!is_numeric($excerpt_length)) {
			$excerpt_length = '20';
		}

		if (!in_array($boxed, array('yes','no'))) {
			$boxed = 'yes';
		}

		if ($boxed == 'yes') {
			$class = 'boxed detail';
		} else {
			$class = 'unboxed';
		}

		// Showbiz
		if (!in_array($showbiz, array('yes','no'))) {
			$showbiz = 'no';
		}

		if (!in_array($sb_navigation_align, array('right','left','center'))) {
			$sb_navigation_align = 'right';
		}

		$showbiz_atts = array(
			'sb_entry_size_offset',
			'sb_container_offset_right',
			'sb_height_offset_bottom',
			'sb_carousel',
			'sb_visible_elements_array',
			'sb_drag_and_scroll'
		);

		$data_atts = array();

		foreach( $showbiz_atts as $showbiz_att )
		{
			if( !empty( $$showbiz_att ) )
			{
				$data_atts[] = sprintf( 'data-'.$showbiz_att.'="%s"', $$showbiz_att );
			}
		}

		$data_atts = implode( ' ', $data_atts );

		// Classes
		switch($columns)
		{
			case '2' :
				$grid		= 'one-half';
				$column		= 'two';
				break;
			case '3' :
				$grid		= 'one-third';
				$column		= 'three';
				break;
			case '4' :
				$grid		= 'one-quarter';
				$column		= 'four';
				break;
			case '5' :
				$grid		= 'one-fifth';
				$column		= 'five';
				break;
		}

		// Setup
		global $post;
		$r = $t = 0;

		$args = array(
			'post_type' => 'post',
			'order' => $order,
			'numberposts' => $load,
			'orderby' => $orderby,
			'exclude' => $post->ID,
			'tax_query' => $tax_query,
			'post__in' => $post__in
		);

		$blogposts = get_posts($args);

		if ($blogposts)
		{
			$output = '<div class="shortcode post archive grid '.$column.'-column">';

			// Output
			foreach($blogposts as $blogpost)
			{
				$r++; // count per row
				$t++; // total count

				if ($r == 1)
				{
					if( $showbiz == 'yes' )
					{
						$data_left = uniqid();
						$data_right = uniqid();
						$output .= '<div class="showbiz-enabled" '.$data_atts.'>';
						$output .= '<div class="showbiz-navigation text'.$sb_navigation_align.'">';
						$output .= '<a id="'.$data_left.'" class="icon-chevron-left"></a>';
						$output .= '<a id="'.$data_right.'" class="icon-chevron-right"></a>';
						$output .= '</div>';
						$output .= '<div class="showbiz" data-left="#'.$data_left.'" data-right="#'.$data_right.'">';
						$output .= '<div class="overflowholder">';
						$output .= '<ul>';
					}
					else
					{
						$output .= '<div class="grid-row linearise">';
					}
				}

				// Output
				if( $showbiz == 'yes' )
				{
					$output .= '<li><article class="'.$class.'">';
				}
				else
				{
					$output .= '<div class="grid-item '.$grid.'"><article class="'.$class.'">';
				}

				// Image
				if ($showimage == 'yes')
				{
					$image = wp_get_attachment_image_src( get_post_thumbnail_id( $blogpost->ID ), 'widescreen' );
					if ($image) {
						$url = $image[0];
						$image_style = 'style="background-image:url(\''.$url.'\');"';
						$image_class = 'has-image';
					} else {
						$image_style = $image_class = '';
					}

					$output .= '<div class="image">';
					$output .= '<a href="'.get_permalink($blogpost->ID).'">';
					$output .= '<div class="canvas '.$image_class.'" '.$image_style.'></div>';
					$output .= '</a>';
					$output .= '</div>';

					unset($image_style, $image_class);
				}

				if ($showtitle == 'yes' || $showdate == 'yes' || $showexcerpt == 'yes')
				{
					$output .= '<div class="content">';

					// Title
					if ($showtitle == 'yes')
					{
						$output .= '<h4 class="title"><a href="'.get_permalink($blogpost->ID).'">'.$blogpost->post_title.'</a></h4>';
					}

					// Date
					if ($showdate == 'yes')
					{
						$output .= '<p class="datetime">'.get_the_time(get_option('date_format'), $blogpost->ID).'</p>';
					}

					// Excerpt
					if ($showexcerpt == 'yes')
					{
						if ( !empty($blogpost->post_excerpt) )
						{
							$excerpt_content = $blogpost->post_excerpt;
						}
						else
						{
							$excerpt_content = $blogpost->post_content;
						}

						$output .= euged_trim_content($excerpt_content, $excerpt_length);
					}

					$output .= '</div>';
				}

				if( $showbiz == 'yes' )
				{
					$output .= '</article></li>';
				}
				else
				{
					$output .= '</article>';
					$output .= '</div>';
				}

				if ( $showbiz == 'yes' && $t == count($blogposts) )
				{
					$output .= '</ul></div></div></div>';
				}
				elseif ( $showbiz == 'no' && ( $r == $columns || $t == count($blogposts) ) )
				{
					$output .= '</div>';
					$r = 0;
				}
			}

			$output .= '</div>';
		}
		else
		{
			$output = '<p class="notice warning">'.__('No posts to display', 'euged').'</p>';
		}

		return $output;
	}
	add_shortcode('blog','euged_shortcode_blog');
}


/****************************************************
* Box
****************************************************/

if (!function_exists('euged_shortcode_box'))
{
	function euged_shortcode_box($atts, $content = null)
	{
		extract(
			shortcode_atts(
				array(
					'borderradius' => '',
					'padding' => ''
				),
				$atts
			)
		);

		$overrides = array();

		if (is_numeric(substr($borderradius,0,1))) {
			$overrides[] = 'border-radius:'.$borderradius;
		}

		if (!empty($padding)) {
			$overrides[] = 'padding:'.$padding;
		}

		if (!empty($overrides)) {
			$overrides = 'style="'.implode($overrides,';').'"';
		} else {
			$overrides = '';
		}

		return '<div class="box detail clearfix" '.$overrides.'>'.do_shortcode($content).'</div>';
	}
}


/****************************************************
* Break
****************************************************/

if (!function_exists('euged_shortcode_br'))
{
	function euged_shortcode_br()
	{
		return '<br />';
	}
}


/****************************************************
* Buttons
****************************************************/

if (!function_exists('euged_shortcode_button'))
{
	function euged_shortcode_button($atts, $content = null)
	{
		extract(
			shortcode_atts(
				array(
					'link' => '#',
					'size' => '',
					'color' => '',
					'target' => '_self'
				),
				$atts
			)
		);

		if (is_numeric($link)) {
			$link = get_permalink($link);
		}

		// Options
		$classes = array();

		if (in_array($size, array('xsmall', 'small', 'large'))) {
			$classes[] = $size;
		}

		if ($color == 'grey') {
			$color == 'gray';
		}

		if (in_array($color, array('gray','black','red','orange','yellow','green','blue','pink','purple'))) {
			$classes[] = $color;
		}

		if (!empty($classes)) {
			$classes = implode($classes, ' ');
		} else {
			$classes = '';
		}

		return '<a href="' . $link . '" target="' . $target . '" class="button ' . $classes . '">' . $content . '</a>';
	}
}


/****************************************************
* Callout
****************************************************/

if (!function_exists('euged_shortcode_callout'))
{
	function euged_shortcode_callout($atts, $content = null)
	{
		extract(
			shortcode_atts(
				array(
					'title' => '',
					'icon' => '',
					'boxed' => 'yes',
					'buttontext' => '',
					'buttonsize' => 'large',
					'buttonlink' => '#',
					'buttontarget' => '_self'
				),
				$atts
			)
		);

		if (!in_array($buttonsize, array('xsmall', 'small', 'large')))
		{
			$buttonsize = '';
		}

		if (!empty($icon))
		{
			$hasicon = 'has-icon';
		}
		else
		{
			$hasicon = 'no-icon';
		}

		if (!in_array($boxed, array('yes','no')))
		{
			$boxed = 'yes';
		}

		if ($boxed == 'yes')
		{
			$class = 'boxed detail';
		}
		else
		{
			$class = 'unboxed';
		}

		if (is_numeric($buttonlink))
		{
			$buttonlink = get_permalink($buttonlink);
		}

		$output = '<div class="callout '.$class.' clearfix">';
		$output .= '<div class="content '.$hasicon.'">';
		if (!empty($icon)) $output .= '<div class="callout-icon icon-'.$icon.'"></div>';
		$output .= '<h2>'.$title.'</h2>';
		$output .= '<p>'.$content.'</p>';
		$output .= '</div>';
		$output .= '<div class="action">';
		$output .= '<a class="button '.$buttonsize.'" href="'.$buttonlink.'" target="'.$buttontarget.'">'.$buttontext.'</a>';
		$output .= '</div>';
		$output .= '</div>';

		return $output;
	}
}


/****************************************************
* Clear
****************************************************/

if (!function_exists('euged_shortcode_clear'))
{
	function euged_shortcode_clear()
	{
		return '<div class="clear"></div>';
	}
}


/****************************************************
* Gap
****************************************************/

if (!function_exists('euged_shortcode_gap'))
{
	function euged_shortcode_gap($atts, $content = null)
	{
		extract(
			shortcode_atts(
				array(
					'height' => '10'
				),
				$atts
			)
		);

		return '<div class="gap" style="height:'.$height.'px;"></div>';
	}
}


/****************************************************
* Grid Row
****************************************************/

if (!function_exists('euged_shortcode_grid_row'))
{
	function euged_shortcode_grid_row($atts, $content = null)
	{
		extract(
			shortcode_atts(
				array(
					'linearise' => 'yes'
				),
				$atts
			)
		);

		$content = str_replace("]<br />","]",(substr($content,0,6) == "<br />" ? substr($content,6) : $content));

		if (!in_array($linearise, array('yes','no')))
		{
			$linearise = 'yes';
		}

		$options = array();

		if ($linearise == 'yes')
		{
			$options[] = 'linearise';
		}

		return '<div class="grid-row '.implode($options,' ').'">'.do_shortcode($content).'</div>';
	}
}

/****************************************************
* Grid Item
****************************************************/

if (!function_exists('euged_shortcode_grid_item'))
{
	function euged_shortcode_grid_item($atts, $content = null)
	{
		extract(
			shortcode_atts(
				array(
					'width' => 'one-half',
					'offset' => ''
				),
				$atts
			)
		);

		if (!empty($offset)) {
			$offset = 'offset-'.$offset;
		}

		return '<div class="grid-item '.$width.' '.$offset.'">'.do_shortcode($content).'</div>';
	}
}


/****************************************************
* Horizontal Rule
****************************************************/

if (!function_exists('euged_shortcode_hr'))
{
	function euged_shortcode_hr($atts, $content = null)
	{
		extract(
			shortcode_atts(
				array(
					'style' => 'line',
					'icon' => 'star'
				),
				$atts
			)
		);

		if (!in_array($style, array('line','shadow','icon'))) {
			$style = 'line';
		}

		switch($style) {
			case 'line':
			case 'shadow':
				return '<hr class="'.$style.'" />';
				break;
			case 'icon':
				return '<div class="hr '.$style.'"><i class="icon-'.$icon.'"></i></div>';
				break;
		}
	}
}


/****************************************************
* Icon List
****************************************************/

if (!function_exists('euged_shortcode_icon_list'))
{
	function euged_shortcode_icon_list($atts, $content = null)
	{
		return '<ul class="iconlist">' . do_shortcode($content) . '</ul>';
	}
}

// List Item
function euged_shortcode_icon_list_item($atts, $content = null)
{
	extract(
		shortcode_atts(
			array(
				'icon' => 'ok'
			),
			$atts
		)
	);

	return '<li><i class="icon-'.$icon.'"></i> '.do_shortcode($content).'</li>';
}


/****************************************************
* Lead
****************************************************/

if (!function_exists('euged_shortcode_lead'))
{
	function euged_shortcode_lead($atts, $content = null)
	{
		return '<p class="lead">'.do_shortcode($content).'</p>';
	}
}


/****************************************************
* Notices
****************************************************/

if (!function_exists('euged_shortcode_notice'))
{
	function euged_shortcode_notice($atts, $content = null)
	{
		extract(
			shortcode_atts(
				array(
					'type' => 'default'
				),
				$atts
			)
		);

		if (!in_array($type, array('error','success','warning'))) {
			$type = 'default';
		}

		return '<p class="notice '.$type.'">'.$content.'</p>';
	}
	add_shortcode('notice','euged_shortcode_notice');
}


/****************************************************
* Person
****************************************************/

if (!function_exists('euged_shortcode_person'))
{
	function euged_shortcode_person($atts, $content = null)
	{
		extract(
			shortcode_atts(
				array(
					'link' => '',
					'boxed' => 'yes',
					'image' => '',
					'name' => '',
					'role' => '',
					'email' => '',
					'twitter' => '',
					'facebook' => '',
					'linkedin' => '',
					'googleplus' => ''
				),
				$atts
			)
		);

		// Link
		if (!empty($link)) {
			$profile_link_open = '<a href="'.$link.'">';
			$profile_link_close = '</a>';
		} else {
			$profile_link_open = $profile_link_close = '';
		}

		// Image
		if (!empty($image)) {
			$profile_image = '<div class="image">'.$profile_link_open.'<img src="'.$image.'" />'.$profile_link_close.'</div>';
		} else {
			$profile_image = '';
		}

		// Boxed
		if (!in_array($boxed, array('yes','no'))) {
			$boxed = 'yes';
		}

		if ($boxed == 'yes') {
			$class = 'boxed detail';
		} else {
			$class = 'unboxed';
		}

		// Contact
		if ($email != '' || $twitter != '' || $facebook != '' || $linkedin != '' || $googleplus != '' )
		{
			$contact = '<footer><ul>';
			if ($email != '') $contact .= '<li><a href="mailto:'.$email.'" class="social-icon" title="Email" target="_blank"><i class="icon-envelope"></i></a></li>';
			if ($twitter != '') $contact .= '<li><a href="'.$twitter.'" class="social-icon twitter" title="Twitter" target="_blank"><i class="icon-twitter"></i></a></li>';
			if ($facebook != '') $contact .= '<li><a href="'.$facebook.'" class="social-icon facebook" title="Facebook" target="_blank"><i class="icon-facebook"></i></a></li>';
			if ($linkedin != '') $contact .= '<li><a href="'.$linkedin.'" class="social-icon linkedin" title="LinkedIn" target="_blank"><i class="icon-linkedin-sign"></i></a></li>';
			if ($googleplus != '') $contact .= '<li><a href="'.$googleplus.'" class="social-icon googleplus" title="Google Plus" target="_blank"><i class="icon-google-plus"></i></a></li>';
			$contact .= '</ul></footer>';
		}
		else
		{
			$contact = '';
		}

		return '<div class="profile '.$class.'">'.$profile_image.'<div class="content"><h4>'.$profile_link_open.$name.$profile_link_close.'</h4><p class="role">'.$role.'</p><p>'.do_shortcode($content).'</p>'.$contact.'</div></div>';
	}
}


/****************************************************
* Portfolio
****************************************************/

if (!function_exists('euged_shortcode_portfolio'))
{
	function euged_shortcode_portfolio($atts, $content = null)
	{
		extract(
			shortcode_atts(
				array(
					'columns' => '4',
					'load' => '4',
					'orderby' => 'date',
					'order' => 'asc',
					'category' => '',
					'id' => '',
					'showtitle' => 'yes',
					'showdate' => 'yes',
					'showbiz' => 'no',
					'sb_entry_size_offset' => '',
					'sb_container_offset_right' => '',
					'sb_height_offset_bottom' => '',
					'sb_carousel' => '',
					'sb_visible_elements_array' => '',
					'sb_drag_and_scroll' => '',
					'sb_navigation_side' => ''
				),
				$atts
			)
		);

		// Validation
		if (!in_array($columns, array('2','3','4','5')))
		{
			$columns = '4';
		}

		if (!is_numeric($load))
		{
			$load = '4';
		}

		if (!in_array($orderby, array('title','date','rand','random','menu_order','ID','author','none','modified','comment_count')))
		{
			$orderby = 'date';
		}

		if ($orderby == 'random')
		{
			$orderby = 'rand';
		}

		if (!in_array($order, array('asc','desc')))
		{
			$order = 'asc';
		}

		if (!empty($category))
		{
			$categories = explode(',',$category);

			foreach($categories as $key => $value)
			{
				$categories[$key] = trim($value);
			}

			$tax_query = array(
				array(
				'taxonomy' => 'portfolio_category',
				'field' => 'slug',
				'terms' => $categories
				)
			);
		}
		else
		{
			$tax_query = array();
		}

		if (!empty($id))
		{
			$ids = explode(',',$id);

			foreach($ids as $key => $value)
			{
				$ids[$key] = trim($value);
			}

			$post__in = $ids;
		}
		else
		{
			$post__in = array();
		}

		if (!in_array($showtitle, array('yes','no')))
		{
			$showtitle = 'yes';
		}

		if (!in_array($showdate, array('yes','no')))
		{
			$showdate = 'yes';
		}

		// Classes
		switch($columns)
		{
			case '2' :
				$grid		= 'half';
				$column		= 'two';
			break;
			case '3' :
				$grid		= 'third';
				$column		= 'three';
			break;
			case '4' :
				$grid		= 'quarter';
				$column		= 'four';
			break;
			case '5' :
				$grid		= 'fifth';
				$column		= 'five';
			break;
		}

		// Showbiz
		if (!in_array($showbiz, array('yes','no'))) {
			$showbiz = 'no';
		}

		if (empty($sb_navigation_align) || !in_array($sb_navigation_align, array('right','left','center'))) {
			$sb_navigation_align = 'right';
		}

		$showbiz_atts = array(
			'sb_entry_size_offset',
			'sb_container_offset_right',
			'sb_height_offset_bottom',
			'sb_carousel',
			'sb_visible_elements_array',
			'sb_drag_and_scroll'
		);

		$data_atts = array();

		foreach( $showbiz_atts as $showbiz_att )
		{
			if( !empty( $$showbiz_att ) )
			{
				$data_atts[] = sprintf( 'data-'.$showbiz_att.'="%s"', $$showbiz_att );
			}
		}

		$data_atts = implode( ' ', $data_atts );

		// Setup
		global $post, $global_admin_options;
		$r = $t = 0;
		$lightbox_enabled = !empty($global_admin_options['portfolio_enable_lightbox']) ? $global_admin_options['portfolio_enable_lightbox'] : 'true';

		$args = array(
			'post_type' => 'portfolio',
			'order' => $order,
			'numberposts' => $load,
			'orderby' => $orderby,
			'exclude' => $post->ID,
			'tax_query' => $tax_query,
			'post__in' => $post__in
		);

		$portfolio = get_posts($args);

		if ($portfolio)
		{
			$output = '<div class="shortcode portfolio archive grid">';

			// Output
			foreach($portfolio as $project)
			{
				$r++; // count per row
				$t++; // total count
				$post_thumbnail = wp_get_attachment_url( get_post_thumbnail_id( $project->ID ) );

				if ($r == 1)
				{
					if( $showbiz == 'yes' )
					{
						$data_left = uniqid();
						$data_right = uniqid();
						$output .= '<div class="showbiz-enabled" '.$data_atts.'>';
						$output .= '<div class="showbiz-navigation text'.$sb_navigation_align.'">';
						$output .= '<a id="'.$data_left.'" class="icon-chevron-left"></a>';
						$output .= '<a id="'.$data_right.'" class="icon-chevron-right"></a>';
						$output .= '</div>';
						$output .= '<div class="showbiz" data-left="#'.$data_left.'" data-right="#'.$data_right.'">';
						$output .= '<div class="overflowholder">';
						$output .= '<ul>';
					}
					else
					{
						$output .= '<div class="grid-row linearise">';
					}
				}

				// Output
				if( $showbiz == 'yes' )
				{
					$output .= '<li>';
				}
				else
				{
					$output .= '<div class="grid-item one-'.$grid.'">';
				}

				$output .= '<article class="portfolio archive grid '.$column.'-column">';
				$output .= '<div class="image">';
				$output .= '<img src="'.$post_thumbnail.'">';
				$output .= '<div class="hover">';
				$output .= '<a class="action" href="'.get_permalink( $project->ID ).'"><i class="icon-chevron-right"></i></a>';
				if( $lightbox_enabled == 'true' )
				{
					$output .= '<a class="action fancybox" href="'.$post_thumbnail.'"><i class="icon-search"></i></a>';
				}
				$output .= '</div>';
				$output .= '</div>';

				if ($showtitle == 'yes' || $showdate == 'yes')
				{
					$output .= '<div class="meta">';
					if ($showtitle == 'yes')	$output .= '<h4 class="title"><a href="'.get_permalink($project->ID).'">'.$project->post_title.'</a></h4>';
					if ($showdate == 'yes')	$output .= '<p class="datetime">'.get_the_time(get_option('date_format'), $project->ID).'</p>';
					$output .= '</div>';
				}
				$output .= '</article>';

				if( $showbiz == 'yes' )
				{
					$output .= '</li>';
				}
				else
				{
					$output .= '</div>';
				}

				if ( $showbiz == 'yes' && $t == count($portfolio) )
				{
					$output .= '</ul></div></div></div>';
				}
				elseif ( $showbiz == 'no' && ( $r == $columns || $t == count($portfolio) ) )
				{
					$output .= '</div>';
					$r = 0;
				}
			}

			$output .= '</div>';
		}
		else
		{
			$output = '<p class="notice warning">'.__('No projects to display', 'euged').'</p>';
		}

		return $output;
	}
	add_shortcode('portfolio','euged_shortcode_portfolio');
}


/****************************************************
* Pullquote
****************************************************/

if (!function_exists('euged_shortcode_pullquote'))
{
	function euged_shortcode_pullquote($atts, $content = null)
	{
		extract(
			shortcode_atts(
				array(
					'align' => 'left'
				),
				$atts
			)
		);

		if (!in_array($align, array('left','right')))
		{
			$align = 'left';
		}

		return '<figure class="pullquote '.$align.'">'.$content.'</figure>';
	}
}

/****************************************************
* Raw
****************************************************/

if (!function_exists('euged_shortcode_raw'))
{
	function euged_shortcode_raw($atts, $content = null)
	{
		$content = htmlentities( trim( $content ), ENT_NOQUOTES, "UTF-8", false );
		$content = str_replace( '<br />', '', $content );
		return '<textarea class="code" style="height:300px">'.$content.'</textarea>';
	}
}


/****************************************************
* Tabs
****************************************************/

if (!function_exists('euged_shortcode_tabs'))
{
	function euged_shortcode_tabs($atts, $content = null)
	{
		$GLOBALS['tab_count'] = 0;
		$randomid = rand(100,999);

		do_shortcode($content);

		if (is_array($GLOBALS['tabs']))
		{
			$i = 0;
			foreach($GLOBALS['tabs'] as $tab)
			{
				$i++;
				if ($tab['icon'] != '') {
					$icon = '<i class="icon-'.$tab['icon'].'"></i>';
				}

				$tabs[] = '<li class="detail"><a href="#panel-'.$randomid.$i.'">'.$icon . $tab['title'].'</a></li>';
				$panes[] = '<div class="panel" id="panel-'.$randomid.$i.'"><p>'.$tab['content'].'</p></div>';
				unset($icon);
			}
			$return = '<div class="tab-group"><nav class="tabs"><ul>'.implode("\n",$tabs).'</ul></nav><div class="panels detail">'.implode("\n",$panes).'</div></div>';
		}
		return $return;
	}
}

// Tab
if (!function_exists('euged_shortcode_tab'))
{
	function euged_shortcode_tab($atts, $content = null)
	{
		extract(
			shortcode_atts(
				array(
					'title' => '',
					'icon'  => ''
				),
				$atts
			)
		);

		$x = $GLOBALS['tab_count'];
		$GLOBALS['tabs'][$x] = array('title' => sprintf($title,$GLOBALS['tab_count']), 'icon' => $icon, 'content' => $content);
		$GLOBALS['tab_count']++;
	}
}


/****************************************************
* Tag List
****************************************************/

if (!function_exists('euged_shortcode_tag_list'))
{
	function euged_shortcode_tag_list($atts, $content = null)
	{
		return '<ul class="tags">'.do_shortcode($content).'</ul>';
	}
}

// Tag
if (!function_exists('euged_shortcode_tag_list_item'))
{
	function euged_shortcode_tag_list_item($atts, $content = null)
	{
		return '<li>'.$content.'</li>';
	}
}


/****************************************************
* Teaser
****************************************************/

if (!function_exists('euged_shortcode_teaser'))
{
	function euged_shortcode_teaser($atts, $content = null)
	{
		extract(
			shortcode_atts(
				array(
					'title' => '',
					'link' => '',
					'image' => '',
					'boxed' => 'yes',
					'target'  => '_self'
				),
				$atts
			)
		);

		if (!empty($link))
		{
			if (is_numeric($link)) {
				$link = get_permalink($link);
			}

			$link_open = '<a href="'.$link.'" target="'.$target.'">';
			$link_close = '</a>';
		} else {
			$link_open = $link_close = '';
		}

		if (!empty($title)) {
			$title = '<h3>'.$link_open.$title.$link_close.'</h3>';
		}

		if (!empty($image)) {
			$image = '<div class="image">'.$link_open.'<img src="'.$image.'" />'.$link_close.'</div>';
		}

		if (!in_array($boxed, array('yes','no'))) {
			$boxed = 'yes';
		}

		if ($boxed == 'yes') {
			$class = 'boxed detail';
		} else {
			$class = 'unboxed';
		}

		return '<div class="teaser '.$class.' clearfix">'.$image.'<div class="content">'.$title.do_shortcode($content).'</div></div>';
	}
}


/****************************************************
* Pre Process Shortcodes
****************************************************/

if (!function_exists('euged_filter_process_shortcodes'))
{
	function euged_filter_process_shortcodes($content, $append = false)
		{
		global $shortcode_tags;

		// Backup all registered shortcodes
		$backup = $shortcode_tags;

		// Clear all the shortcodes
		if ( $append == false )
		{
			remove_all_shortcodes();
		}

		// Register all new shortcodes
		add_shortcode('accordions','euged_shortcode_accordions');
		add_shortcode('accordion','euged_shortcode_accordion');
		add_shortcode('blockquote','euged_shortcode_blockquote');
		add_shortcode('box','euged_shortcode_box');
		add_shortcode('br','euged_shortcode_br');
		add_shortcode('button','euged_shortcode_button');
		add_shortcode('callout','euged_shortcode_callout');
		add_shortcode('clear','euged_shortcode_clear');
		add_shortcode('raw','euged_shortcode_raw');
		add_shortcode('gap','euged_shortcode_gap');
		add_shortcode('hr','euged_shortcode_hr');
		add_shortcode('icon_list','euged_shortcode_icon_list');
		add_shortcode('item','euged_shortcode_icon_list_item');
		add_shortcode('lead','euged_shortcode_lead');
		add_shortcode('person','euged_shortcode_person');
		add_shortcode('pullquote','euged_shortcode_pullquote');
		add_shortcode('row','euged_shortcode_grid_row');
		add_shortcode('subrow','euged_shortcode_grid_row');
		add_shortcode('subsubrow','euged_shortcode_grid_row');
		add_shortcode('column','euged_shortcode_grid_item');
		add_shortcode('subcolumn','euged_shortcode_grid_item');
		add_shortcode('subsubcolumn','euged_shortcode_grid_item');
		add_shortcode('tabs','euged_shortcode_tabs');
		add_shortcode('tab','euged_shortcode_tab');
		add_shortcode('tag_list','euged_shortcode_tag_list');
		add_shortcode('tag','euged_shortcode_tag_list_item');
		add_shortcode('teaser','euged_shortcode_teaser');

		// Do the shortcodes (only for those new ones registered above)
		$content = do_shortcode($content);

		// Restore the original shortcodes
		if ( $append == false )
		{
			$shortcode_tags = $backup;
		}

		return $content;
		}

	add_filter('the_content','euged_filter_process_shortcodes', 7);
	add_filter('widget_text','euged_filter_process_shortcodes', 7);
}