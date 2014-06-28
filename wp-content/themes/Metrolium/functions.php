<?php
/****************************************************
* Setup
****************************************************/
// Theme Upgrade Script
require_once('includes/theme-upgrade.php');

// Backend
require_once('backend/functions.php');
function register_custom_post_types()
{
	require_once('includes/custom-post-types/config.php');
}
add_action('init', 'register_custom_post_types', 2);

// Widgets
require_once('backend/widgets/browse-blog.php');
require_once('backend/widgets/post-format-archives.php');
require_once('backend/widgets/social-icons.php');
require_once('backend/widgets/twitter-feed.php');
require_once('backend/widgets/recent-posts.php');

// Plugins
require_once('includes/plugins.php');

// Admin Options
$global_admin_options = json_decode( get_option('euga_options'), true );

// Image Sizes
add_image_size( 'widescreen', 500, 281, true );
add_image_size( 'blogImageSize', 200, 200, true );

// Theme Support
add_theme_support('automatic-feed-links');
add_theme_support('post-thumbnails');
add_theme_support('post-formats', array('audio', 'gallery', 'image', 'link', 'quote', 'video'));
add_theme_support('custom-background', array('default-color' => '333333'));
add_theme_support('custom-header', array('height' => 400, 'header-text' => false));

// Navigation Menus
register_nav_menu('primary_navigation', 'Primary Navigation');
register_nav_menu('trim_links', 'Trim Links');

// Misc
if(!isset($content_width)) $content_width = 960;


/****************************************************
* Filters
****************************************************/
add_filter('wp_list_categories', 'euged_filter_tidy_widget_postcount');
add_filter('get_archives_link', 'euged_filter_tidy_widget_postcount');
add_filter('excerpt_more', 'euged_filter_excerpt_more');
add_filter('excerpt_length', 'euged_filter_excerpt_length');


/****************************************************
* Actions
****************************************************/
add_action('init', 'euged_action_start_session');
add_action('init', 'euged_action_remove_page_thumbnails');
add_action('after_setup_theme', 'euged_after_setup_theme');
add_action('widgets_init', 'euged_action_register_sidebars');
add_action('widgets_init', 'euged_action_unregister_widgets' );
add_action('wp_enqueue_scripts', 'euged_action_enqueue');
add_action('wp_head', 'conditional_scripts');
add_action('admin_enqueue_scripts', 'euged_action_admin_enqueue');
add_action('wp_login', 'euged_action_reset_session');
add_action('wp_logout', 'euged_action_reset_session');
add_action('tgmpa_register', 'euged_included_plugins');

remove_action('wp_head', 'wp_generator');


/****************************************************
* Activation
****************************************************/
if( get_option( 'euged_metrolium_activated', '0' ) == '0' )
{
	require_once('includes/activation.php');
	add_action('after_switch_theme', 'euged_metrolium_activate');
}


/****************************************************
* Functions
****************************************************/
function euged_filter_tidy_widget_postcount($variable)
{
	$variable = str_replace('(', '<span class="post-count">', $variable);
	$variable = str_replace(')', '</span>', $variable);
	return $variable;
}

function euged_filter_excerpt_more()
{
	return '&hellip;';
}

function euged_filter_excerpt_length()
{
	return 70;
}

function euged_action_remove_page_thumbnails()
{
	remove_post_type_support( 'page', 'thumbnail' );
}

function euged_after_setup_theme()
{
	add_editor_style();
	load_theme_textdomain( 'euged', get_template_directory().'/lang' );
}

function euged_action_unregister_widgets()
{
	unregister_widget('WP_Widget_Calendar');
	unregister_widget('WP_Widget_Tag_Cloud');
}

function euged_action_admin_enqueue($hook)
{
	$theme = wp_get_theme();
	$ver = $theme['Version'];
	$tmp_uri = get_template_directory_uri();

	wp_enqueue_script( 'meta-boxes', $tmp_uri.'/includes/custom-post-types/meta-boxes.min.js', false, $ver );
	wp_enqueue_script( 'post-formats', $tmp_uri.'/includes/custom-post-types/post-formats.min.js', false, $ver );
}

