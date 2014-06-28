<?php
/**
 * Theme Customizer Config
 *
 * Format: $customizer_options[$section][$option] = array($arguements);
 *
 * @param string $section					Customizer section, i.e. Header
 * @param string $option					A unique slug-like ID for the theme setting
 *
 * Arguments:
 * @param string $control					Control ('text', 'checkbox', 'radio', 'select', 'image_upload', 'color_picker')
 * @param string $default					Default Value
 * @param string $transport		optional	WP Customizer transport method. Options are 'refresh' and 'postMessage' (default: 'postMessage')
 * @param string $selector		optional	Selector - ids and/or classes, comma separated
 * @param string $jquery		optional	jQuery action, i.e. 'toggle' or 'html'
 * @param string $type 			optional	TYPE of setting. Options are 'option' or 'theme_mod' (default: 'theme_mod')
 * @param string $label			optional	Option Label (default: option name with '_' replaced with ' ' and ucwords applied)
 * @param array  $options		optional	Options of a select or radio control
 * @param string $capability	optional	Capability a user must have to modify setting (default: 'edit_theme_options')
 *
 * More info on $arguements, $type and $capability can be found:
 * http://codex.wordpress.org/Class_Reference%5CWP_Customize_Manager%5Cadd_setting
 */

global $Euged;

/****************************************************
* Global
****************************************************/
$customizer_options['global']['site_width'] = array(
	'control'	=> 'select',
	'options'	=> $Euged->pixel_size_range(810,1300,30),
	'default'	=> '1020px',
	'actions'	=> array(
		array(
			'selector'	=> '#site.narrow, .band > .inner',
			'attribute'	=> 'max-width'
		)
	)
);
$customizer_options['global']['layout_style'] = array(
	'control'	=> 'select',
	'options'	=> array('wide' => 'Wide', 'narrow' => 'Narrow'),
	'default'	=> 'wide',
	'actions'	=> array(
		array(
			'selector'	=> '#site',
			'jquery'	=> 'class'
		)
	)
);
$customizer_options['global']['font_family'] = array(
	'control'	=> 'select',
	'options'	=> $Euged->parse_google_fonts(),
	'default'	=> 'Open Sans',
	'actions'	=> array(
		array(
			'selector'			=> 'body',
			'attribute'			=> 'font-family',
			'jquery'			=> 'font-family',
			'google_link_id'	=> '#google-body-font-css'
		)
	)
);
$customizer_options['global']['font_size'] = array(
	'control'	=> 'select',
	'options'	=> $Euged->pixel_size_range(),
	'default'	=> '13px',
	'actions'	=> array(
		array(
			'selector'	=> 'body',
			'attribute'	=> 'font-size'
		)
	)
);


/****************************************************
* Headings
****************************************************/
$customizer_options['headings']['font_family'] = array(
	'control'	=> 'select',
	'options'	=> $Euged->parse_google_fonts(),
	'default'	=> 'Raleway',
	'actions'	=> array(
		array(
			'selector'			=> 'h1, h2, h3, h4, h5, h6',
			'attribute'			=> 'font-family',
			'jquery'			=> 'font-family',
			'google_link_id'	=> '#google-headings-font-css'
		)
	)
);
$customizer_options['headings']['h1_font_size'] = array(
	'control'	=> 'select',
	'options'	=> $Euged->pixel_size_range(13,60),
	'default'	=> '40px',
	'actions'	=> array(
		array(
			'selector'	=> 'h1, .h1',
			'attribute'	=> 'font-size'
		)
	)
);
$customizer_options['headings']['h2_font_size'] = array(
	'control'	=> 'select',
	'options'	=> $Euged->pixel_size_range(13,60),
	'default'	=> '30px',
	'actions'	=> array(
		array(
			'selector'	=> 'h2, .h2',
			'attribute'	=> 'font-size'
		)
	)
);
$customizer_options['headings']['h3_font_size'] = array(
	'control'	=> 'select',
	'options'	=> $Euged->pixel_size_range(13,60),
	'default'	=> '20px',
	'actions'	=> array(
		array(
			'selector'	=> 'h3, .h3',
			'attribute'	=> 'font-size'
		)
	)
);
$customizer_options['headings']['h4_font_size'] = array(
	'control'	=> 'select',
	'options'	=> $Euged->pixel_size_range(13,60),
	'default'	=> '18px',
	'actions'	=> array(
		array(
			'selector'	=> 'h4, .h4',
			'attribute'	=> 'font-size'
		)
	)
);
$customizer_options['headings']['h5_font_size'] = array(
	'control'	=> 'select',
	'options'	=> $Euged->pixel_size_range(13,60),
	'default'	=> '16px',
	'actions'	=> array(
		array(
			'selector'	=> 'h5, .h5',
			'attribute'	=> 'font-size'
		)
	)
);
$customizer_options['headings']['h6_font_size'] = array(
	'control'	=> 'select',
	'options'	=> $Euged->pixel_size_range(13,60),
	'default'	=> '14px',
	'actions'	=> array(
		array(
			'selector'	=> 'h6, .h6',
			'attribute'	=> 'font-size'
		)
	)
);


