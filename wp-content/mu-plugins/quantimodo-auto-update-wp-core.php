<?php

/*
 * Plugin Name: Quantimodo Automatic WP Core Updates
 * Plugin URI:  https://github.com/pothi/wordpress-mu-plugins
 * Version:     0.1
 * Description: To update WP core irrespective of any VCS used
 * Author:      Pothi Kalimuthu
 * Author URI:  http://pothi.info
 * License:     GPL
 */

add_filter( 'automatic_updates_is_vcs_checkout', '__return_false', 1 );