function euged_action_enqueue()
{
	global $wp_styles, $global_admin_options;
	$theme = wp_get_theme();
	$ver = $theme['Version'];
	$tmp_uri = get_template_directory_uri();
	$css_uri = $tmp_uri . '/assets/css/';
	$js_uri = $tmp_uri . '/assets/js/';
	$showbiz_uri = $tmp_uri . '/assets/packages/showbizpro/';

	// Google Fonts
	$global_theme_mods = get_theme_mod('euged_global');
	$heading_theme_mods = get_theme_mod('euged_headings');
	$body_font = !empty($global_theme_mods['font_family']) ? str_replace(' ', '+', $global_theme_mods['font_family']) : 'Open Sans';
	$headings_font = !empty($heading_theme_mods['font_family']) ? str_replace(' ', '+', $heading_theme_mods['font_family']) : 'Raleway';

	$subset = !empty($global_admin_options['global_google_font_subset']) ? "&subset=" . $global_admin_options['global_google_font_subset'] : "";

	$protocol = is_ssl() ? 'https' : 'http';
	wp_enqueue_style('google-body-font', $protocol . '://fonts.googleapis.com/css?family=' . $body_font . ':400,400italic,700,700italic' . $subset, false, $ver);
	wp_enqueue_style('google-headings-font', $protocol . '://fonts.googleapis.com/css?family=' . $headings_font . ':400,400italic,700,700italic' . $subset, false, $ver);

	// Enqueue Styles
	if( !defined( 'INCLUDE_PARENT_STYLES' ) || INCLUDE_PARENT_STYLES == true )
	{
		wp_enqueue_style('base-style', $css_uri . 'style.css', false, $ver);
	}

	wp_enqueue_style('font-awesome', $css_uri . 'libs/fontawesome/font-awesome.css', false, $ver);
	wp_enqueue_style('icomoon', $css_uri . 'libs/icomoon/icomoon.css', false, $ver);

	if( is_multisite() )
	{
		$skin_override = sprintf( '%sskin-override-%s.css', $css_uri, get_current_blog_id() );
	}
	else
	{
		$skin_override = sprintf( '%sskin-override.css', $css_uri );
	}
	wp_enqueue_style('skin-override', $skin_override, false, $ver);

	wp_enqueue_style('showbiz-style', $showbiz_uri . 'css/settings.css', false, $ver);
	wp_enqueue_style('showbiz-fancybox-style', $showbiz_uri . 'fancybox/jquery.fancybox.css', false, $ver);

	wp_enqueue_style('style', get_stylesheet_uri(), false, $ver);

	// Register & Enqueue Conditional Styles
	wp_enqueue_style('font-awesome-ie7', $css_uri . 'libs/fontawesome/font-awesome-ie7.css', false, $ver);
	$wp_styles->add_data('font-awesome-ie7', 'conditional', 'IE 7');

	// Enqueue Page Specific Scripts
        /*
	if ( is_post_type_archive('portfolio') || is_tax('portfolio_category') || is_page( $global_admin_options['portfolio_page_for_portfolio'] ) || is_home() || is_archive() || basename(get_permalink()) == 'tools') {
		wp_enqueue_script('isotope', $js_uri . 'jquery.isotope.min.js', array('jquery'), $ver, true);
                wp_enqueue_script('functions', $js_uri . 'functions.js', array('jquery'), $ver, true);
	}
        */
        
	if ( is_singular( array( 'portfolio', 'post' ) ) || is_home() || is_archive() ) {
		wp_enqueue_script('flexslider', $js_uri . 'flexslider.js', array('jquery'), $ver);
	}

	// Register Scripts
	wp_register_script('fitvids', $js_uri . 'fitvids.js', array('jquery'), $ver);
	wp_register_script('hellobar', $js_uri . 'jquery.hellobar.min.js', array('jquery'), $ver, true);
	wp_register_script('showbiz-core', $showbiz_uri . 'js/jquery.themepunch.showbizpro.min.js', array('jquery'), $ver, false);
	wp_register_script('showbiz-fancybox', $showbiz_uri . 'fancybox/jquery.fancybox.pack.js', array('jquery'), $ver, false);
	wp_register_script('mobile-menu', $js_uri . 'jquery.mobile-menu.min.js', array('jquery'), $ver, true);
	wp_register_script('functions', $js_uri . 'functions.js', array('jquery'), $ver, true);

	// Enqueue Scripts
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-accordion');
	wp_enqueue_script('jquery-ui-tabs');
	wp_enqueue_script('fitvids');
	wp_enqueue_script('hellobar');
	wp_enqueue_script('showbiz-fancybox');
	wp_enqueue_script('showbiz-core');
	wp_enqueue_script('mobile-menu');
	wp_enqueue_script('functions');

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}

	// THIS IS FOR THE LIVE OPTIONS DEMO ON FRONTEND (FAKE WP CUSTOMIZER), YOU CAN REMOVE BELOW THIS LINE IF YOU DON'T NEED IT
	if (get_option('theme_demo_mode','0') == '1' || (!empty($_GET[sanitize_key('demo_mode')]) && $_GET[sanitize_key('demo_mode')] == 'yes'))
	{
		wp_enqueue_style('live-options', $css_uri . 'live-options.css', false, $ver);

		wp_enqueue_style('wp-color-picker');

		wp_enqueue_script(
			'iris',
			admin_url('js/iris.min.js'),
			array('jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch'),
			false,
			true
		);

		wp_enqueue_script(
			'wp-color-picker',
			admin_url('js/color-picker.min.js'),
			array('iris'),
			false,
			true
		);

		$colorpicker_l10n = array(
			'clear' => __('Clear', 'euged'),
			'defaultString' => __('Default', 'euged'),
			'pick' => __('Select Color', 'euged')
		);
		wp_localize_script( 'wp-color-picker', 'wpColorPickerL10n', $colorpicker_l10n );

		wp_enqueue_script(
			'live-options',
			$js_uri . 'live-options.js',
			array('jquery', 'wp-color-picker'),
			$ver,
			true
		);
	}
	// THIS IS FOR THE LIVE OPTIONS DEMO ON FRONTEND (FAKE WP CUSTOMIZER), YOU CAN REMOVE ABOVE THIS LINE IF YOU DON'T NEED IT
}

