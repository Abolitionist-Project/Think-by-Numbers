<?php
global $Euged;
$post_meta = get_post_meta($post->ID);

// Client Details
if (!empty($post_meta['project_details_client_url'][0]))
{
	$client_url = $Euged->parse_url($post_meta['project_details_client_url'][0]);
	$client_url_open = '<a href="' . $client_url . '" target="_blank">';
	$client_url_close = '</a>';
}
else
{
	$client_url_open = $client_url_close = '';
}

if (!empty($post_meta['project_details_client_name'][0]))
{
	$client = $client_url_open . $post_meta['project_details_client_name'][0] . $client_url_close;
}

// Terms
$terms = get_the_terms($post->ID, 'portfolio_category');

$isQuantimodoSupported = false;
$slugs = [];
if(!empty($terms)) {
    foreach($terms as $term) {
        $slugs[] = $term->slug;    
        if($term->slug === 'quantimodo') {
            $isQuantimodoSupported = true;
        }
    }
}
$categories = count($slugs) > 0 ? implode(', ', $slugs) : '';

// Project URL
$project_url = !empty($post_meta['project_details_project_url'][0]) ? $Euged->parse_url($post_meta['project_details_project_url'][0]) : NULL;

// Amazon Rating
$amazon_rating = !empty($post_meta['amazon_rating'][0]) ? $post_meta['amazon_rating'][0] : NULL;
// Number of Amazon Ratings
$number_of_amazon_ratings = !empty($post_meta['number_of_amazon_ratings'][0]) ? $post_meta['number_of_amazon_ratings'][0] : NULL;
// Price
$price = !empty($post_meta['price'][0]) ? $post_meta['price'][0] : NULL;
// Amazon Link
$amazon_link = !empty($post_meta['amazon_link'][0]) ? $Euged->parse_url($post_meta['amazon_link'][0]) : NULL;
// Amazon Customer Reviews Link
$amazon_customer_reviews_link = !empty($post_meta['amazon_customer_reviews_link'][0]) ? $Euged->parse_url($post_meta['amazon_customer_reviews_link'][0]) : NULL;
// iTunes Link
$itunes_link = !empty($post_meta['itunes_link'][0]) ? $Euged->parse_url($post_meta['itunes_link'][0]) : NULL;
// Play Store Link
$play_store_link = !empty($post_meta['play_store_link'][0]) ? $Euged->parse_url($post_meta['play_store_link'][0]) : NULL;
// Chrome Web Store Link
$chrome_web_store_link = !empty($post_meta['chrome_web_store_link'][0]) ? $Euged->parse_url($post_meta['chrome_web_store_link'][0]) : NULL;
// Affiliate Link
$affiliate_link = !empty($post_meta['affiliate_link'][0]) ? $Euged->parse_url($post_meta['affiliate_link'][0]) : NULL;

// Buy For URL
$page_options_titlebar_cta_link = !empty($post_meta['page_options_titlebar_cta_link'][0]) ? $Euged->parse_url($post_meta['page_options_titlebar_cta_link'][0]) : NULL;

$page_options_titlebar_cta_text = !empty($post_meta['page_options_titlebar_cta_text'][0]) ? $post_meta['page_options_titlebar_cta_text'][0] : NULL;


// Project URL
$details_enable = !empty($post_meta['project_details_enable'][0]) ? $post_meta['project_details_enable'][0] : 'on';

// Testimonial
$testimonial = !empty($post_meta['testimonial_show_testimonial'][0]) ? $post_meta['testimonial_show_testimonial'][0] : 'hide';
$testimonial_author = !empty($post_meta['testimonial_author'][0]) ? $post_meta['testimonial_author'][0] : NULL;
$testimonial_role = !empty($post_meta['testimonial_author_role'][0]) ? $post_meta['testimonial_author_role'][0] : NULL;
$testimonial_content = !empty($post_meta['testimonial_content'][0]) ? $post_meta['testimonial_content'][0] : NULL;
?>

