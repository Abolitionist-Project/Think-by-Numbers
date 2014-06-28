<?php
/**
 * The main template file.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Quantimodo
 * @since Quantimodo 1.0
 */

get_header(); 

wp_enqueue_script("webpjs", "https://webpjs.appspot.com/js/webpjs-0.0.2.min.js");

?>

<section id="landing-page-wrap">
        <article id="main-wrap">
                <div class="frame_overlay"></div>
            
                <div class="inner">
                  <div class="lt-rainbow-corner"></div>
				  <div class="rt-rainbow-corner"></div>
				  <div class="quantimodo-info">
				  <hgroup>
				  <h3>
				  Combine data from all your<br>
				  life-tracking apps in one place.
				  </h3>
				  <h5>
				  Compare your mood, diet, sleep, exercise, medication, intake (or anything else) on the same graph.<br>
				  Use your insights to make adjustments and <span class="Raleway bold upper">Optimize your life!</span>
				  </h5>
				  </hgroup>
                </div>
                <div class="banner"></div>
            </div>
        </article>
        <article id="main-info">
            <a href="#" class="bubble-text first" data-content="<h3>If you don't measure it, you can't manage it.</h3>"></a>
            <a href="#" class="bubble-text second" data-content="<h3>Abolish politics. Abolish suffering.</h3>"></a>
            <a href="#" class="bubble-text third" data-content="<h3>My cat's breath smells like catfood.</h3>"></a>
            <a href="perfect-your-life" class="optimize-button ir first">Perfect Your Life</a>
            <a href="#" class="lm-left ir" data-content="testing">learn more</a>
            <a href="#" class="lm-center ir">Learn More</a>
            <a href="#" class="lm-right ir">Learn More</a>
        </article>
    </section>
</div>

<?php //get_sidebar(); ?>
<?php get_footer(); ?>