/**
 * Conditional Scripts
 *
 * Unfortunately there is currently no way of adding conditional statements when enqueuing scripts.
 * See: http://stackoverflow.com/questions/11564142/wordpress-enqueue-scripts-for-only-if-lt-ie-9/16221114#16221114
 */
function conditional_scripts() {
	$js_uri = get_template_directory_uri() . '/assets/js/';
	?>
	<!--[if lt IE 9]>
	<script src="<?php echo $js_uri; ?>html5shiv.js"></script>
	<script src="<?php echo $js_uri; ?>respond.js"></script>
	<![endif]-->
	<?php
}

function euged_action_register_sidebars()
{
	// Sidebar
	register_sidebar(array(
		'name'			=> __('Sidebar','euged'),
		'id'			=> 'sidebar-widget-area',
		'before_widget'	=> '<div id="%1$s" class="widget %2$s">',
		'after_widget'	=> '</div>',
		'before_title'	=> '<h4>',
		'after_title'	=> '</h4>'
	));

	// Infobar Widget Area
	register_sidebar(array(
		'name'			=> __('Pre-Footer','euged'),
		'id'			=> 'prefooter-widget-area',
		'before_widget'	=> '',
		'after_widget'	=> '',
		'before_title'	=> '',
		'after_title'	=> ''
	));

	// Pre Footer Widget Area
	register_sidebar(array(
		'name'			=> __('Infobar','euged'),
		'id'			=> 'infobar-widget-area',
		'before_widget'	=> '',
		'after_widget'	=> '',
		'before_title'	=> '',
		'after_title'	=> ''
	));

	// Footer #1
	register_sidebar(array(
		'name'			=> __('Footer #1','euged'),
		'id'			=> 'first-footer-widget-area',
		'before_widget'	=> '<div id="%1$s" class="widget %2$s">',
		'after_widget'	=> '</div>',
		'before_title'	=> '<h4>',
		'after_title'	=> '</h4>'
	));

	// Footer #2
	register_sidebar(array(
		'name'			=> __('Footer #2','euged'),
		'id'			=> 'second-footer-widget-area',
		'before_widget'	=> '<div id="%1$s" class="widget %2$s">',
		'after_widget'	=> '</div>',
		'before_title'	=> '<h4>',
		'after_title'	=> '</h4>'
	));

	// Footer #3
	register_sidebar(array(
		'name'			=> __('Footer #3','euged'),
		'id'			=> 'third-footer-widget-area',
		'before_widget'	=> '<div id="%1$s" class="widget %2$s">',
		'after_widget'	=> '</div>',
		'before_title'	=> '<h4>',
		'after_title'	=> '</h4>'
	));

	// Footer #3
	register_sidebar(array(
		'name'			=> __('Footer #4','euged'),
		'id'			=> 'fourth-footer-widget-area',
		'before_widget'	=> '<div id="%1$s" class="widget %2$s">',
		'after_widget'	=> '</div>',
		'before_title'	=> '<h4>',
		'after_title'	=> '</h4>'
	));

	global $global_admin_options;
	if (!empty($global_admin_options['sidebars']))
	{
		foreach(explode(',', $global_admin_options['sidebars']) as $sidebar)
		{
			$sidebar_human = ucwords( str_replace( '-', ' ', $sidebar ) );
			register_sidebar(array(
				'name'			=> __($sidebar_human, 'Euged'),
				'id'			=> $sidebar,
				'before_widget'	=> '<div id="%1$s" class="widget %2$s">',
				'after_widget'	=> '</div>',
				'before_title'	=> '<h4>',
				'after_title'	=> '</h4>'
			));
		}
	}
}