<article <?php post_class('single') ?>>

	<div class="grid-row linearise">
		
		<div class="grid-item one-quarter">
                        <div class="pdetailLeft">
			<?php if (!empty($testimonial) && $testimonial == 'on'): ?>

				<h3 class="title testimonial"><?php _e('Testimonial','euged') ?></h3>    

				<figure class="testimonial clearfix">
					<blockquote><?php echo apply_filters('the_content', $testimonial_content) ?></blockquote>
					<?php if ($testimonial_author): ?>
						<figcaption>
							<p class="author"><?php echo $testimonial_author ?></p>
							<p class="role"><?php echo $testimonial_role ?></p>
						</figcaption>
					<?php endif ?>
				</figure>

				<hr class="shadow" />

			<?php endif ?>

			<?php if( $details_enable == 'on' ) : ?>

				<?php echo '<img style="margin-bottom:20px;" src="'.wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) ).'">' ; ?> 
                                        
                                        <?php if ($isQuantimodoSupported): ?>                                               
                                            <div class="row buyfor"><a href="/dashboard/accounts/" class="button large" target="_blank"><?php _e('Import Data', 'euged') ?></a></div>
					<?php endif; ?>   
                                       
                                        <?php if (!empty($affiliate_link) && !empty($price)): ?>						
						<div class="row buyfor"><a href="<?php echo $affiliate_link ?>" class="button large" target="_blank"><?php _e('Buy for '.$price, 'euged') ?></a></div>
					<?php endif; ?>
                                                
                                        <?php if (!empty($itunes_link)): ?>						
                                                <div class="row"><a href="<?php echo $itunes_link ?>" class="xsmall" target="_blank"><img class="customButtons" src="/wp-content/uploads/2014/03/itunes-button.png"></a></div>
					<?php endif; ?> 
                                                
                                        <?php if (!empty($play_store_link)): ?>						
						<div class="row"><a href="<?php echo $play_store_link ?>" class="xsmall" target="_blank"><img class="customButtons" src="/wp-content/uploads/2014/03/google-play-button.png"></a></div>
					<?php endif; ?> 
                                                
                                        <?php if (!empty($chrome_web_store_link)): ?>						
						<div class="row"><a href="<?php echo $chrome_web_store_link ?>" class="xsmall" target="_blank"><img class="customButtons" src="http://i.imgur.com/54mkyim.png"></a></div>
					<?php endif; ?>         
                                        
                                        <?php if (!empty($amazon_link)): ?>
                                                <div class="row">
                                                <?php if (!empty($affiliate_link) && !empty($price)) : ?>                                                    
                                                   <a href="<?php echo $affiliate_link ?>" class="xsmall" target="_blank"><img class="customButtons" src="/wp-content/uploads/2014/03/amazon-button.png"></a>                                                
                                                <?php else: ?>                                                   
                                                   <a href="<?php echo $amazon_link ?>" class="xsmall" target="_blank"><img class="customButtons" src="/wp-content/uploads/2014/03/amazon-button.png"></a>                                                   
                                                <?php endif; ?> 
                                                </div>
                                        <?php endif; ?>    
                                               
                                        <?php if (!empty($amazon_rating)):?>
                                                <div class="row">
                                                <?php _e('Amazon Rating', 'euged') ?>    
                                                <?php echo '<div title="'.$amazon_rating.' out of 5 star" class="small-star star-rating-non-editable-container"><div class="current-rating" style="width: ' . ((float)$amazon_rating * 20) . '%;"></div></div>'; ?>
                                                 <?php if (!empty($number_of_amazon_ratings)):?>
                                                        <?php if (!empty($amazon_customer_reviews_link)):?>
                                                        (<a href="<?php echo $amazon_customer_reviews_link; ?>"><?php echo $number_of_amazon_ratings; ?> customer reviews</a>)
                                                        <?php else: ?>
                                                        (<?php echo $number_of_amazon_ratings; ?> customer reviews)
                                                        <?php endif; ?> 
                                                 <?php endif; ?> 
                                                </div>
					<?php endif; ?>
                                                    
                                        <?php if (!empty($terms)): ?>						
                                                <br/><div class="row"><ul class="tags">
                                                <?php foreach($terms as $term): ?>
                                                    <li><a href="<?php echo get_term_link($term) ?>"><?php echo $term->name ?></a></li>
                                                <?php endforeach ?>
                                            </ul> </div>						
					<?php endif ?>  

			<?php endif ?>
                        </div>                         
		</div>
            
                <div class="grid-item three-quarter">

			<?php
			$images = euged_get_gallery_images_array();
			if(!empty($images)) :
			?>

				<header>
					<div class="flexslider thumbnails">
						<div class="slides">
							<?php foreach($images as $image) : ?>
								<div class="slide">
									<?php echo wp_get_attachment_image($image, 'full'); ?>
								</div>
							<?php endforeach ?>
						</div>
					</div>
					<ul class="flex-thumbnail-nav">
						<?php foreach($images as $image) : ?>
							<li><?php echo wp_get_attachment_image($image, 'thumbnail'); ?></li>
						<?php endforeach ?>
					</ul>
				</header>

			<?php endif ?>

			<h1 class="desc-title-heading"><?php _e('Description','euged') ?></h1>
                        
                        <p><?php echo get_the_excerpt(); ?></p> 
                        <?php 
                                        $screenshotsHTML = '';
                                        $attachments = get_children( array('post_parent' => $post->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image') );    
                                        $link = $affiliate_link;
                                        $link = (!empty($link) ? $link : !empty($itunes_link) ? $itunes_link : 
                                                 !empty($play_store_link) ? $play_store_link : !empty($chrome_web_store_link) ? $chrome_web_store_link : $amazon_link);
                                        foreach ($attachments as $attachment_id => $attachment ) {                                              
                                            if (strpos($attachment->post_title,'_screenshot_') !== false || strpos($attachment->post_name,'_screenshot_') !== false) {
                                                $screenshotsHTML .= '<div class="image-wrapper"><a href="'. $link . '" target="_blank">' . wp_get_attachment_image($attachment_id, 'full') . '</a></div>';
                                            }                                             
                                        }
                        ?>                      
                        <?php if ($screenshotsHTML !== ''): ?>
                        <div class="screenshot">
                            <div>  
                                <h1 class="screenshot-heading">Screenshots</h1>
                            </div>
                            <div class="screen-images-container">                                
                                    <?php echo $screenshotsHTML; ?>                            
                            </div>
                        </div>
                        <?php endif ?>
                        <div class="typography">
				<?php echo apply_filters('the_content', euged_strip_shortcode('gallery', $post->post_content)) ?>
			</div>

			<?php comments_template() ?>

		</div>

	</div>

</article>

<?php if (!empty($post_meta['portfolio_options_show_other_projects'][0]) && $post_meta['portfolio_options_show_other_projects'][0] == 'on'): ?>

	<hr class="shadow" />

	<h3><?php _e('Related Apps and Devices','euged') ?></h3>

	<?php
	$other_projects_count = !empty($post_meta['portfolio_options_other_project_count'][0]) ? $post_meta['portfolio_options_other_project_count'][0] : '4';
	$other_projects_order = !empty($post_meta['portfolio_options_other_projects_order'][0]) ? $post_meta['portfolio_options_other_projects_order'][0] : 'rand';
	//echo do_shortcode('[portfolio load="' . $other_projects_count . '" columns="' . $other_projects_count . '" orderby="' . $other_projects_order . '"]') 
                          
        echo do_shortcode('[portfolio load="' . $other_projects_count . '" columns="' . $other_projects_count . '" orderby="' . $other_projects_order . '" ' . ($categories !== '' ? 'category="'.$categories.'"' : '') .']'); 
             
        ?>

<?php endif; ?>