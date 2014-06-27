<?php

/*
Plugin Name: Vibe ShortCodes
Plugin URI: http://www.vibethemes.com
Description: Create unlimited shortcodes
Author: VibeThemes
Version: 1.6.1
Author URI: http://www.vibethemes.com
Text Domain: vibe
*/


if( !defined('VIBE_PLUGIN_URL')){
    define('VIBE_PLUGIN_URL',plugins_url());
}

/*====== BEGIN VSLIDER======*/

include_once('classes/vibeshortcodes.class.php');
include_once('shortcodes.php');
include_once('ajaxcalls.php');


/*====== INSTALLATION HOOKS VSLIDER======*/        
// Runs when plugin is activated and creates new database field
register_activation_hook(__FILE__,'vibe_shortcodes_install');
function vibe_shortcodes_install() {
    
}

if ( file_exists( dirname( __FILE__ ) . '/lang/' . get_locale() . '.mo' ) ){
    load_textdomain( 'vibe', dirname( __FILE__ ) . '/lang/' . get_locale() . '.mo' );
}

add_action( 'init', 'vibe_shortcodes_update' );
function vibe_shortcodes_update() {

	/* Load Plugin Updater */
	require_once( trailingslashit( plugin_dir_path( __FILE__ ) ) . 'autoupdate/class-plugin-update.php' );

	/* Updater Config */
	$config = array(
		'base'      => plugin_basename( __FILE__ ), //required
		'dashboard' => true,
		'repo_uri'  => 'http://www.vibethemes.com/',  //required
		'repo_slug' => 'vibe-shortcodes',  //required
	);

	/* Load Updater Class */
	new Vibe_Shortcodes_Auto_Update( $config );
}

?>
