<?php
class WPBase_Photo_Stream extends WP_Widget
{
	private $title					= "Photo Stream";
	private $instagram_user_id		= "";
	private $number_of_photos		= "9";

	// Register
	public function __construct()
	{
		parent::__construct(
			'euged_photo_stream', // Base ID
			'Photo Stream', // Name
			// Args
			array(
				'classname' => __('widget_photo_stream', 'wpbase'),
				'description' => __('Display photos from a variety of online hosted solutions.', 'wpbase')
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
		$defaults = array('title' => $this->title, 'instagram_user_id' => $this->instagram_user_id, 'number_of_photos' => $this->number_of_photos);
		$instance = wp_parse_args( $instance, $defaults );

		printf(
				'<p><label for="%1$s">Title:</label><input id="%1$s" name="%2$s" type="text" class="widefat" value="%3$s" /></p>',
				$this->get_field_id('title'),
				$this->get_field_name('title'),
				esc_attr( strip_tags( $instance['title'] ) )
			);

		printf(
				'<p><label for="%1$s">Instagram User ID:</label><input id="%1$s" name="%2$s" type="text" class="widefat" value="%3$s" /></p>',
				$this->get_field_id('instagram_user_id'),
				$this->get_field_name('instagram_user_id'),
				esc_attr( strip_tags( $instance['instagram_user_id'] ) )
			);

		printf(
				'<p><label for="%1$s">Number of Photos:</label><input id="%1$s" name="%2$s" type="text" class="widefat" value="%3$s" /></p>',
				$this->get_field_id('number_of_photos'),
				$this->get_field_name('number_of_photos'),
				esc_attr( strip_tags( $instance['number_of_photos'] ) )
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

		$defaults = array(
			'title'					=> $this->title,
			'instagram_user_id'		=> $this->instagram_user_id,
			'number_of_photos'		=> $this->number_of_photos
		);
		$instance = wp_parse_args( $instance, $defaults );

		echo $before_widget;

		if (!empty($instance['title']))
			{
			echo $before_title.$instance['title'].$after_title;
			}

		// Get the caches data
		//$photo_stream_cache = get_transient('euged_photo_stream_cache');

		// If it's empty, re-create the data and set a new transient
		/*if (empty($photo_stream_cache))
			{
			$photo_stream_cache = json_decode(file_get_contents(''));
			set_transient('euged_photo_stream_cache', $photo_stream_cache, 60*10 ); // 10 minutes
			}*/

		// Output Photos
		//foreach($photo_stream_cache as $photo)
		//	{
		//	}

		echo '<p class="notice warning">Photostream functionality not finished yet</p>';

			/*echo '<ul>';
			$range = range(1,15);
			$i = 0;
			while(++$i <= $instance['number_of_photos'])
				{
				shuffle($range);
				$rand = $range[0];
				unset($range[0]);
				echo '<li><a href="#"><img src="'.get_bloginfo('template_url').'/assets/images/example/example_ps_'.$rand.'.jpg" alt="Placeholder" /></a></li>';
				}
			echo '</ul>';*/

		echo $after_widget;
	}
}

add_action( 'widgets_init', create_function( '', 'register_widget( "WPBase_Photo_Stream" );' ) );