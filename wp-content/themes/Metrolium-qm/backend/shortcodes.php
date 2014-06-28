<?php
/****************************************************
* QuantiModo Portfolio
****************************************************/

if (!function_exists('qm_shortcode_portfolio_menu'))
{
	function qm_shortcode_portfolio_menu($atts, $content = null)
	{
		extract(
			shortcode_atts(
				array(
					'parentcategoryid' => '',
					'parentpageid' => '',
					'parentname' => ''
				),
				$atts
			)
		);
		$output = '<nav class="filter isotope-filter"><ul>';
		
		$args=array(
			'child_of' => $parentcategoryid,
			'taxonomy' => 'portfolio_category'
			);
		$child_categories = get_categories($args); 
		
		$page_id = get_the_ID();
		
		if($page_id == $parentpageid)
		{
			
                    $output .= '<li class="selected"><a href="#filter" data-filter="*">' .  $parentname . '</a></li>';
		}
		else
		{
			$output .= '<li><a href="#filter" data-filter=".filter-' . strtolower( str_replace( ')', '', str_replace( '(', '', str_replace( ' ', '-', $parentname )))) . '">' .  $parentname . '</a></li>';
		}
		
		foreach ($child_categories as $category) 
		{
			if($page_id == $category->slug)
			{
				$output .= '<li class="selected"><a href="#filter" data-filter=".filter-' . strtolower( str_replace( ')', '', str_replace( '(', '', str_replace( ' ', '-', $category->cat_name )))) . '">' .  $category->cat_name . ' ' . '</a></li>';
			}
			else
			{
				$output .= '<li><a href="#filter" data-filter=".filter-' . strtolower( str_replace( ')', '', str_replace( '(', '', str_replace( ' ', '-', $category->cat_name )))) . '">' . $category->cat_name . '</a></li>';
			}
		}

		$output .= '</ul></nav>';
		
		return $output;
	}
	
	add_shortcode('qm-portfolio-menu','qm_shortcode_portfolio_menu');
}
if (!function_exists('qm_shortcode_portfolio'))
{
	function qm_shortcode_portfolio($atts, $content = null)
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
		
			$output = '<div class="shortcode portfolio archive grid  isotope-grid">';

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
                                                                               
                                        $filter_tags = '';
                                        $terms = get_the_terms( $project->ID, 'portfolio_category' );
                                        if( !empty( $terms ) )
                                        {                                            
                                            foreach( $terms as $term )
                                            {
                                                $filter_tags .= ' filter-' . strtolower( str_replace( ')', '', str_replace( '(', '', str_replace( ' ', '-', $term->name ))));
                                            }
                                        }

			                           
					$output .= '<div class="isotope-item grid-item one-'.$grid . $filter_tags.'">';
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
	add_shortcode('qm-portfolio','qm_shortcode_portfolio');
}

/****************************************************
* QuantiModo Portfolio with multi level menu
****************************************************/

if (!function_exists('qm_shortcode_portfolio_menu_multi_level'))
{
	function qm_shortcode_portfolio_menu_multi_level($atts, $content = null)
	{
		extract(
			shortcode_atts(
				array(
					'parentcategoryid' => '',
					'parentpageid' => '',
					'parentname' => '',
                                        'pageid' => ''
				),
				$atts
			)
		);
                $output = '<div id="portfolio-menu-for-wide-screen">';
                $parentcategoryids = explode(",", $parentcategoryid);
                $parentpageids = explode(",", $parentpageid);
                $parentnames = explode(",", $parentname);
		$numMenus = count($parentcategoryids);
                $i = 0;    
                foreach($parentcategoryids as $key=>$value) {
                    prepare_menu($output, $parentcategoryids[$key], $parentpageids[$key], $parentnames[$key], $pageid, ++$i === $numMenus);
                }
                $output .= '</div>';
                return $output;
	}
        
        function prepare_menu(&$output, $parentcategoryid, $parentpageid, $parentname, $pageid, $lastmenu) {
                $output .= '<nav class="filter isotope-filter-none" '. ($lastmenu ? '' : 'style="margin-bottom:2px;"') .'>'
                        . '<ul class="filter option-set clearfix " data-filter-group="'.$parentpageid.'">';
		
		$args=array(
			'child_of' => $parentcategoryid,
			'taxonomy' => 'portfolio_category'
			);
		$child_categories = get_categories($args); 
		
		$page_id = get_the_ID();
		
		if($page_id == $pageid)
		{			
                    $output .= '<li class="selected"><a href="#filter-'.$parentpageid.'-all" data-filter-value="">' .  $parentname . '</a></li>';
		}
		else
		{                    
                    $output .= '<li><a href="#filter-'.$parentpageid.'-all" data-filter-value="">' .  $parentname . '</a></li>';
		}
		
		foreach ($child_categories as $category) 
		{
                        $fv = strtolower( str_replace( ')', '', str_replace( '(', '', str_replace( ' ', '-', $category->cat_name ))));
			if($page_id == $category->slug)
			{                                       
				$output .= '<li class="selected"><a href="#filter-' . $parentpageid . '-' . $fv . '" data-filter-value=".' . $fv . '">' .  $category->cat_name . ' ' . '</a></li>';
			}
			else
			{
				$output .= '<li><a href="#filter-' . $parentpageid . '-' . $fv . '"  data-filter-value=".' . $fv . '">' . $category->cat_name . '</a></li>';
			}
		}

		$output .= '</ul></nav>';		
        }
	
	add_shortcode('qm-portfolio-menu-multi-level','qm_shortcode_portfolio_menu_multi_level');
}
if (!function_exists('qm_shortcode_portfolio_multi_level'))
{
	function qm_shortcode_portfolio_multi_level($atts, $content = null)
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
		
			$output = '<div id="container" class="shortcode portfolio archive grid  isotope-grid portfolio-tools">';

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
                                                                               
                                        $filter_tags = '';
                                        $terms = get_the_terms( $project->ID, 'portfolio_category' );
                                        if( !empty( $terms ) )
                                        {                                            
                                            foreach( $terms as $term )
                                            {
                                                $filter_tags .= ' ' . strtolower( str_replace( ')', '', str_replace( '(', '', str_replace( ' ', '-', $term->name ))));
                                            }
                                        }

			                           
					$output .= '<div class="isotope-item grid-item one-'.$grid . $filter_tags.'">';
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
	add_shortcode('qm-portfolio-multi-level','qm_shortcode_portfolio_multi_level');
}