/****************************************************
* Hellobar
****************************************************/

$customizer_options['hello_bar']['show_hello_bar']	= array(
	'control'	=> 'radio',
	'options'	=> array('true' => 'Show', 'false' => 'Hide'),
	'default'	=> 'true',
	'transport'	=> 'refresh',
	'actions'	=> array(
		array(
			'selector'	=> '#hellobar',
			'jquery'	=> 'toggle'
		)
	)
);
$customizer_options['hello_bar']['message'] = array(
	'control'	=> 'text',
	'default'	=> 'Welcome to Metrolium! You can set this message in WP Customizer in your admin panel',
	'type'		=> 'option',
	'actions'	=> array(
		array(
			'selector'	=> '#hellobar-message',
			'jquery'	=> 'html'
		)
	)
);
$customizer_options['hello_bar']['font_size'] = array(
	'control'	=> 'select',
	'options'	=> $Euged->pixel_size_range(),
	'default'	=> '12px',
	'actions'	=> array(
		array(
			'selector'	=> '#hellobar',
			'attribute'	=> 'font-size'
		)
	)
);
$customizer_options['hello_bar']['background_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#29BDCA',
	'actions'	=> array(
		array(
			'selector'	=> '#hellobar',
			'attribute'	=> 'background-color'
		)
	)
);
$customizer_options['hello_bar']['text_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#FFF',
	'actions'	=> array(
		array(
			'selector'	=> '#hellobar',
			'attribute'	=> 'color'
		)
	)
);
$customizer_options['hello_bar']['link_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#1c818a',
	'actions'	=> array(
		array(
			'selector'	=> '#hellobar a',
			'attribute'	=> 'color'
		)
	)
);
$customizer_options['hello_bar']['link_hover_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#0f464b',
	'actions'	=> array(
		array(
			'selector'	=> '#hellobar a:hover',
			'attribute'	=> 'color'
		)
	)
);


/****************************************************
* Infobar
****************************************************/

$customizer_options['info_bar']['email'] = array(
	'control'	=> 'text',
	'default'	=> 'set.your@email.address',
	'type'		=> 'option',
	'actions'	=> array(
		array(
			'selector'	=> '#infobar .email a',
			'jquery'	=> 'html'
		)
	)
);
$customizer_options['info_bar']['show_email'] = array(
	'control'	=> 'checkbox',
	'default'	=> true,
	'transport'	=> 'refresh',
	'actions'	=> array(
		array(
			'selector'	=> '#infobar .email',
			'jquery'	=> 'toggle'
		)
	)
);
$customizer_options['info_bar']['telephone'] = array(
	'control'	=> 'text',
	'default'	=> '01234 567890',
	'type'		=> 'option',
	'actions'	=> array(
		array(
			'selector'	=> '#infobar .telephone',
			'jquery'	=> 'html'
		)
	)
);
$customizer_options['info_bar']['show_telephone'] = array(
	'control'	=> 'checkbox',
	'default'	=> true,
	'transport'	=> 'refresh',
	'actions'	=> array(
		array(
			'selector'	=> '#infobar .telephone',
			'jquery'	=> 'toggle'
		)
	)
);
$customizer_options['info_bar']['show_socials'] = array(
	'control'	=> 'radio',
	'options'	=> array('true' => 'Show', 'false' => 'Hide'),
	'default'	=> 'true',
	'transport'	=> 'refresh',
	'actions'	=> array(
		array(
			'selector'	=> '#infobar .social',
			'jquery'	=> 'toggle'
		)
	)
);
$customizer_options['info_bar']['font_size'] = array(
	'control'	=> 'select',
	'options'	=> $Euged->pixel_size_range(10,13),
	'default'	=> '12px',
	'actions'	=> array(
		array(
			'selector'	=> '#infobar',
			'attribute'	=> 'font-size'
		)
	)
);
$customizer_options['info_bar']['background_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#F2F2F2',
	'actions'	=> array(
		array(
			'selector'	=> '#infobar',
			'attribute'	=> 'background-color'
		)
	)
);
$customizer_options['info_bar']['text_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#808080',
	'actions'	=> array(
		array(
			'selector'	=> '#infobar',
			'attribute'	=> 'color'
		)
	)
);
$customizer_options['info_bar']['link_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#29bdca',
	'actions'	=> array(
		array(
			'selector'	=> '#infobar a',
			'attribute'	=> 'color'
		)
	)
);
$customizer_options['info_bar']['link_hover_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#2095a0',
	'actions'	=> array(
		array(
			'selector'	=> '#infobar a:hover',
			'attribute'	=> 'color'
		)
	)
);
$customizer_options['info_bar']['social_icon_background_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#e5e5e5',
	'actions'	=> array(
		array(
			'selector'	=> '#infobar .social-icon',
			'attribute'	=> 'background-color'
		),
		array(
			'selector'	=> '#infobar .misc-icon',
			'attribute'	=> 'background-color'
		)
	)
);
$customizer_options['info_bar']['social_icon_text_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#808080',
	'actions'	=> array(
		array(
			'selector'	=> '#infobar .social-icon',
			'attribute'	=> 'color'
		),
		array(
			'selector'	=> '#infobar .misc-icon',
			'attribute'	=> 'color'
		)
	)
);


