<?php
require_once('backend/functions.php');

add_action('wp_logout', 'fluxtream_logout');						// Also log out of FLuxtream when logging out of WordPress
add_action('wp_head', 'setLoggedInVariable');						// Sets a JavaScript variable that indicates whether a user is logged in or not
add_action('wp_enqueue_scripts', 'quantimodo_action_enqueue');	    // Enqueue Quantimodo-specific scripts
add_action('admin_init', 'restrict_edit_profile');					// Allow editing profile only if if edit_profile is enabled

add_filter ('allow_password_reset', 'restrict_password_reset');	    // Allow password reset only if edit_profile is enabled
//add_filter('show_admin_bar', '__return_false');                     // Hide admin bar on front-end for all users
// show admin bar only for users who have Administrator role
if ( !current_user_can( 'manage_options' ) ) {
    add_filter('show_admin_bar', '__return_false'); 
}

add_filter('wp_default_scripts', 'dequeue_jquery_migrate');         // Get rid of default jquery-migrate

// Remove javascript and styles on certain pages
add_action('wp_print_scripts', 'clean_analyze_scripts', 100);
add_action('wp_print_styles', 'clean_analyze_styles', 100);

// Update wp_unique_id table when new user created or deleted
add_action('user_register', 'add_id_users', 1);
add_action('deleted_user', 'remove_id_users', 100);

function add_id_users($id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . 'unique_id';
	$wpdb->query("INSERT INTO `$table_name` (`wpId`, `wpType`) VALUES ($id, 'user')");
}
function remove_id_users($id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . 'unique_id';
	$wpdb->query("UPDATE `$table_name` SET `active` = 0 WHERE `wpId` = $id AND `wpType` = 'user'");
}

function my_login_redirect( $redirect_to, $request, $user ) {
	//is there a user to check?
	global $user;
	if ( isset( $user->roles ) && is_array( $user->roles ) ) {
		//check for admins
		if ( in_array( 'administrator', $user->roles ) ) {
			// redirect them to the default place
			return $redirect_to;
		} else {
			return home_url();
		}
	} else {
		return $redirect_to;
	}
}

add_filter( 'login_redirect', 'my_login_redirect', 10, 3 );

function setLoggedInVariable()
{
	if(is_user_logged_in())
	{
		echo "<script> var isLoggedIn = true </script>";
	}
	else
	{
		echo "<script> var isLoggedIn = false </script>";	
	}
}

function fluxtream_logout()
{
	setcookie ("JSESSIONID", "", time() - 3600);
}

function quantimodo_action_enqueue()
{
        $theme = wp_get_theme();
        $ver = $theme['Version'];
        wp_enqueue_style('product_comment', get_stylesheet_directory_uri() . '/css/comment.css', false, $ver);
        wp_enqueue_style('product_rating', get_stylesheet_directory_uri() . '/css/rating.css', false, $ver);
	wp_enqueue_script('product_rating', get_stylesheet_directory_uri() . "/js/rating.js");
	wp_enqueue_script('affiliate_apple', get_stylesheet_directory_uri()."/js/libs/affiliate_apple.js");
        $tmp_uri = get_template_directory_uri();	
	$js_uri = $tmp_uri . '/assets/js/';
        wp_enqueue_script('isotope', $js_uri . 'jquery.isotope.min.js', array('jquery'), $ver, true);
        wp_enqueue_script('combination_filters.', get_stylesheet_directory_uri() . "/js/combination_filters.js");
}

function restrict_edit_profile()
{
	if (!current_user_can( 'edit_profile' ) && array_key_exists("edit_profile", $wp_roles->roles))
	{
		wp_die( __('You are not allowed to access this part of the site') );
	}
}
function restrict_password_reset()
{
	if (current_user_can('edit_profile') || !array_key_exists("edit_profile", $wp_roles->roles))
	{
		return true;
	}
	return false;
}

function dequeue_jquery_migrate( &$scripts)
{
	if (!is_admin())
	{
		$scripts->remove( 'jquery');
		$scripts->add('jquery', false, array( 'jquery-core' ));
	}
}


//*******************************************************//
//    Remove scrips that are useless on certain pages   //
//*******************************************************//
function clean_analyze_scripts()
{
	if (is_page('analyze'))
	{
		// Remove layerslider stuff
		// wp_deregister_script('layerslider_js');
		// wp_deregister_script('jquery_easing');
		// wp_deregister_script('transit');
		// wp_deregister_script('layerslider_transitions');

		// Fitvids
		// wp_deregister_script('fitvids');

		// Showbiz
		// wp_deregister_script('showbiz-core');
		// wp_deregister_script('showbiz-fancybox');

		// Affiliate stuff
		// wp_deregister_script('affiliate_apple');

		// Commenting
		// wp_deregister_script('comment-reply');
	}
}

function clean_analyze_styles()
{
	if (is_page('analyze'))
	{
		// Remove layerslider stuff
		// wp_deregister_style('layerslider_css');
		// wp_deregister_style('layerslider_custom_css');

		// Showbiz
		// wp_deregister_style('showbiz-style');
		// wp_deregister_style('showbiz-fancybox-style');
	}
}

function qm_login_logo() { ?>
    <style type="text/css">
        body.login div#login {
            padding: 6% 0 0;
        }
        body.login div#login h1 a {
            background-image: url(<?php echo site_url(); ?>/wp-content/uploads/2013/10/QM-LOGO-CRAZY-ARROWS-blue-1614-x-400-abolish.png);
            padding-bottom: 30px;
            background-size: 280px 80px !important;
            width:auto;
            padding-bottom: 0px;
        }
    </style>
<?php }

add_action( 'login_enqueue_scripts', 'qm_login_logo' );

function qm_login_logo_url() {
    return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'qm_login_logo_url' );

function qm_login_logo_url_title() {
    return get_bloginfo('site_name');
}
add_filter( 'login_headertitle', 'qm_login_logo_url_title' );

function qm_register_custom_post_types()
{
	require_once('includes/custom-post-types/config.php');
}

add_action('init', 'qm_register_custom_post_types', 3);

	