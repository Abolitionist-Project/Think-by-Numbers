<?php
class WPBase_Browse_Blog extends WP_Widget
{
	private $title = "Browse Blog";

	// Register
	public function __construct()
	{
		parent::__construct(
			'euged_browse_blog', // Base ID
			'Browse Blog', // Name
			// Args
			array(
				'classname' => __('widget_browse_blog', 'wpbase'),
				'description' => __('Display link to the next and previous blog posts. (only works within the blog sidebar)', 'wpbase')
			)
		);
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form($instance)
	{
		$defaults = array('title' => $this->title);
		$instance = wp_parse_args($instance, $defaults);

		printf(
				'<p><label for="%1$s">Title:</label><input id="%1$s" name="%2$s" type="text" class="widefat" value="%3$s" /></p>',
				$this->get_field_id('title'),
				$this->get_field_name('title'),
				esc_attr(strip_tags( $instance['title']))
			);
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update($new_instance, $old_instance)
		{
		$instance = $old_instance;
		foreach ($new_instance as $key => $value) $instance[$key] = trim(strip_tags($new_instance[$key]));
		return $instance;
		}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget($args, $instance)
	{
		extract($args, EXTR_SKIP);

		$defaults = array('title' => $this->title);
		$instance = wp_parse_args($instance, $defaults);

		if(is_singular('post')) :

			echo $before_widget;

			if (!empty($instance['title'])) echo $before_title.$instance['title'].$after_title;

			global $post;
			$random_post = get_posts(array('orderby' => 'rand', 'numberposts' => 1, 'exclude' => $post->ID));
			$random_post_id = $random_post[0]->ID;
			?>

			<table class="blog-navigation">
				<tr>
					<td class="previous"><?php previous_post_link('%link', __( '<i class="icon-arrow-left"></i> Previous', 'euged' ) ); ?></td>
					<td class="next"><?php next_post_link('%link', __( 'Next <i class="icon-arrow-right"></i>', 'euged' ) ); ?></td>
				</tr>
			</table>

			<p class="random"><a href="<?php echo get_permalink($random_post_id) ?>"><?php _e( 'Random <i class="icon-random"></i>', 'euged') ?></a></p>

			<?php
			echo $after_widget;

		endif;
	}
}

add_action( 'widgets_init', create_function( '', 'register_widget( "WPBase_Browse_Blog" );' ) );