function euged_action_start_session()
{
	if (!session_id())
	{
		session_start();
	}

	$_SESSION['id'] = $_SESSION['last_activity'] = '';

	if(empty($_SESSION['id']))
	{
		$_SESSION['id'] = rand(100,999).'-'.strtoupper(uniqid());
	}

	if((time() - $_SESSION['last_activity']) > 30*60 || isset($_GET[sanitize_key('reset')]))
	{
		add_action('init','euged_action_reset_session',2);
	}

	$_SESSION['last_activity'] = time();
}

function euged_action_reset_session()
{
	session_unset();
	session_destroy();
	euged_action_start_session();
}

function euged_load_post_format_template($format)
	{
	if(!$format) $format = 'standard';
	get_template_part('includes/post-formats/format-'.$format);
	}

function euged_post_format_icon($format)
	{
	switch($format)
		{
		case 'audio' : $icon = 'volume-up'; break;
		case 'link' : $icon = 'link'; break;
		case 'quote' : $icon = 'quote-left'; break;
		case 'video' : $icon = 'play'; break;
		case 'image' : $icon = 'camera'; break;
		case 'gallery' : $icon = 'picture'; break;
		default : $icon = 'align-left';
		}
	if (!empty($format))
	{
		$open_link = '<a href="'.get_post_format_link($format).'">';
		$close_link = '</a>';
	}
	else
	{
		$open_link = $close_link = '';
	}
	echo $open_link.'<i class="post-format-icon '.$format.' icon-'.$icon.'"></i>'.$close_link;
	}

function euged_post_mini_meta()
	{
	echo '<div class="mini-meta-holder">';
	//echo '<div class="meta datetime">';
	//echo '<p><time datetime="'.get_the_time(get_option('date_format')).'" pubdate><span class="month">'.get_the_time('M').'</span><span class="day">'.get_the_time('j').'</span></time></p>';
	//echo '</div>';
	echo '<div class="meta postformat">';
	echo euged_post_format_icon(get_post_format());
	echo '</div>';
	echo '</div>';
	}

