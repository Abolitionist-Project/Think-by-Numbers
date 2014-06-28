<?php
/****************************************************
* Portfolio
****************************************************/

if( !defined( 'PORTFOLIO_REWRITE_SLUG' ) )
{
	define( PORTFOLIO_REWRITE_SLUG , 'portfolio' );
}

if( !defined( 'PORTFOLIO_CATEGORY_REWRITE_SLUG' ) )
{
	define( PORTFOLIO_CATEGORY_REWRITE_SLUG , 'portfolio-category' );
}

// Post Type
$args = array(
	'supports' => array('title','editor','thumbnail','excerpt','page-attributes','custom-fields','comments'),
	'rewrite' => array('slug' => PORTFOLIO_REWRITE_SLUG),
	'has_archive' => PORTFOLIO_REWRITE_SLUG
);
$labels = array(
	'singular_name'			=> _x('Project', 'post type singular name', 'euged'),
	'add_new'				=> _x('Add New', 'portfolio', 'euged'),
	'add_new_item'			=> __('Add New Project', 'euged'),
	'edit_item'				=> __('Edit Project', 'euged'),
	'new_item'				=> __('New Project', 'euged'),
	'all_items'				=> __('All Projects', 'euged'),
	'view_item'				=> __('View Project', 'euged'),
	'search_items'			=> __('Search Projects', 'euged'),
	'not_found'				=> __('No project found', 'euged'),
	'not_found_in_trash'	=> __('No projects found in trash', 'euged'),
	'menu_name'				=> __('Portfolio', 'euged')
);
$portfolio = register_cuztom_post_type( 'portfolio', $args, $labels );

// Taxonomy
$args = array(
	'hierarchical' => true,
	'rewrite' => array('slug' => PORTFOLIO_CATEGORY_REWRITE_SLUG, 'hierarchical' => true )
);
$labels = array(
	'name'					=> _x('Categories', 'taxonomy general name', 'euged'),
	'singular_name'			=> _x('Category', 'taxonomy singular name', 'euged'),
	'search_items'			=> __('Search Categories', 'euged'),
	'all_items'				=> __('All Categories', 'euged'),
	'parent_item'			=> __('Parent Category', 'euged'),
	'parent_item_colon' 	=> __('Parent Category:', 'euged'),
	'edit_item'				=> __('Edit Category', 'euged'),
	'update_item'			=> __('Update Category', 'euged'),
	'add_new_item'			=> __('Add New Category', 'euged'),
	'new_item_name' 		=> __('New Category Name', 'euged'),
	'menu_name' 			=> __('Categories', 'euged')
);
$portfolio->add_taxonomy( 'portfolio_category', $args, $labels );

// Meta Boxes
$portfolio->add_meta_box(
	'portfolio_options',
	__('Portfolio Options', 'euged'),
	array(
		array(
			'id_name'	=> 'portfolio_options_style',
			'label'		=> __('Portfolio Style', 'euged'),
			'type'		=> 'select',
			'options'	=> array(
				'single-wide' => 'Wide',
				'single-half' => 'Half'
			),
			'default_value'	=> 'single-half'
		),
		array(
			'id_name'	=> 'portfolio_options_show_other_projects',
			'label'		=> __('Show Other Projects', 'euged'),
			'type'		=> 'checkbox',
			'default_value'	=> 'on'
		),
		array(
			'id_name'	=> 'portfolio_options_other_projects_order',
			'label'		=> __('Other Projects Order', 'euged'),
			'type'		=> 'select',
			'options'	=> array(
				'title' => 'Title (A-Z)',
				'date' => 'Date',
				'rand' => 'Random',
				'menu_order' => 'Menu Order'
			),
			'default_value' => 'rand'
		),
		array(
			'id_name'	=> 'portfolio_options_other_project_count',
			'label'		=> __('Show X Projects', 'euged'),
			'type'		=> 'select',
			'options'	=> array(
				'2' => '2',
				'3' => '3',
				'4' => '4'
			),
			'default_value' => '4'
		)
	)
);

$portfolio->add_meta_box(
	'project_details',
	__('Project Details', 'euged'),
	array(
		array(
			'id_name'	=> 'project_details_enable',
			'label'		=> __('Show Project Details', 'euged'),
			'type'		=> 'checkbox',
			'default_value'	=> 'on'
		),
		array(
			'id_name'	=> 'project_details_project_url',
			'label'		=> __('Project URL', 'euged'),
			'type'		=> 'text'
		),
		array(
			'id_name'	=> 'project_details_client_name',
			'label'		=> __('Client Name', 'euged'),
			'type'		=> 'text'
		),
		array(
			'id_name'	=> 'project_details_client_url',
			'label'		=> __('Client URL', 'euged'),
			'type'		=> 'text'
		)
	)
);

