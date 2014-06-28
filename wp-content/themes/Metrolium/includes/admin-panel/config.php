<?php
/**
 * Admin Panel Config
 *
 * Format: $theme_options[$section][$option] = array($arguements);
 *
 * @param string $section					Customizer section, i.e. Header
 * @param string $option					A unique slug-like ID for the theme setting
 *
 * Arguments:
 * @param string $control					Control ('text', 'textarea', 'checkbox', 'radio', 'select', 'image_upload', 'color_picker')
 * @param string $default					Default Value
 * @param string $label			optional	Option Label (default: option name with '_' replaced with ' ' and ucwords applied)
 * @param array  $options		optional	Options of a select or radio control
 * @param string $capability	optional	Capability a user must have to modify setting (default: 'edit_theme_options')
 *
 * More info on $arguements, $type and $capability can be found:
 * http://codex.wordpress.org/Class_Reference%5CWP_Customize_Manager%5Cadd_setting
 */

global $Euged;

/****************************************************
* Welcome											*
****************************************************/
$theme_options['welcome']['html'] = array(
	'control'	=> 'html',
	'content'	=> "<h1>Welcome to Metrolium</h1><p>We won't keep you long with this intro, we just wanted to say a quick thank you for purchasing Metrolium, we really appreciate your business and your support!</p><p>You might be wondering why there's not many options here, that's because the majority of your customizing will be done in the <a href=\"/wp-admin/customize.php\">WP Customizer</a>, a new feature introduced in WordPress 3.5 that allows you to change the look and feel of your theme with a real time preview, providing that your theme supports it of course because not all do but don't worry, you've made a good choice in Metrolium because ours does and quite frankly, our theme rocks, even if we do say so ourselves! ;)</p><p>Below there's a little checkbox that once ticked will make this 'Welcome' tab never show again (unless you click 'reset options' in the bottom left), so for future reference of accessing the <a href=\"/wp-admin/customize.php\">WP Customizer</a>, you'll find it by going to 'Appearance > Themes' and clicking the 'Customize' link next to your active Metrolium theme.</p>"
);
$theme_options['welcome']['hide'] = array(
	'control'	=> 'checkbox',
	'label'		=> 'Hide \'Welcome\' tab?',
	'value'		=> 'true',
	'default'	=> false
);

/****************************************************
* Global											*
****************************************************/
$theme_options['global']['sticky_header'] = array(
	'control'	=> 'select',
	'options'	=> array('off' => 'Disabled', 'on' => 'Enabled'),
	'default'	=> 'off'
);
$theme_options['global']['custom_css'] = array(
	'control'	=> 'textarea',
	'rows'		=> '10'
);
$theme_options['global']['footer_columns'] = array(
	'control'	=> 'select',
	'options'	=> array('1' => 'One','2' => 'Two','3' => 'Three','4' => 'Four'),
	'default'	=> '3'
);
$theme_options['global']['google_font_subset'] = array(
	'control'	=> 'text'
);


/****************************************************
* Sidebars
****************************************************/
$theme_options['sidebars'] = array(
	'default'	=> array( 'blog-sidebar', 'page-sidebar' )
);


/****************************************************
* Blog
****************************************************/
$theme_options['blog']['archive_layout'] = array(
	'control'	=> 'select',
	'options'	=> array('traditional' => 'Traditional', 'masonry' => 'Masonry'),
	'default'	=> 'traditional'
);
$theme_options['blog']['show_author'] = array(
	'control'	=> 'select',
	'options'	=> array('true' => 'Show', 'false' => 'Hide'),
	'default'	=> 'show'
);
$theme_options['blog']['show_category'] = array(
	'control'	=> 'select',
	'options'	=> array('true' => 'Show', 'false' => 'Hide'),
	'default'	=> 'show'
);
$theme_options['blog']['show_tags'] = array(
	'control'	=> 'select',
	'options'	=> array('true' => 'Show', 'false' => 'Hide'),
	'default'	=> 'show'
);

/****************************************************
* Portfolio
****************************************************/
$pages = array();
foreach( get_posts(array('post_type' => 'page', 'numberposts' => -1)) as $page ) $pages[$page->ID] = $page->post_title;

$theme_options['portfolio']['page_for_portfolio'] = array(
	'control'	=> 'select',
	'options'	=> $pages
);
$theme_options['portfolio']['number_of_columns'] = array(
	'control'	=> 'select',
	'options'	=> array('1c' => 'One','2c' => 'Two','3c' => 'Three','4c' => 'Four','5c' => 'Five'),
	'default'	=> '3c'
);
$theme_options['portfolio']['archive_layout'] = array(
	'control'	=> 'select',
	'options'	=> array('fitRows' => 'Rows','masonry' => 'Masonry'),
	'default'	=> 'fitRows'
);
$theme_options['portfolio']['enable_lightbox'] = array(
	'control'	=> 'select',
	'options'	=> array('true' => 'On','false' => 'Off'),
	'default'	=> 'true'
);


/****************************************************
* Help											*
****************************************************/
$theme_options['help']['html'] = array(
	'control'	=> 'html',
	'content'	=> "<h1>Metrolium Support</h1><p>We appreciate you supporting us by purchasing our theme and we'd like to provide you with the same courtesy. If you're having trouble getting to grips with using Metrolium, we're here to help.</p><p>Metrolium comes with detailed documentation but if you can't find the answer you're looking for then please register on our support forums, there are already hundreds of registered users and a wealth of information from previously answered questions.</p><p>If you still can't find the answer after checking the documentation and searching the forum, please feel free to make a post on the forum and resist the urge to send support requests via email, our contact form or ThemeForest profile page as they will only be redirected to the forum.</p><p>The forum is provided to help you find the answers to your questions and get the help that you need via an archive of useful and relevant information to the theme that you've purchased and by providing a platform where you and other users of Metrolium can connect and maybe even help each other along the way. It also helps us because it's much easier to have conversations with you, to track requests and provide you with support much faster so we'd really appreciate your cooperation in our support process, thank you.</p><div id=\"help-buttons\" class=\"clearfix\"><a href=\"http://www.euged.com/documentation/metrolium\" target=\"_blank\" class=\"euged-documentation\"><i class=\"icon-book\"></i>Documentation</a><a href=\"http://www.euged.com/support\" target=\"_blank\"><i class=\"icon-comments\"></i>Support Forums</a></div>"
);