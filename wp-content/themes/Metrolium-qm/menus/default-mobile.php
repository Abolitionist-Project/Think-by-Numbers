<div id="mobile-menu">
    <div class="menu">
        <ul>
            <?php if(is_user_logged_in()): ?>
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
	<?php get_search_form(true); ?>
</div>