$portfolio->add_meta_box(
	'testimonial',
	__('Testimonial', 'euged'),
	array(
		array(
			'id_name'	=> 'testimonial_show_testimonial',
			'label'		=> __('Show Testimonial', 'euged'),
			'type'		=> 'checkbox'
		),
		array(
			'id_name'	=> 'testimonial_author',
			'label'		=> __('Author', 'euged'),
			'type'		=> 'text'
		),
		array(
			'id_name'	=> 'testimonial_author_role',
			'label'		=> __('Role', 'euged'),
			'type'		=> 'text'
		),
		array(
			'id_name'	=> 'testimonial_content',
			'label'		=> __('Content', 'euged'),
			'type'		=> 'textarea',
			'rows'		=> 4
		)
	)
);

$portfolio->add_meta_box(
	'page_options',
	__('Page Options', 'euged'),
	array(
		array(
			'id_name'	=> 'page_options_show_breadcrumbs',
			'label'		=> __('Show Breadcrumbs', 'euged'),
			'type'		=> 'checkbox',
			'default_value'	=> true
		),
		array(
			'id_name'	=> 'page_options_titlebar_style',
			'label'		=> __('Title Bar Style', 'euged'),
			'type'		=> 'select',
			'options'	=> array(
				'titlebar-v1' => 'Active',
				'titlebar-slider' => 'Slider',
				'hidden' => 'Hidden'
			),
			'default_value' => 'hidden'
		),
		array(
			'id_name'	=> 'page_options_breadcrumbs_position',
			'label'		=> __('Breadcrumbs Position', 'euged'),
			'type'		=> 'select',
			'options'	=> array(
				'above'	=> 'Above Title Bar',
				'below'	=> 'Below Title Bar'
			),
			'default_value'	=> 'above'
		),
		array(
			'id_name'	=> 'page_options_slider_shortcode',
			'label'		=> __('Slider Shortcode', 'euged'),
			'type'		=> 'text'
		),
		array(
			'id_name'	=> 'page_options_titlebar_textalign',
			'label'		=> __('Title Bar Text Align', 'euged'),
			'type'		=> 'select',
			'options'	=> array(
				'left'		=> 'Left',
				'center'	=> 'Center'
			),
			'default_value'	=> 'left'
		),
		array(
			'id_name'	=> 'page_options_show_subtitle',
			'label'		=> __('Show Sub Title', 'euged'),
			'type'		=> 'checkbox'
		),
		array(
			'id_name'	=> 'page_options_subtitle',
			'label'		=> __('Sub Title', 'euged'),
			'type'		=> 'text'
		),
		array(
			'id_name'	=> 'page_options_show_titlebar_cta',
			'label'		=> __('Title Bar CTA', 'euged'),
			'type'		=> 'checkbox'
		),
		array(
			'id_name'	=> 'page_options_titlebar_cta_link',
			'label'		=> __('Title Bar CTA Link', 'euged'),
			'type'		=> 'text'
		),
		array(
			'id_name'	=> 'page_options_titlebar_cta_text',
			'label'		=> __('Title Bar CTA Text', 'euged'),
			'type'		=> 'text'
		)
	)
);


/****************************************************
* Pages
****************************************************/

// Get Sidebars
$sidebars = array('no-sidebar' => 'No Sidebar');
foreach ($GLOBALS['wp_registered_sidebars'] as $sidebar => $widgets)
{
	$sidebars[$sidebar] = ucwords(str_replace(array('-', '_'), ' ', $sidebar));
}

// Remove Non-sidebars (Other widget areas like info bar, footer etc.)
unset($sidebars['wp_inactive_widgets'], $sidebars['infobar-widget-area'], $sidebars['first-footer-widget-area'], $sidebars['second-footer-widget-area'], $sidebars['third-footer-widget-area'], $sidebars['fourth-footer-widget-area'], $sidebars['prefooter-widget-area']);

$page_post_type = register_cuztom_post_type('page');