/****************************************************
* Header
****************************************************/

$customizer_options['header']['logo'] = array(
	'control' => 'image_upload',
	'default' => get_template_directory_uri() . '/assets/images/banner_logo.png', 'theme_mod'
);

$customizer_options['header']['background_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#FFF',
	'actions'	=> array(
		array(
			'selector'	=> '#banner',
			'attribute'	=> 'background-color'
		)
	)
);

$customizer_options['header']['header_style'] = array(
	'control'	=> 'select',
	'options'	=> array('header-v1' => 'Style 1', 'header-v2' => 'Style 2', 'header-v3' => 'Style 3'),
	'default'	=> 'header-v1',
	'transport'	=> 'refresh'
);
$customizer_options['header']['style_2_content'] = array(
	'control'	=> 'textarea',
	'default'	=> '',
	'type'		=> 'option',
	'actions'	=> array(
		array(
			'selector'	=> '#header-v2-content',
			'jquery'	=> 'html'
		)
	)
);
$customizer_options['header']['text_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#808080',
	'actions'	=> array(
		array(
			'selector'	=> '#banner',
			'attribute'	=> 'color'
		)
	)
);
$customizer_options['header']['link_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#29bdca',
	'actions'	=> array(
		array(
			'selector'	=> '#banner a',
			'attribute'	=> 'color'
		)
	)
);
$customizer_options['header']['link_hover_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#2095a0',
	'actions'	=> array(
		array(
			'selector'	=> '#banner a:hover',
			'attribute'	=> 'color'
		)
	)
);


/****************************************************
* Primary Navigation
****************************************************/

$customizer_options['primary_navigation']['font_size'] = array(
	'control'	=> 'select',
	'options'	=> $Euged->pixel_size_range(),
	'default'	=> '13px',
	'actions'	=> array(
		array(
			'selector'	=> 'nav.primary #primary-navigation',
			'attribute'	=> 'font-size'
		)
	)
);
$customizer_options['primary_navigation']['background_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#FFF',
	'actions'	=> array(
		array(
			'selector'	=> '#navigation',
			'attribute'	=> 'background-color'
		)
	)
);
$customizer_options['primary_navigation']['link_background_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#f2f2f2',
	'actions'	=> array(
		array(
			'selector'	=> 'nav.primary #primary-navigation ul li a',
			'attribute'	=> 'background-color'
		),
		array(
			'selector'	=> 'nav.primary #toggle',
			'attribute'	=> 'background-color'
		)
	)
);
$customizer_options['primary_navigation']['link_text_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#808080',
	'actions'	=> array(
		array(
			'selector'	=> 'nav.primary #primary-navigation ul li a',
			'attribute'	=> 'color'
		),
		array(
			'selector'	=> 'nav.primary #toggle',
			'attribute'	=> 'color'
		),
		array(
			'selector'	=> 'nav.primary #toggle i',
			'attribute'	=> 'color'
		)
	)
);
$customizer_options['primary_navigation']['link_background_hover_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#29BDCA',
	'actions'	=> array(
		array(
			'selector'	=> 'nav.primary #primary-navigation ul li:hover > a',
			'attribute'	=> 'background-color'
		),
		array(
			'selector'	=> 'nav.primary #toggle:hover',
			'attribute'	=> 'background-color'
		)
	)
);
$customizer_options['primary_navigation']['link_text_hover_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#FFF',
	'actions'	=> array(
		array(
			'selector'	=> 'nav.primary #primary-navigation ul li:hover > a',
			'attribute'	=> 'color'
		),
		array(
			'selector'	=> 'nav.primary #toggle:hover',
			'attribute'	=> 'color'
		),
		array(
			'selector'	=> 'nav.primary #toggle:hover i',
			'attribute'	=> 'color'
		)
	)
);
$customizer_options['primary_navigation']['sub_link_background_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#29BDCA',
	'actions'	=> array(
		array(
			'selector'	=> 'nav.primary #primary-navigation ul li ul.sub-menu,nav.primary #primary-navigation ul li ul.sub-menu li a',
			'attribute'	=> 'background-color'
		)
	)
);
$customizer_options['primary_navigation']['sub_link_text_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#FFF',
	'actions'	=> array(
		array(
			'selector'	=> 'nav.primary #primary-navigation ul li ul.sub-menu li a',
			'attribute'	=> 'color'
		)
	)
);
$customizer_options['primary_navigation']['sub_link_background_hover_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#2095A0',
	'actions'	=> array(
		array(
			'selector'	=> 'nav.primary #primary-navigation ul li ul.sub-menu li:hover > a',
			'attribute'	=> 'background-color'
		)
	)
);
$customizer_options['primary_navigation']['sub_link_text_hover_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#FFF',
	'actions'	=> array(
		array(
			'selector'	=> 'nav.primary #primary-navigation ul li ul.sub-menu li:hover > a',
			'attribute'	=> 'color'
		)
	)
);