function euged_the_title($before = '', $after = '')
{
	global $global_admin_options;

	if(is_search())									$title = __('Search Results', 'euged' );
	elseif(is_category())							$title = get_post(get_option('page_for_posts'))->post_title;
	elseif(is_tag())								$title = get_post(get_option('page_for_posts'))->post_title;
	elseif(is_date())								$title = get_post(get_option('page_for_posts'))->post_title;
	elseif(is_author())								$title = __('Author Archive', 'euged' );
	elseif(is_home())								$title = get_post(get_option('page_for_posts'))->post_title;
	elseif(is_singular('post'))						$title = get_post(get_option('page_for_posts'))->post_title;
	elseif(is_tax('post_format'))					$title = get_post(get_option('page_for_posts'))->post_title;
	elseif(is_tax('portfolio_category'))			$title = get_post( $global_admin_options['portfolio_page_for_portfolio'] )->post_title;
	elseif(is_post_type_archive('portfolio'))		$title = get_post( $global_admin_options['portfolio_page_for_portfolio'] )->post_title;
	else											$title = get_the_title();

	return $before . $title . $after;
}

function euged_the_sub_title($before = '', $after = '')
{
	global $post, $author, $global_admin_options;

	if(is_search())								$sub_title = __('Results for the term','euged').' "'.get_search_query().'"';
	elseif(is_category())						$sub_title = __('Category Archive','euged').' - '.single_cat_title('',false);
	elseif(is_tag())							$sub_title = __('Tag Archive','euged').' - '.single_tag_title('',false);
	elseif(is_date())							$sub_title = __('Date Archive','euged').' - '.single_month_title(' ',false);
	elseif(is_author())							$sub_title = get_userdata($author)->display_name;
	elseif(is_home())							$sub_title = get_post_meta(get_option('page_for_posts'),'page_options_subtitle',true);
	elseif(is_singular('post'))					$sub_title = get_post_meta(get_option('page_for_posts'),'page_options_subtitle',true);
	elseif(is_tax('post_format'))				$sub_title = __('Post Format Archive','euged').' - '.single_term_title('',false);
	elseif(is_tax())							$sub_title = single_term_title('',false);
	elseif(is_post_type_archive('portfolio'))	$sub_title = get_post_meta($global_admin_options['portfolio_page_for_portfolio'],'page_options_subtitle',true);
	else										$sub_title = get_post_meta($post->ID, 'page_options_subtitle', true);

	if (!empty($sub_title))
	{
		return $before . $sub_title . $after;
	}
}

function euged_get_gallery_images_array()
{
	global $post;
	$shortcode_ids = $image_array = array();
	$pattern = get_shortcode_regex();

	if(preg_match_all('/'. $pattern .'/s', $post->post_content, $matches))
	{
		foreach($matches[3] as $key => $value)
		{
			$attributes = shortcode_parse_atts($value);
			if(isset($attributes['ids']))
			{
				$shortcode_ids = explode(',', $attributes['ids']);
				$image_array = array_merge($image_array, $shortcode_ids);
			}
		}
	}

	return $image_array;
}

function euged_strip_shortcode($code, $content)
{
	global $shortcode_tags;
	$stack = $shortcode_tags;
	$shortcode_tags = array($code => 1);
	$content = strip_shortcodes($content);
	$shortcode_tags = $stack;
	return $content;
}

function euged_strip_shortcodes($content)
{
	global $shortcode_tags;
	euged_filter_process_shortcodes('', true);
	$content = strip_shortcodes($content);
	return $content;
}

function euged_trim_content($text = '', $excerpt_length)
{
	$text = euged_strip_shortcodes( $text );
	$text = str_replace(']]>', ']]&gt;', $text);
	$excerpt_more = apply_filters('excerpt_more', ' ' . '[...]');
	$text = wp_trim_words( $text, $excerpt_length, $excerpt_more );
	$text = apply_filters('the_content', $text);
	return $text;
}