<nav id="navigation-login" class="login">
    <div id="login-navigation" class="menu-primary-navigation-container">
        <div class="menu">
            <ul>
                <?php if(is_user_logged_in()):?>
                    <li>
                        <a href="<?php echo site_url(); ?>/" sl-processed="1">Home</a>
                    </li>
                    <li>
                        <a href="<?php echo site_url(); ?>/wp-login.php?action=logout" sl-processed="1">Sign Out</a>
                    </li>
                <?php else: ?>
                    <li>
                        <a href="<?php echo site_url(); ?>/" sl-processed="1">Home</a>
                    </li>
                    <li>
                        <a href="<?php echo site_url(); ?>/wp-login.php?action=logout" sl-processed="1">Sign Out</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<nav id="navigation" class="primary">
    <div id="primary-navigation" class="menu-primary-navigation-container">
      <?php wp_nav_menu( array('menu' => 'analyze' )); ?>
    </div>
</nav>