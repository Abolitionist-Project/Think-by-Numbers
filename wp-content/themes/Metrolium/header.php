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
// THIS IS FOR THE LIVE OPTIONS DEMO ON FRONTEND (FAKE WP CUSTOMIZER), YOU CAN REMOVE BELOW THIS LINE IF YOU DON'T NEED IT
if (get_option('theme_demo_mode','0') == '1' || (!empty($_GET[sanitize_key('demo_mode')]) && $_GET[sanitize_key('demo_mode')] == 'yes'))
	require_once dirname(__FILE__) . '/backend/wp-customizer/live-options.php';
// THIS IS FOR THE LIVE OPTIONS DEMO ON FRONTEND (FAKE WP CUSTOMIZER), YOU CAN REMOVE ABOVE THIS LINE IF YOU DON'T NEED IT
?>

	<div id="mobile-menu">
		<?php get_search_form(true); ?>
	</div>

	<style>
	<?php
	// Custom Header
	$header_image = get_header_image();
	if ( !empty( $header_image ) )
	{
		echo '#banner { background-image: url("' . $header_image . '"); }';
	}

	// Custom CSS
	global $global_admin_options;
	echo html_entity_decode( $global_admin_options['global_custom_css'] );
	?>
	</style>

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

						</ul>
					</div>
				</div>

			<?php
			get_template_part('includes/headers/' . $header_style);
			?>

		</header>