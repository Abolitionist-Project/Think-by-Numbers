<?php
global $global_admin_options;
$terms = get_terms( 'portfolio_category' );
$term_slug = get_query_var( 'term' );
if( count( $terms ) > 0 ) :        
?>
	<nav class="filter isotope-filter">
		<ul>
			<li <?php if( $term_slug == '' ) : ?> class="selected" <?php endif ?>><a href="<?php echo get_permalink( $global_admin_options['portfolio_page_for_portfolio'] ) ?>" data-filter="*"><?php _e( 'All', 'euged' ) ?></a></li>
			<?php foreach($terms as $term) : ?>
				<li <?php if( $term_slug == $term->slug ) : ?> class="selected" <?php endif ?>><a href="<?php echo get_term_link( $term ) ?>" data-filter=".<?php echo 'filter-' . strtolower( str_replace( ' ', '-', $term->slug ) ); ?>"><?php echo $term->name ?></a></li>
			<?php endforeach ?>
		</ul>
	</nav>

<?php endif ?>