<?php
require_once('class-tgm-plugin-activation.php');

function euged_included_plugins() {

	$plugins = array(
		array(
			'name'     				=> 'LayerSlider',
			'slug'     				=> 'LayerSlider',
			'source'   				=> get_template_directory().'/includes/plugins/layerslider.zip',
			'required' 				=> false
		),
		array(
			'name'     				=> 'Revolution Slider',
			'slug'     				=> 'revslider',
			'source'   				=> get_template_directory().'/includes/plugins/revslider.zip',
			'required' 				=> false
		),
		array(
			'name'     				=> 'Envato Toolkit',
			'slug'     				=> 'envato-wordpress-toolkit-master',
			'source'   				=> get_template_directory().'/includes/plugins/envato-toolkit.zip',
			'required' 				=> false
		),
		array(
			'name'     				=> 'Contact Form 7',
			'slug'     				=> 'contact-form-7',
			'required' 				=> false
		)
	);

	$config = array(
		'domain'       		=> 'euged'
	);

	tgmpa( $plugins, $config );

};