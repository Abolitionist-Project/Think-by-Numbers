<form role="search" method="get" id="searchform" action="<?php echo esc_url(home_url('/')) ?>" >
	<input type="hidden" name="post_type" value="post" />
	<input type="text" value="<?php echo get_search_query() ?>" name="s" id="s" />
	<button type="submit" id="searchsubmit"><i class="icon-search"></i></button>
</form>