/****************************************************
* Mobile Navigation
****************************************************/

$customizer_options['mobile_navigation']['background_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#333',
	'actions'	=> array(
		array(
			'selector'	=> '#mobile-menu',
			'attribute'	=> 'background-color'
		)
	)
);
$customizer_options['mobile_navigation']['link_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#29bdca',
	'actions'	=> array(
		array(
			'selector'	=> '#mobile-menu a',
			'attribute'	=> 'color'
		)
	)
);


/****************************************************
* Breadcrumbs
****************************************************/
$customizer_options['breadcrumbs']['font_size'] = array(
	'control'	=> 'select',
	'options'	=> $Euged->pixel_size_range(),
	'default'	=> '11px',
	'actions'	=> array(
		array(
			'selector'	=> '#breadcrumbs',
			'attribute'	=> 'font-size'
		)
	)
);
$customizer_options['breadcrumbs']['background_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#2095a0',
	'actions'	=> array(
		array(
			'selector'	=> '#breadcrumbs',
			'attribute'	=> 'background-color'
		)
	)
);
$customizer_options['breadcrumbs']['text_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#a0e6ec',
	'actions'	=> array(
		array(
			'selector'	=> '#breadcrumbs',
			'attribute'	=> 'color'
		)
	)
);
$customizer_options['breadcrumbs']['separator_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#0f464b',
	'actions'	=> array(
		array(
			'selector'	=> '#breadcrumbs .separator',
			'attribute'	=> 'color'
		)
	)
);
$customizer_options['breadcrumbs']['link_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#FFF',
	'actions'	=> array(
		array(
			'selector'	=> '#breadcrumbs a',
			'attribute'	=> 'color'
		)
	)
);
$customizer_options['breadcrumbs']['link_hover_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#a0e6ec',
	'actions'	=> array(
		array(
			'selector'	=> '#breadcrumbs a:hover',
			'attribute'	=> 'color'
		)
	)
);


/****************************************************
* Titlebar
****************************************************/

$customizer_options['title_bar']['background_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#29BDCA',
	'actions'	=> array(
		array(
			'selector'	=> '#titlebar',
			'attribute'	=> 'background-color'
		)
	)
);
$customizer_options['title_bar']['main_heading_font_size'] = array(
	'control'	=> 'select',
	'options'	=> $Euged->pixel_size_range(13,36),
	'default'	=> '30px',
	'actions'	=> array(
		array(
			'selector'	=> '#titlebar .main-heading',
			'attribute'	=> 'font-size'
		)
	)
);
$customizer_options['title_bar']['main_heading_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#FFF',
	'actions'	=> array(
		array(
			'selector'	=> '#titlebar .main-heading',
			'attribute'	=> 'color'
		)
	)
);
$customizer_options['title_bar']['sub_heading_font_size'] = array(
	'control'	=> 'select',
	'options'	=> $Euged->pixel_size_range(13,36),
	'default'	=> '16px',
	'actions'	=> array(
		array(
			'selector'	=> '#titlebar .sub-heading',
			'attribute'	=> 'font-size'
		)
	)
);
$customizer_options['title_bar']['sub_heading_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#cbf1f4',
	'actions'	=> array(
		array(
			'selector'	=> '#titlebar .sub-heading',
			'attribute'	=> 'color'
		)
	)
);
$customizer_options['title_bar']['link_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#177c85',
	'actions'	=> array(
		array(
			'selector'	=> '#titlebar a',
			'attribute'	=> 'color'
		),
		array(
			'selector'	=> '#titlebar .button',
			'attribute'	=> 'background-color'
		)
	)
);
$customizer_options['title_bar']['link_hover_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#0c6067',
	'actions'	=> array(
		array(
			'selector'	=> '#titlebar a:hover',
			'attribute'	=> 'color'
		),
		array(
			'selector'	=> '#titlebar .button:hover',
			'attribute'	=> 'background-color'
		)
	)
);


