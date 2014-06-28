<?php
/**
**   Template Name: quantimodo
 * Description: The template for displaying all pages specially for quantimodo.
 
 */

get_header(); ?>

	<section id="page-wrap">
        <article id="main-wrap2" class="rounding">
            <div class="inner rounding">
                <div class="lt-rainbow-corner2"></div>
                <div class="rt-rainbow-corner2"></div>
                <article class="blogpost">
                <?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
				
			<?php endwhile; // end of the loop. ?>
            </article>
                 </div>
        </article>
        
    </section>
    </div>
<?php get_footer(); ?>