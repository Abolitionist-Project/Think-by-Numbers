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

//global $Euged;

/****************************************************
* Infobar
****************************************************/
$customizer_options['info_bar']['search'] = array(
	'control'	=> 'text',
	'default'	=> 'Search Quantimodo',
	'type'		=> 'option',
	'actions'	=> array(
		array(
			'selector'	=> '#infobar .search',
			'jquery'	=> 'html'
		)
	)
);
$customizer_options['info_bar']['show_search'] = array(
	'control'	=> 'checkbox',
	'default'	=> true,
	'transport'	=> 'refresh',
	'actions'	=> array(
		array(
			'selector'	=> '#infobar .search',
			'jquery'	=> 'toggle'
		)
	)
);