/****************************************************
* QuantiModo Portfolio with multi level drop down menu
****************************************************/

if (!function_exists('qm_shortcode_portfolio_menu_multi_level_drop_down'))
{
	function qm_shortcode_portfolio_menu_multi_level_drop_down($atts, $content = null)
	{
		extract(
			shortcode_atts(
				array(
					'parentcategoryid' => '',
					'parentpageid' => '',
					'parentname' => '',
                                        'pageid' => ''
				),
				$atts
			)
		);
                $output = '<div id="portfolio-menu-for-small-screen">'
                        . '<nav class="filter filter-tools isotope-filter-drop-down" style="margin-bottom:2px;">'
                        . '<nav id="navigation-tools" class="primary-tools">'
                        . '<div id="tools-primary-navigation" class=" menu-primary-navigation-container"><div class="menu-default-container"><ul class="menu">';
                $parentcategoryids = explode(",", $parentcategoryid);
                $parentpageids = explode(",", $parentpageid);
                $parentnames = explode(",", $parentname);
		$numMenus = count($parentcategoryids);
                $i = 0;  
                $collectGroup = '';
                foreach($parentcategoryids as $key=>$value) {
                    prepare_menu_drop_down($output, $parentcategoryids[$key], $parentpageids[$key], $parentnames[$key], $pageid, ++$i, $collectGroup);
                }
                $output .= '</ul></div></div></nav></nav>'
                        . '<nav class="filter filter-tools isotope-filter-selected"><ul>'                        
                        . $collectGroup
                        . '</ul></nav>';
                $output .= '</div>';
                return $output;
	}
        
        
        function prepare_menu_drop_down(&$output, $parentcategoryid, $parentpageid, $parentname, $pageid, $menu, &$collectGroup) { 
                $output .= '<div class="option-set " data-filter-group="'.$parentpageid.'">'
                        . '<li menu-top-index="' . $menu . '" choosen-category-name="" menu-group-index="' . $menu . '" id="menu-item-'.$parentpageid.'" class="choosen filter option-set clearfix menu-item menu-item-type-post_type menu-item-object-page '
                        . 'current-menu-item page_item page-item-7 current_page_item menu-item-has-children menu-item-'.$parentpageid.'">'
                        . '<a href="#filter-'.$parentpageid.'-all" data-filter-value="">' .  $parentname . '</a>';
            
                $collectGroup .= '<li class="choosen-category" menu-group="' . $menu . '"><div>' .  $parentname . '</div><span href="#" onclick="return false;" class="remove-selected-category" menu-group="' . $menu . '"></span></li>';                       
		
		$args=array(
			'child_of' => $parentcategoryid,
			'taxonomy' => 'portfolio_category'
			);
		$child_categories = get_categories($args); 		
		
		if(count($child_categories) > 0) {
                    $output .= '<ul class="sub-menu">';
                    foreach ($child_categories as $category) 
                    {   
                        $fv = strtolower( str_replace( ')', '', str_replace( '(', '', str_replace( ' ', '-', $category->cat_name ))));
                        $output .= '<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item" choosen-category-name="' . $category->cat_name . '" menu-group-index="' . $menu . '">'
                                .  '<a href="#filter-' . $parentpageid . '-' . $fv . '"  data-filter-value=".' . $fv . '" >' . $category->cat_name . '</a></li>';                
                    }
                    $output .= '</ul>';
                }
                $output .= '</li></div>';		
        }
	
	add_shortcode('qm-portfolio-menu-multi-level-drop-down','qm_shortcode_portfolio_menu_multi_level_drop_down');
}
