<?php
class WPBase_Post_Format_Archives extends WP_Widget
{
	private $title				= "Post Format Archives";

	// Register
	public function __construct()
	{
		parent::__construct(
			'euged_post_format_archives', // Base ID
			'Post Format Archives', // Name
			// Args
			array(
				'classname' => __('widget_post_format_archive', 'wpbase'),
				'description' => __('Display links to the various post format archives', 'wpbase')
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

		echo $before_widget;

		if (!empty($instance['title']))
			{
			echo $before_title.$instance['title'].$after_title;
			}

		$formats = get_terms('post_format');

		//print_r($formats);

		if($formats)
			{
			echo '<ul>';
			foreach($formats as $format) :

				echo '<li class="'.strtolower($format->name).'">';
				euged_post_format_icon(strtolower($format->name));
				echo '<a href="'.get_post_format_link($format->name).'" title="'.$format->name.'">'.$format->name.'</a>';
				echo '<span class="post-count">'.$format->count.'</span>';
				echo '</li>';

			endforeach;
			echo '</ul>';
			}
		else
			{
			echo '<p class="notice warning">No post formats to show</p>';
			}

		echo $after_widget;
	}
}

add_action( 'widgets_init', create_function( '', 'register_widget( "WPBase_Post_Format_Archives" );' ) );