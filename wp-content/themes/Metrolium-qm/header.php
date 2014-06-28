<!doctype html>
<!--[if lt IE 7]>	<html class="ie6" <?php language_attributes() ?>> <![endif]-->
<!--[if IE 7]>		<html class="ie7" <?php language_attributes() ?>> <![endif]-->
<!--[if IE 8]>		<html class="ie8" <?php language_attributes() ?>> <![endif]-->
<!--[if gt IE 8]><!-->	<html <?php language_attributes() ?>> <!--<![endif]-->
<head>
	<title><?php bloginfo('name'); ?> <?php wp_title('&#8250;'); ?></title>
	<meta charset="<?php bloginfo('charset') ?>">
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<?php wp_head() ?>
</head>
<body <?php body_class(get_post_type()) ?>>

	<?php 
		global $current_user;
		$isOnDashboard = false;
		if(is_page('dashboard'))
		{
			$isOnDashboard = true;
		}
		else
		{
			$ancestors = get_ancestors($post->ID, 'page');
			
			foreach($ancestors as $ancestor)
			{
				$currentPage = get_post($ancestor);
				if($currentPage->post_name == 'dashboard')
				{
					$isOnDashboard = true;
					break;
				}
			}
		}
		
		if($isOnDashboard)
		{
			include 'menus/analyze-mobile.php';   
		}
		else
		{
			include 'menus/default-mobile.php'; 
		}
	?>

	<?php $global_theme_mods = get_theme_mod('euged_global'); ?>

	<div id="site" class="<?php echo !empty($global_theme_mods['layout_style']) ? $global_theme_mods['layout_style'] : 'wide'; ?>">

		<?php
		$header_theme_mods = get_theme_mod('euged_header');
		$header_style = !empty($header_theme_mods['header_style']) ? $header_theme_mods['header_style'] : 'header-v1';
		if( !empty($post) && get_post_meta( $post->ID, 'header_style_override', true ) )
		{
			$header_style = get_post_meta( $post->ID, 'header_style_override', true );
		}
		?>

		<?php
		if( empty( $global_admin_options['global_sticky_header'] ) )
		{
			$global_admin_options['global_sticky_header'] = 'off';
		}
		if( isset( $_GET['sticky_navigation'] ) )
		{
			$global_admin_options['global_sticky_header'] = $_GET['sticky_navigation'];
		}
		?>

		<header class="main stickynav-<?php echo $global_admin_options['global_sticky_header'] ?> <?php echo $header_style ?>">

			<?php
			$hello_bar_options = get_option('euged_hello_bar');
			$hello_bar_theme_mods = get_theme_mod('euged_hello_bar');

			if ( empty($hello_bar_theme_mods['show_hello_bar']) || (!empty($hello_bar_theme_mods['show_hello_bar']) && $hello_bar_theme_mods['show_hello_bar'] == 'true' ) ) : ?>

				<div id="hellobar" class="band outset" style="display: none;">
					<div class="inner">
						<div class="status">
							<?php $message = !empty($hello_bar_options['message']) ? $hello_bar_options['message'] : 'Welcome to Metrolium! You can set this message in WP Customizer in your admin panel'; ?>
							<p id="hellobar-message" data-hash="<?php echo md5(strip_tags($message)); ?>"><?php echo $message; ?></p>
							<a href="#" class="hide"><i class="icon-remove-sign"></i></a>
						</div>
					</div>
				</div>

			<?php endif; ?>

			<?php
			$info_bar_options = get_option('euged_info_bar');
			$info_bar_theme_mods = get_theme_mod('euged_info_bar');
			?>

				<div id="infobar" class="band">
					<div class="inner">

						<ul id="mobile-menu-toggle-container">
							<li><a href="#" id="mobile-menu-toggle" data-hide="<i class='icon-reorder'></i> <?php _e('Hide Menu', 'euged'); ?>"><i class="icon-reorder"></i> <?php _e('Show Menu', 'euged'); ?></a></li>
						</ul>

						<ul class="infobar">

							<?php if ($info_bar_theme_mods['show_email']) : ?>
								<li class="email"><a href="mailto:<?php echo !empty($info_bar_options['email']) ? $info_bar_options['email'] : 'set.your@email.address'; ?>"><i class='misc-icon icon-envelope-alt'></i> <span class=""><?php echo !empty($info_bar_options['email']) ? $info_bar_options['email'] : 'set.your@email.address'; ?></span></a></li>
							<?php endif; ?>

							<?php if ($info_bar_theme_mods['show_telephone']) : ?>
								<li class="telephone"><i class='misc-icon icon-phone'></i> <span class=""><?php echo !empty($info_bar_options['telephone']) ? $info_bar_options['telephone'] : '01234 567890'; ?></span></li>
							<?php endif; ?>

							<?php if ($info_bar_theme_mods['show_socials'] == 'true') : ?>
								<li class="social">
									<?php if( !dynamic_sidebar( 'infobar-widget-area' ) ) echo '<div class="placeholder">Add a \'Social Icons\' widget to Infobar sidebar</div>' ?>
								</li>
							<?php endif; ?>
														
							<?php if ($current_user != NULL && $current_user->user_login != '') : ?>
									<li class="placeholder">
										<a href="/citizen-science/members/<?php echo $current_user->user_login ?>/settings/" style="color: rgb(128, 128, 128);"><?php echo $current_user->display_name; ?></a>
										<div class="setButton icon-user icon-large" onclick="location.href='/citizen-science/members/<?php echo $current_user->user_login ?>/settings/';" style="margin-left:5px;"></div>
										<?php if (array_key_exists('administrator', $current_user->caps) && $current_user->caps['administrator']) : ?>
											<div class="setButton icon-cog icon-large" onclick="location.href='/wp-admin';" style="margin-left:5px;"></div>
										<?php endif; ?>
							<?php endif; ?>



							<?php if ($info_bar_theme_mods['show_search'] == 'true') : ?>
								<li class="search">
									<form role="search" action="<?php echo get_site_url(); ?>" method="get">
									  <button type="submit" id="searchsubmit" value="post" style="float: right;">
										<i style="margin-top: -5px;"class="icon-search"></i>
									  </button>
									  <div style="overflow: hidden;">
										<input type="text" name="s" placeholder="<?php echo !empty($info_bar_options['search']) ? $info_bar_options['search'] : 'Search QuantiModo'; ?>"/>
									   </div>
									</form>
								</li>
							<?php endif; ?>				  
						</ul>
					</div>
				</div>

			<?php
			//Setting header style disabled, using predefined header for QuantiModo
			//get_template_part('includes/headers/' . $header_style);
			?>
			
			<?php
			$header_options = get_option('euged_header');
			$header_theme_mods = get_theme_mod('euged_header');
			?>
			
			<div id="banner" class="band">
			  <div class="inner">
				<?php
					$logo = !empty($header_theme_mods['logo']) ? $header_theme_mods['logo'] : get_template_directory_uri() . '/assets/images/banner_logo.png';
				?>
				
				<a href="<?php echo home_url() ?>" class="logo"><img src="<?php echo $logo; ?>" alt="<?php echo get_bloginfo('description') ?>" /></a>
			 
				<?php 
				if ($isOnDashboard)
				{
					include 'menus/analyze.php';   
				}
				else
				{
					include 'menus/default.php'; 
				}
				?>

			  </div>
			</div>
		</header>