/****************************************************
* Band
****************************************************/
$bands = array(
	'default_band' => array(
		'selector' => '#content .band.default',
		'defaults' => array(
			'text_color' => '#808080',
			'background_color' => '#FFF',
			'border_color' => '#EEE',
			'link_color' => '#29bdca',
			'link_hover_color' => '#2095a0',
			'input_background_color' => '#f2f2f2',
			'heading_color' => '#404040',
			'detail_text_color' => '#808080',
			'detail_background_color' => '#f2f2f2',
			'detail_border_color' => '#DDD',
			'detail_link_color' => '#29bdca',
			'detail_link_hover_color' => '#2095a0',
			'detail_input_background_color' => '#f2f2f2',
			'detail_heading_color' => '#404040'
		)
	),
	'alternative_band' => array(
		'selector' => '#content .band.alternative',
		'defaults' => array(
			'text_color' => '#808080',
			'background_color' => '#f2f2f2',
			'border_color' => '#DDD',
			'link_color' => '#29bdca',
			'link_hover_color' => '#2095a0',
			'input_background_color' => '#FFF',
			'heading_color' => '#404040',
			'detail_text_color' => '#808080',
			'detail_background_color' => '#FFF',
			'detail_border_color' => '#EEE',
			'detail_link_color' => '#29bdca',
			'detail_link_hover_color' => '#2095a0',
			'detail_input_background_color' => '#FFF',
			'detail_heading_color' => '#404040'
		)
	),
	'footer' => array(
		'selector' => '#footer',
		'defaults' => array(
			'text_color' => '#999',
			'background_color' => '#444',
			'border_color' => '#333',
			'link_color' => '#bfbfbf',
			'link_hover_color' => '#d9d9d9',
			'input_background_color' => '#FFF',
			'heading_color' => '#FFF',
			'detail_text_color' => '#999',
			'detail_background_color' => '#333',
			'detail_border_color' => '#333',
			'detail_link_color' => '#bfbfbf',
			'detail_link_hover_color' => '#d9d9d9',
			'detail_input_background_color' => '#FFF',
			'detail_heading_color' => '#FFF'
		)
	)
);

$areas = array('','detail');

