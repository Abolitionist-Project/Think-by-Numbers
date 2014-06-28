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

// Project URL
$project_url = !empty($post_meta['project_details_project_url'][0]) ? $Euged->parse_url($post_meta['project_details_project_url'][0]) : NULL;

// Project URL
$details_enable = !empty($post_meta['project_details_enable'][0]) ? $post_meta['project_details_enable'][0] : 'on';

// Testimonial
$testimonial = !empty($post_meta['testimonial_show_testimonial'][0]) ? $post_meta['testimonial_show_testimonial'][0] : 'hide';
$testimonial_author = !empty($post_meta['testimonial_author'][0]) ? $post_meta['testimonial_author'][0] : NULL;
$testimonial_role = !empty($post_meta['testimonial_author_role'][0]) ? $post_meta['testimonial_author_role'][0] : NULL;
$testimonial_content = !empty($post_meta['testimonial_content'][0]) ? $post_meta['testimonial_content'][0] : NULL;
?>

<article <?php post_class('single') ?>>

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

	<div class="grid-row linearise">

		<div class="grid-item two-third">

			<h2 class="title description" style="display:none;"><?php _e('Description','euged') ?></h2>
			<div class="typography">
				<?php echo apply_filters('the_content', euged_strip_shortcode('gallery', $post->post_content)) ?>
			</div>

			<?php comments_template() ?>

		</div>

		<div class="grid-item one-third">

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

				<h3 class="title details"><?php _e('Details','euged') ?></h3>

				<dl class="tabular">

					<dt><?php _e('Date', 'euged') ?></dt>
					<dd><?php the_time(get_option('date_format')) ?></dd>

					<?php if (!empty($client)): ?>
						<dt><?php _e('Client', 'euged') ?></dt>
						<dd><?php echo $client ?></dd>
					<?php endif ?>

					<?php if (!empty($terms)): ?>
						<dt><?php _e('Category', 'euged') ?></dt>
						<dd>
							<ul class="tags">
								<?php foreach($terms as $term): ?>
									<li><a href="<?php echo get_term_link($term) ?>"><?php echo $term->name ?></a></li>
								<?php endforeach ?>
							</ul>
						</dd>
					<?php endif ?>

					<?php if (!empty($project_url)): ?>
						<dt><?php _e('URL', 'euged') ?></dt>
						<dd><a href="<?php echo $project_url ?>" class="button xsmall" target="_blank"><?php _e('Launch site', 'euged') ?></a></dd>
					<?php endif; ?>

				</dl>

			<?php endif ?>

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
        
        $slugs = [];
        if(!empty($terms)) {
            foreach($terms as $term) {
                $slugs[] = $term->slug; 
                break;
            }
        }
        $categories = count($slugs) > 0 ? implode(', ', $slugs) : '';        
        echo do_shortcode('[portfolio load="-1" columns="' . $other_projects_count . '" orderby="' . $other_projects_order . '" ' . ($categories !== '' ? 'category="'.$categories.'"' : '') .']') 
        
        ?>

<?php endif; ?>