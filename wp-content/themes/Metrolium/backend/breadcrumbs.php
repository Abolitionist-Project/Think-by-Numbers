<?php
/****************************************************
* Source: http://dimox.net/wordpress-breadcrumbs-without-a-plugin/
****************************************************/

if (!function_exists('euged_breadcrumbs'))
{
	function euged_breadcrumbs()
	{
		// Options
		$text['home']		= __( 'Home', 'euged' ); // text for the 'Home' link
		$text['category']	= __( 'Archive by Category "%s"', 'euged' ); // text for a category page
		$text['search']		= __( 'Search Results for "%s"', 'euged' ); // text for a search results page
		$text['tag']		= __( 'Posts Tagged "%s"', 'euged' ); // text for a tag page
		$text['format']		= __( '%s Post Format Archive', 'euged' ); // text for a tag page
		$text['author']		= __( 'Articles Posted by %s', 'euged' ); // text for an author page
		$text['404']		= __( 'Error 404', 'euged' ); // text for the 404 page
		$text['blog']		= get_post(get_option('page_for_posts'))->post_title; // Blog page title
		$showCurrent		= 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
		$showOnFront		= 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
		$delimiter			= ' <i class="separator icon-angle-right"></i> '; // delimiter between crumbs
		$before				= '<span class="current">'; // tag before the current crumb
		$after				= '</span>'; // tag after the current crumb

		global $post, $global_admin_options;
		$homeLink = get_home_url();
		$linkBefore = '<span typeof="v:Breadcrumb">';
		$linkAfter = '</span>';
		$linkAttr = ' rel="v:url" property="v:title"';
		$link = $linkBefore . '<a' . $linkAttr . ' href="%1$s">%2$s</a>' . $linkAfter;


		if (is_front_page())
		{
			if ($showOnFront == 1) {
				echo '<div id="breadcrumbs" class="band">';
				echo '<div class="inner">';
				echo '<div><a href="' . $homeLink . '">' . $text['home'] . '</a></div>';
				echo '</div>';
				echo '</div>';
			}
		}
		else
		{
			echo '<div id="breadcrumbs" class="band">';
			echo '<div class="inner">';
			echo '<div xmlns:v="http://rdf.data-vocabulary.org/#">' . sprintf($link, $homeLink, $text['home']) . $delimiter;

			if (is_category())
			{
				$thisCat = get_category(get_query_var('cat'), false);
				if ($thisCat->parent != 0)
				{
					$cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
					$cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
					$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
					echo $cats;
				}
				echo $before . sprintf($text['category'], single_cat_title('', false)) . $after;
			}
			elseif (is_home())
			{
				echo $before . $text['blog'] . $after;
			}
			elseif (is_search())
			{
				echo $before . sprintf($text['search'], get_search_query()) . $after;
			}
			elseif (is_day())
			{
				echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
				echo sprintf($link, get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F')) . $delimiter;
				echo $before . get_the_time('d') . $after;
			}
			elseif (is_month())
			{
				echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
				echo $before . get_the_time('F') . $after;
			}
			elseif (is_year())
			{
				echo $before . get_the_time('Y') . $after;
			}
			elseif (is_singular('portfolio'))
			{
				printf($link, get_permalink( $global_admin_options['portfolio_page_for_portfolio'] ), get_post( $global_admin_options['portfolio_page_for_portfolio'] )->post_title);
				if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;
			}
			elseif (is_tax('portfolio_category'))
			{
				printf($link, get_permalink( $global_admin_options['portfolio_page_for_portfolio'] ), get_post( $global_admin_options['portfolio_page_for_portfolio'] )->post_title);
				if ($showCurrent == 1) echo $delimiter . $before . single_term_title('', false) . $after;
			}
			elseif (is_single() && !is_attachment())
			{
				if (get_post_type() != 'post')
				{
					$post_type = get_post_type_object(get_post_type());
					printf($link, get_post_type_archive_link($post_type->name), $post_type->labels->name);
					if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;
				}
				else
				{
					$cat = get_the_category(); $cat = $cat[0];
					$cats = get_category_parents($cat, TRUE, $delimiter);
					if ($showCurrent == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
					$cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
					$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
					echo $cats;
					if ($showCurrent == 1) echo $before . get_the_title() . $after;
				}
			}
			elseif (!is_single() && !is_page() && get_post_type() != 'post' && !is_404())
			{
				$post_type = get_post_type_object(get_post_type());
				echo $before . $post_type->labels->name . $after;
			}
			elseif (is_attachment())
			{
				$parent = get_post($post->post_parent);
				$cat = get_the_category($parent->ID); $cat = $cat[0];
				$cats = get_category_parents($cat, TRUE, $delimiter);
				$cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
				$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
				echo $cats;
				printf($link, get_permalink($parent), $parent->post_title);
				if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;
			}
			elseif (is_page() && !$post->post_parent)
			{
				if ($showCurrent == 1) echo $before . get_the_title() . $after;
			}
			elseif (is_page() && $post->post_parent)
			{
				$parent_id  = $post->post_parent;
				$breadcrumbs = array();
				while ($parent_id)
				{
					$page = get_page($parent_id);
					$breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
					$parent_id  = $page->post_parent;
				}
				$breadcrumbs = array_reverse($breadcrumbs);
				for ($i = 0; $i < count($breadcrumbs); $i++)
				{
					echo $breadcrumbs[$i];
					if ($i != count($breadcrumbs)-1) echo $delimiter;
				}
				if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;
			}
			elseif (is_tag())
			{
				echo $before . sprintf($text['tag'], single_tag_title('', false)) . $after;
			}
			elseif (is_author())
			{
				global $author;
				$userdata = get_userdata($author);
				echo $before . sprintf($text['author'], $userdata->display_name) . $after;
			}
			elseif (is_tax())
			{
				echo $before . sprintf($text['format'], single_term_title('', false)) . $after;
			}
			elseif (is_404())
			{
				echo $before . $text['404'] . $after;
			}
			if (get_query_var('paged'))
			{
				echo ' '.__('Page') . ' ' . get_query_var('paged');
			}
			echo '</div>';
			echo '</div>';
			echo '</div>';
		}
	}
}