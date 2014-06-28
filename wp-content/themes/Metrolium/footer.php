		<?php
		if (!empty($post))
		{
			$template = get_post_meta($post->ID,'euged_footer_template', true);
		}
		$template = !empty($template) ? $template : 'v1';
		?>

		<footer class="<?php echo $template ?>">

			<?php
			$site_wide_cta_options = get_option('euged_site_wide_cta');
			$site_wide_cta_theme_mods = get_theme_mod('euged_site_wide_cta');

			if ( empty($site_wide_cta_theme_mods['show_site_wide_cta']) || (!empty($site_wide_cta_theme_mods['show_site_wide_cta']) && $site_wide_cta_theme_mods['show_site_wide_cta'] == 'true' ) ) : ?>

				<div id="site-wide-cta" class="band padded thin">
					<div class="inner">
						<div class="status">
							<?php $message = !empty($site_wide_cta_options['message']) ? $site_wide_cta_options['message'] : 'A site wide call to action band <a href="#" class="button large">CLICK</a>'; ?>
							<p id="site-wide-cta-message"><?php echo euged_filter_process_shortcodes($message); ?></p>
						</div>
					</div>
				</div>

			<?php endif; ?>

			<?php
			$pre_footer_options = get_option('euged_pre_footer');
			$pre_footer_theme_mods = get_theme_mod('euged_pre_footer');

			if ( empty($pre_footer_theme_mods['show_pre_footer']) || (!empty($pre_footer_theme_mods['show_pre_footer']) && $pre_footer_theme_mods['show_pre_footer'] == 'true' ) ) : ?>

			<div id="prefooter" class="band padded thin">
				<div class="inner">
					<h2><?php _e('Find us elsewhere', 'euged') ?></h2>
					<div class="social">
						<?php if( !dynamic_sidebar( 'prefooter-widget-area' ) ) echo '<div class="placeholder">Add a \'Social Icons\' widget to Pre-Footer sidebar</div>' ?>
					</div>
				</div>
			</div>

			<?php endif; ?>

			<?php
			$footer_options = get_option('euged_footer');
			$footer_theme_mods = get_theme_mod('euged_footer');

			if ( empty($footer_theme_mods['show_footer']) || (!empty($footer_theme_mods['show_footer']) && $footer_theme_mods['show_footer'] == 'true' ) ) : ?>

			<div id="footer" class="band inset">
				<div class="inner">

					<div class="grid-row linearise">

						<?php
						$i = 0;
						global $global_admin_options;
						$widget_areas = !empty($global_admin_options['global_footer_columns']) ? $global_admin_options['global_footer_columns'] : 4;
						$widget_area_names = array(
							'first-footer-widget-area',
							'second-footer-widget-area',
							'third-footer-widget-area',
							'fourth-footer-widget-area'
						);

						switch($widget_areas)
						{
							case 2 : $widget_column_width = 'one-half'; break;
							case 3 : $widget_column_width = 'one-third'; break;
							case 4 : $widget_column_width = 'one-quarter'; break;
						}

						while( ++$i <= $widget_areas ) : $widget_area = array_shift($widget_area_names); ?>

							<div class="grid-item <?php echo $widget_column_width ?>">
								<?php if( !dynamic_sidebar($widget_area) ) echo '<div class="placeholder">Add Footer Widget</div>' ?>
							</div>

						<?php endwhile ?>
					</div>

				</div>

			</div>

			<?php endif; ?>

			<?php
			$trim_options = get_option('euged_trim');

			if( !empty( $trim_options['copyright'] ) )
			{
				$copyright = $trim_options['copyright'];
			}
			else
			{
				$copyright = '&copy; '. date( 'Y' ) .' '. get_bloginfo( 'name' ) .'- <a href="http://www.euged.com/wordpress-themes/metrolium/" target="_blank">Metrolium WordPress Theme</a> by <a href="http://www.euged.com/" target="_blank">Euged</a>';
			}
			?>

			<div id="trim" class="band inset">
				<div class="inner">
					<nav class="trim">
						<?php wp_nav_menu(array('theme_location' => 'trim_links', 'container' => false, 'items_wrap' => '<ul class="unstyled">%3$s</ul>')) ?>
					</nav>
					<p id="trim-copyright" class="copyright"><?php echo $copyright ?></p>
				</div>
			</div>

		</footer>

	</div>

	<?php wp_footer() ?>

	<!-- <?php echo get_num_queries() ?> -->

</body>
</html>