<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Quantimodo
 * @since Quantimodo 1.0
 */
?>

<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width" />
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.png" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<!-- Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. -->
	<!--[if lt IE 9]>
		<script src="<?php //echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
	<![endif]-->
	<?php 
		wp_head(); 
		
		wp_enqueue_style("font-opensans", "//fonts.googleapis.com/css?family=Open+Sans");
	?>

</head>
<body>
<div class="main-container">
    <header>
        <div class="header-inner clearfix">
            <a id="logo" class="ir" href="/">Quantimodo Home</a>
            <?php if (!is_user_logged_in()) { ?>
                <div class="invitation">
					<form action="<?php echo get_option('home'); ?>/wp-login.php" method="post" style="float:right;">
						<input type="text" name="log" id="log" class="input" value="<?php echo wp_specialchars(stripslashes($user_login), 1) ?>" placeholder="Email/Username" size="20" /><br />
						<span style="font-size: 10pt; top:6px;position: relative; color:#ddd;">
							<input name="rememberme" type="checkbox" id="rememberme" value="forever" <?php checked( $rememberme ); ?> style="width: 11px;position:relative;"/>&nbsp;&nbsp; <?php esc_attr_e('Remember Me'); ?>
						</span>
						<br/><br/>
						<input type="password" name="pwd" id="pwd" size="20" class="input" value="" placeholder="Password"/><br/>
						<a style="position:relative;left:-17px;color:#ddd;font-size:10pt;top:-40px;" href="<?php echo get_option('home'); ?>/wp-login.php?action=lostpassword">Forgot your password?</a>
						<input type="submit" name="submit" value="" class="login ir"  />
						<a id="registerShow" class="register ir login-window" href="#login-box">Register Now!</a>
						<input type="hidden" name="redirect_to" value="/analyze" />

					</form>
                </div>
            <?php } ?>
        </div>
    
		<div id="navigation">
			<?php wp_nav_menu(); ?>
		</div>
		<div id="nav-mobi">
    <select>
    <option>About Us</option>
    <option>About Us</option>
    <option>Why It Works</option>
    <option>Why?</option>
    <option>Apps</option>
    <option>Apps</option>
    </select>
<div style="clear:both"></div>
    </div>
    <div id="login-box-cotainer">
      <div class="black_button login-btn">Login <span>▼</span></div>
      <div class="login-form-container">
      <form>
      <p>Username:<input type="text" name="username" placeholder="Your username" id="username" /></p>
      <p>Password:<input type="password" name="username" placeholder="Your password" id="username" /></p>
      <p>Your username or password is invalid.<input class="green_button" type="button" value="Login" name="username" id="username" /></p>
      </form>
      </div>
    </div>
		<div id="login-box" class="login-popup">
			<div id="registerModal" class="modal in">
				<div class="register-inner-frame">
					<div class="modal-header">
						<a href="#" class="close"><img src="<?php echo get_template_directory_uri(); ?>/images/close_pop.png" alt="Close" /></a>
						<h3 id="myModalLabel">Register</h3>
					</div>
					<form action="<?php echo site_url('wp-login.php?action=register', 'login_post') ?>" class="form-horizontal" method="post">
						<div style="max-height: 500px; height:330px;" class="modal-body">
							<div class="oauth_providers">
								<p style="padding-left:40px;">You can register with any of the providers:</p> 
								<?php do_action( 'social_connect_form' ); ?>
							</div>
							<p style="padding-left:40px;">Or you can fill the form with your own login credentials:</p>
							<div class="control-group">
								<label for="user" class="control-label">Username</label>
								<div class="controls">
									<input type="text" placeholder="Username" name="user_login" id="user_login" autocapitalize="off" autocorrect="off">
									
								</div>
							</div>
							<div class="control-group">
								<label for="email" class="control-label">Email</label>
								<div class="controls">
									<input type="email" placeholder="ex: example@example.com" name="user_email" id="user_email" autocapitalize="off" autocorrect="off">
									
								</div>
							</div>
							<?php //do_action('register_form'); ?>
							<div class="control-group">
								<div class="controls">
									
									<button class="btn btn-primary" id="submitbtn" type="submit" name="submit">Register</button>
									
								</div>
							</div>
							<p style="padding-left:40px;">A password will be e-mailed to you.</p>
						</div>
					</form>
				</div>
			</div>
		</div>
    </header>
