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
    <nav id="navigation" class="primary">
      <?php if(has_nav_menu('primary_navigation')) : ?>
      <?php wp_nav_menu(array('theme_location' => 'primary_navigation', 'container_id' => 'primary-navigation','walker' => new Arrow_Walker_Nav_Menu)); ?>
      <?php else : ?>
      <nav id="navigation" class="primary">
        <div id="primary-navigation" class="menu-primary-navigation-container">
          <?php wp_nav_menu(); ?>
        </div>
      </nav>
      <?php endif ?>
    </nav>
  </div>
</div>