// Meta Boxes
$page_post_type->add_meta_box(
	'page_options',
	__('Page Options', 'euged'),
	array(
		array(
			'id_name'	=> 'page_options_show_breadcrumbs',
			'label'		=> __('Show Breadcrumbs', 'euged'),
			'type'		=> 'checkbox',
			'default_value'	=> true
		),
		array(
			'id_name'	=> 'page_options_sidebar',
			'label'		=> __('Sidebar', 'euged'),
			'type'		=> 'select',
			'options'	=> $sidebars,
			'default_value'	=> 'no-sidebar'
		),
		array(
			'id_name'	=> 'page_options_sidebar_position',
			'label'		=> __('Sidebar Position', 'euged'),
			'type'		=> 'select',
			'options'	=> array(
				'left'	=> 'Left',
				'right'	=> 'Right'
			),
			'default_value'	=> 'left'
		),
		array(
			'id_name'	=> 'page_options_titlebar_style',
			'label'		=> __('Title Bar Style', 'euged'),
			'type'		=> 'select',
			'options'	=> array(
				'titlebar-v1' => 'Active',
				'titlebar-slider' => 'Slider',
				'hidden' => 'Hidden'
			),
			'default_value' => 'hidden'
		),
		array(
			'id_name'	=> 'page_options_breadcrumbs_position',
			'label'		=> __('Breadcrumbs Position', 'euged'),
			'type'		=> 'select',
			'options'	=> array(
				'above'	=> 'Above Title Bar',
				'below'	=> 'Below Title Bar'
			),
			'default_value'	=> 'above'
		),
		array(
			'id_name'	=> 'page_options_slider_shortcode',
			'label'		=> __('Slider Shortcode', 'euged'),
			'type'		=> 'text'
		),
		array(
			'id_name'	=> 'page_options_titlebar_textalign',
			'label'		=> __('Title Bar Text Align', 'euged'),
			'type'		=> 'select',
			'options'	=> array(
				'left'		=> 'Left',
				'center'	=> 'Center'
			),
			'default_value'	=> 'left'
		),
		array(
			'id_name'	=> 'page_options_show_subtitle',
			'label'		=> __('Show Sub Title', 'euged'),
			'type'		=> 'checkbox'
		),
		array(
			'id_name'	=> 'page_options_subtitle',
			'label'		=> __('Sub Title', 'euged'),
			'type'		=> 'text'
		),
		array(
			'id_name'	=> 'page_options_show_titlebar_cta',
			'label'		=> __('Title Bar CTA', 'euged'),
			'type'		=> 'checkbox'
		),
		array(
			'id_name'	=> 'page_options_titlebar_cta_link',
			'label'		=> __('Title Bar CTA Link', 'euged'),
			'type'		=> 'text'
		),
		array(
			'id_name'	=> 'page_options_titlebar_cta_text',
			'label'		=> __('Title Bar CTA Text', 'euged'),
			'type'		=> 'text'
		)
	)
);


/****************************************************
* Post
****************************************************/

$post_post_type = register_cuztom_post_type('post');

// Meta Boxes
$post_post_type->add_meta_box(
	'audio_settings',
	__('Audio Settings', 'euged'),
	array(
		array(
			'id_name'	=> 'audio_settings_embed_code',
			'label'		=> __('Embed Code', 'euged'),
			'type'		=> 'textarea',
			'rows'		=> 5
		)
	)
);

$post_post_type->add_meta_box(
	'link_settings',
	__('Link Settings', 'euged'),
	array(
		array(
			'id_name'	=> 'link_settings_title',
			'label'		=> __('Title', 'euged'),
			'type'		=> 'text'
		),
		array(
			'id_name'	=> 'link_settings_url',
			'label'		=> __('URL', 'euged'),
			'type'		=> 'text'
		),
		array(
			'id_name'	=> 'link_settings_target',
			'label'		=> __('Target', 'euged'),
			'type'		=> 'select',
			'options'	=> array(
				'_self' => 'Same Window/Tab',
				'_blank' => 'New Window/Tab'
			)
		)
	)
);

$post_post_type->add_meta_box(
	'quote_settings',
	__('Quote Settings', 'euged'),
	array(
		array(
			'id_name'	=> 'quote_settings_content',
			'label'		=> __('Content', 'euged'),
			'type'		=> 'textarea',
			'rows'		=> 3
		),
		array(
			'id_name'	=> 'quote_settings_author',
			'label'		=> __('Author', 'euged'),
			'type'		=> 'text'
		)
	)
);

$post_post_type->add_meta_box(
	'video_settings',
	__('Video Settings', 'euged'),
	array(
		array(
			'id_name'	=> 'video_settings_embed_code',
			'label'		=> __('Embed Code', 'euged'),
			'type'		=> 'textarea',
			'rows'		=> 5
		)
	)
);