foreach ( $bands as $name => $options )
{
	$selector = $options['selector'];
	$default = $options['defaults'];

	foreach ( $areas as $area )
	{
		if(!empty($area))
		{
			$selector = $selector.' .'.$area;
			$area_prefix = $area.'_';
		}
		else
		{
			$area_prefix = '';
		}

		if($name == 'footer')
		{
			$customizer_options[$name]['show_footer'] = array(
				'control'	=> 'radio',
				'options'	=> array('true' => 'Show', 'false' => 'Hide'),
				'default'	=> 'true',
				'transport'	=> 'refresh',
				'actions'	=> array(
					array(
						'selector'	=> '#footer',
						'jquery'	=> 'toggle'
					)
				)
			);
		}


		$customizer_options[$name][$area_prefix.'text_color'] = array(
			'control'	=> 'color_picker',
			'default'	=> $default[$area_prefix.'text_color'],
			'actions'	=> array(
				array(
					'selector'	=> $selector,
					'attribute'	=> 'color'
				),
				array(
					'selector'	=> $selector.' ul.tags li',
					'attribute'	=> 'background-color'
				)
			)
		);

		$customizer_options[$name][$area_prefix.'background_color'] = array(
			'control'	=> 'color_picker',
			'default'	=> $default[$area_prefix.'background_color'],
			'actions'	=> array(
				array(
					'selector'	=> $selector,
					'attribute'	=> 'background-color'
				),
				array(
					'selector'	=> $selector.' ul.tags li:before',
					'attribute'	=> 'background-color'
				),
				array(
					'selector'	=> $selector.' .hr.icon i',
					'attribute'	=> 'background-color'
				),
				array(
					'selector'	=> $selector.' ul.tags li',
					'attribute'	=> 'color'
				),
				array(
					'selector'	=> $selector.' ul.tags li a',
					'attribute'	=> 'color'
				),
				array(
					'selector'	=> $selector.' .hr.icon i',
					'attribute'	=> 'background-color'
				)
			)
		);

		$customizer_options[$name][$area_prefix.'border_color'] = array(
			'control'	=> 'color_picker',
			'default'	=> $default[$area_prefix.'border_color'],
			'actions'	=> array(
				array(
					'selector'	=> $selector.' hr',
					'attribute'	=> 'border-color'
				),
				array(
					'selector'	=> $selector.' .hr',
					'attribute'	=> 'border-color'
				),
				array(
					'selector'	=> $selector.' .hr.icon i',
					'attribute'	=> 'color'
				),
				array(
					'selector'	=> $selector.' article.post.archive',
					'attribute'	=> 'border-color'
				),
				array(
					'selector'	=> $selector.' #sidebar .widget',
					'attribute'	=> 'border-color'
				),
				array(
					'selector'	=> $selector.' table td',
					'attribute'	=> 'border-color'
				),
				array(
					'selector'	=> $selector.' table th',
					'attribute'	=> 'border-color'
				),
				array(
					'selector'	=> $selector.' dl.tabular dd',
					'attribute'	=> 'border-color'
				)
			)
		);

		$customizer_options[$name][$area_prefix.'link_color'] = array(
			'control'	=> 'color_picker',
			'default'	=> $default[$area_prefix.'link_color'],
			'actions'	=> array(
				array(
					'selector'	=> $selector.' a',
					'attribute'	=> 'color'
				),
				array(
					'selector'	=> $selector.' button',
					'attribute'	=> 'background-color'
				),
				array(
					'selector'	=> $selector.' a.button',
					'attribute'	=> 'background-color'
				),
				array(
					'selector'	=> $selector.' input[type="reset"]',
					'attribute'	=> 'background-color'
				),
				array(
					'selector'	=> $selector.' input[type="submit"]',
					'attribute'	=> 'background-color'
				),
				array(
					'selector'	=> $selector.' input[type="button"]',
					'attribute'	=> 'background-color'
				),
				array(
					'selector'	=> $selector.' form label .required',
					'attribute'	=> 'color'
				),
				array(
					'selector'	=> $selector.' .callout-icon',
					'attribute'	=> 'background-color'
				),
				array(
					'selector'	=> $selector.' .pagination.archive a .icon',
					'attribute'	=> 'background-color'
				),
			)
		);

		$customizer_options[$name][$area_prefix.'link_hover_color'] = array(
			'control'	=> 'color_picker',
			'default'	=> $default[$area_prefix.'link_hover_color'],
			'actions'	=> array(
				array(
					'selector'	=> $selector.' a:hover',
					'attribute'	=> 'color'
				),
				array(
					'selector'	=> $selector.' button:hover',
					'attribute'	=> 'background-color'
				),
				array(
					'selector'	=> $selector.' a.button:hover',
					'attribute'	=> 'background-color'
				),
				array(
					'selector'	=> $selector.' input[type="reset"]:hover',
					'attribute'	=> 'background-color'
				),
				array(
					'selector'	=> $selector.' input[type="submit"]:hover',
					'attribute'	=> 'background-color'
				),
				array(
					'selector'	=> $selector.' input[type="button"]:hover',
					'attribute'	=> 'background-color'
				),
				array(
					'selector'	=> $selector.' .pagination.archive a:hover .icon',
					'attribute'	=> 'background-color'
				)
			)
		);

		$customizer_options[$name][$area_prefix.'input_background_color'] = array(
			'control'	=> 'color_picker',
			'default'	=> $default[$area_prefix.'input_background_color'],
			'actions'	=> array(
				array(
					'selector'	=> $selector.' textarea',
					'attribute'	=> 'background-color'
				),
				array(
					'selector'	=> $selector.' select',
					'attribute'	=> 'background-color'
				),
				array(
					'selector'	=> $selector.' input',
					'attribute'	=> 'background-color'
				)
			)
		);

		$customizer_options[$name][$area_prefix.'heading_color'] = array(
			'control'	=> 'color_picker',
			'default'	=> $default[$area_prefix.'heading_color'],
			'actions'	=> array(
				array(
					'selector'	=> $selector.' h1',
					'attribute'	=> 'color'
				),
				array(
					'selector'	=> $selector.' .h1',
					'attribute'	=> 'color'
				),
				array(
					'selector'	=> $selector.' h2',
					'attribute'	=> 'color'
				),
				array(
					'selector'	=> $selector.' .h2',
					'attribute'	=> 'color'
				),
				array(
					'selector'	=> $selector.' h3',
					'attribute'	=> 'color'
				),
				array(
					'selector'	=> $selector.' .h3',
					'attribute'	=> 'color'
				),
				array(
					'selector'	=> $selector.' h4',
					'attribute'	=> 'color'
				),
				array(
					'selector'	=> $selector.' .h4',
					'attribute'	=> 'color'
				),
				array(
					'selector'	=> $selector.' h5',
					'attribute'	=> 'color'
				),
				array(
					'selector'	=> $selector.' .h5',
					'attribute'	=> 'color'
				),
				array(
					'selector'	=> $selector.' h6',
					'attribute'	=> 'color'
				),
				array(
					'selector'	=> $selector.' .h6',
					'attribute'	=> 'color'
				),
				array(
					'selector'	=> $selector.' dl.tabular dt',
					'attribute'	=> 'color'
				)
			)
		);
	}
}


