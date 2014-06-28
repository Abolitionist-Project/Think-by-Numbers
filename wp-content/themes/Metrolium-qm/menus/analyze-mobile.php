<div id="mobile-menu">
    <div class="menu">
        <ul>
            <?php if(is_user_logged_in()): ?>
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
	<?php get_search_form(true); ?>
</div>