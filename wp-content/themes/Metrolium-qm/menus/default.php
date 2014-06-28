<nav id="navigation-login" class="login">
    <div id="login-navigation" class="menu-primary-navigation-container">
        <div class="menu">
            <ul>
                <?php if(is_user_logged_in()):?>
                    <li>
                        <a href="<?php echo site_url(); ?>/analyze/" sl-processed="1">Analyze</a>
                    </li>
                    <li>
                        <a href="<?php echo site_url(); ?>/correlate/" sl-processed="1">Correlate</a>
                    </li>
					<li>
						<a href="<?php echo site_url(); ?>/dashboard/accounts/" sl-processed="1">Connect</a>
					</li>
                    <li>
					<a href="<?php echo wp_logout_url(); ?>" sl-processed="1">Sign Out</a>
                    </li>
                <?php else: ?>
                    <li>
					<a href="<?php echo wp_login_url( home_url() ); ?>" sl-processed="1">Sign In</a>
                    </li>
                    <li>
                        <a href="<?php echo site_url(); ?>/citizen-science/register/" sl-processed="1">Register</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<nav id="navigation" class="primary">
    <div id="primary-navigation" class="menu-primary-navigation-container">
      <?php wp_nav_menu(); ?>
    </div>
</nav>