/****************************************************
* Site Wide CTA
****************************************************/

$customizer_options['site_wide_cta']['show_site_wide_cta']	= array(
	'control'	=> 'radio',
	'options'	=> array('true' => 'Show', 'false' => 'Hide'),
	'default'	=> 'true',
	'transport'	=> 'refresh',
	'actions'	=> array(
		array(
			'selector'	=> '#site-wide-cta',
			'jquery'	=> 'toggle'
		)
	)
);
$customizer_options['site_wide_cta']['message'] = array(
	'control'	=> 'text',
	'default'	=> 'A site wide Call to Action band! Have you fallen in love yet? <a href="#" class="button large">BUY THIS THEME!</a>',
	'type'		=> 'option',
	'actions'	=> array(
		array(
			'selector'	=> '#site-wide-cta-message',
			'jquery'	=> 'html'
		)
	)
);
$customizer_options['site_wide_cta']['font_size'] = array(
	'control'	=> 'select',
	'options'	=> $Euged->pixel_size_range(),
	'default'	=> '18px',
	'actions'	=> array(
		array(
			'selector'	=> '#site-wide-cta',
			'attribute'	=> 'font-size'
		)
	)
);
$customizer_options['site_wide_cta']['background_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#a0e6ec',
	'actions'	=> array(
		array(
			'selector'	=> '#site-wide-cta',
			'attribute'	=> 'background-color'
		)
	)
);
$customizer_options['site_wide_cta']['text_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#1c818a',
	'actions'	=> array(
		array(
			'selector'	=> '#site-wide-cta',
			'attribute'	=> 'color'
		)
	)
);
$customizer_options['site_wide_cta']['link_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#29bdca',
	'actions'	=> array(
		array(
			'selector'	=> '#site-wide-cta a',
			'attribute'	=> 'color'
		),
		array(
			'selector'	=> '#site-wide-cta a.button',
			'attribute'	=> 'background-color'
		)
	)
);
$customizer_options['site_wide_cta']['link_hover_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#25a9b5',
	'actions'	=> array(
		array(
			'selector'	=> '#site-wide-cta a:hover',
			'attribute'	=> 'color'
		),
		array(
			'selector'	=> '#site-wide-cta a.button:hover',
			'attribute'	=> 'background-color'
		)
	)
);


/****************************************************
* Pre Footer
****************************************************/
$customizer_options['pre_footer']['show_pre_footer'] = array(
	'control'	=> 'radio',
	'options'	=> array('true' => 'Show', 'false' => 'Hide'),
	'default'	=> 'true',
	'transport'	=> 'refresh',
	'actions'	=> array(
		array(
			'selector'	=> '#prefooter',
			'jquery'	=> 'toggle'
		)
	)
);
$customizer_options['pre_footer']['background_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#29bdca',
	'actions'	=> array(
		array(
			'selector'	=> '#prefooter',
			'attribute'	=> 'background-color'
		)
	)
);
$customizer_options['pre_footer']['font_size'] = array(
	'control'	=> 'select',
	'options'	=> $Euged->pixel_size_range(11,40),
	'default'	=> '25px',
	'actions'	=> array(
		array(
			'selector'	=> '#prefooter h2',
			'attribute'	=> 'font-size'
		)
	)
);
$customizer_options['pre_footer']['text_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#FFF',
	'actions'	=> array(
		array(
			'selector'	=> '#prefooter h2',
			'attribute'	=> 'color'
		)
	)
);
$customizer_options['pre_footer']['social_icon_text_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#FFF',
	'actions'	=> array(
		array(
			'selector'	=> '#prefooter .social-icon',
			'attribute'	=> 'color'
		)
	)
);
$customizer_options['pre_footer']['social_icon_background_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#2095a0',
	'actions'	=> array(
		array(
			'selector'	=> '#prefooter .social-icon',
			'attribute'	=> 'background-color'
		)
	)
);


/****************************************************
* Trim
****************************************************/
$customizer_options['trim']['copyright'] = array(
	'control'	=> 'text',
	'default'	=> '',
	'type'		=> 'option',
	'actions'	=> array(
		array(
			'selector'	=> '#trim-copyright',
			'jquery'	=> 'html'
		)
	)
);
$customizer_options['trim']['font_size'] = array(
	'control'	=> 'select',
	'options'	=> $Euged->pixel_size_range(),
	'default'	=> '11px',
	'actions'	=> array(
		array(
			'selector'	=> '#trim',
			'attribute'	=> 'font-size'
		)
	)
);
$customizer_options['trim']['background_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#333',
	'actions'	=> array(
		array(
			'selector'	=> '#trim',
			'attribute'	=> 'background-color'
		)
	)
);
$customizer_options['trim']['text_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#888',
	'actions'	=> array(
		array(
			'selector'	=> '#trim',
			'attribute'	=> 'color'
		)
	)
);
$customizer_options['trim']['link_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#d6d6d6',
	'actions'	=> array(
		array(
			'selector'	=> '#trim a',
			'attribute'	=> 'color'
		)
	)
);
$customizer_options['trim']['link_hover_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#fff',
	'actions'	=> array(
		array(
			'selector'	=> '#trim a:hover',
			'attribute'	=> 'color'
		)
	)
);


/****************************************************
* Blog
****************************************************/
$customizer_options['blog']['header_background_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#f2f2f2',
	'actions'	=> array(
		array(
			'selector'	=> '#content article.post header',
			'attribute'	=> 'background-color'
		)
	)
);
$customizer_options['blog']['header_text_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#808080',
	'actions'	=> array(
		array(
			'selector'	=> '#content article.post header',
			'attribute'	=> 'color'
		)
	)
);
$customizer_options['blog']['header_link_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#29bdca',
	'actions'	=> array(
		array(
			'selector'	=> '#content article.post header a',
			'attribute'	=> 'color'
		)
	)
);
$customizer_options['blog']['header_link_hover_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#2095a0',
	'actions'	=> array(
		array(
			'selector'	=> '#content article.post header a:hover',
			'attribute'	=> 'color'
		)
	)
);
$customizer_options['blog']['meta_bar_background_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#f2f2f2',
	'actions'	=> array(
		array(
			'selector'	=> '#content article.post .meta',
			'attribute'	=> 'background-color'
		),
		array(
			'selector'	=> '#content article.post .meta.tags a',
			'attribute'	=> 'color'
		),
		array(
			'selector'	=> '#content article.post .meta.tags a:before',
			'attribute'	=> 'background-color'
		)
	)
);
$customizer_options['blog']['meta_bar_text_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#808080',
	'actions'	=> array(
		array(
			'selector'	=> '#content article.post .meta',
			'attribute'	=> 'color'
		),
		array(
			'selector'	=> '#content article.post .meta h3',
			'attribute'	=> 'color'
		),
		array(
			'selector'	=> '#content article.post .meta.tags a',
			'attribute'	=> 'background-color'
		)
	)
);
$customizer_options['blog']['meta_icon_background_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#e6e6e6',
	'actions'	=> array(
		array(
			'selector'	=> '#content article.post .meta .icon',
			'attribute'	=> 'background-color'
		)
	)
);
$customizer_options['blog']['meta_icon_text_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#808080',
	'actions'	=> array(
		array(
			'selector'	=> '#content article.post .meta .icon',
			'attribute'	=> 'color'
		)
	)
);
$customizer_options['blog']['meta_link_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#29bdca',
	'actions'	=> array(
		array(
			'selector'	=> '#content article.post .meta a',
			'attribute'	=> 'color'
		),
		array(
			'selector'	=> '#content article.post .meta a.button',
			'attribute'	=> 'background-color'
		)
	)
);
$customizer_options['blog']['meta_link_hover_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#2095a0',
	'actions'	=> array(
		array(
			'selector'	=> '#content article.post .meta a:hover',
			'attribute'	=> 'color'
		),
		array(
			'selector'	=> '#content article.post .meta a.button:hover',
			'attribute'	=> 'background-color'
		)
	)
);


/****************************************************
* Portfolio
****************************************************/
$customizer_options['portfolio_filter']['background_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#f2f2f2',
	'actions'	=> array(
		array(
			'selector'	=> '#content .band nav.filter',
			'attribute'	=> 'background-color'
		)
	)
);
$customizer_options['portfolio_filter']['button_background_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#f2f2f2',
	'actions'	=> array(
		array(
			'selector'	=> '#content .band nav.filter ul li a',
			'attribute'	=> 'background-color'
		)
	)
);
$customizer_options['portfolio_filter']['button_text_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#888',
	'actions'	=> array(
		array(
			'selector'	=> '#content .band nav.filter ul li a',
			'attribute'	=> 'color'
		)
	)
);
$customizer_options['portfolio_filter']['button_background_hover_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#29bdca',
	'actions'	=> array(
		array(
			'selector'	=> '#content .band nav.filter ul li a:hover,#content .band nav.filter ul li.selected a',
			'attribute'	=> 'background-color'
		)
	)
);
$customizer_options['portfolio_filter']['button_text_hover_color'] = array(
	'control'	=> 'color_picker',
	'default'	=> '#FFF',
	'actions'	=> array(
		array(
			'selector'	=> '#content .band nav.filter ul li a:hover,#content .band nav.filter ul li.selected a',
			'attribute'	=> 'color'
		)
	)
);