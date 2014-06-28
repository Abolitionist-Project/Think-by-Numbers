<?php
/**
 * Recent Posts Widget
 *
 * Displays up to 5 recent entries from any post type and optionally displays featured images.
 *
 * @author David Knight <david.knight@euged.com>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
if (!class_exists('WPBase_Recent_Posts'))
{
	class WPBase_Recent_Posts extends WP_Widget
	{
		private $title;
		private $post_count = 3;
		private $post_type = "posts";
		//private $category = "all";
		private $order_by = "timestamp";
		private $show_images = false;
		private $show_post_date = false;

		private $fields = array(
			'title'				=> array('type' => 'text'),
			'post_count'		=> array('type' => 'select', 'options' => array(2 => 2, 3 => 3, 4 => 4, 5 => 5), 'label' => 'Number of posts to show'),
			'post_type'			=> array('type' => 'select'),
			//'category'		=> array('type' => 'text'),
			'order_by'			=> array('type' => 'select', 'label' => 'Order By', 'options' => array('post_date' => 'Post Date')),
			'show_images'		=> array('type' => 'checkbox'),
			'show_post_date'	=> array('type' => 'checkbox')
		);

		/**
		 * Register widget with WordPress.
		 */
		public function __construct()
		{
			parent::__construct(
				'recent_posts', // Base ID
				'Recent Posts', // Name
				// Args
				array(
					'classname' => __('widget_euged_recent_posts', 'wpbase'),
					'description' => __('Display your recent entries, optionally from a specific post format and/or category.', 'wpbase')
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
			$defaults = array(
				'title'				=> $this->title,
				'post_count'		=> $this->post_count,
				'post_type'			=> $this->post_type,
				//'category'		=> $this->category,
				'order_by'			=> $this->order_by,
				'show_images'		=> $this->show_images,
				'show_post_date'	=> $this->show_post_date
			);
			$instance = wp_parse_args( $instance, $defaults );

			$post_types = get_post_types();
			unset($post_types['attachment'], $post_types['attachment'], $post_types['revision'], $post_types['nav_menu_item']);
			foreach($post_types as $key => $post_type)
			{
				$post_types[$key] = ucwords($post_type);
			}
			$this->fields['post_type']['options'] = $post_types;

			foreach ($this->fields as $id => $field)
			{
				switch($field['type'])
				{
					case 'text':
						printf(
							'<p><label for="%s">%s:</label><input id="%1$s" name="%3$s" type="text" class="widefat" value="%4$s" /></p>',
							$this->get_field_id($id),
							!empty($field['label']) ? esc_html($field['label']) : ucwords( str_replace( '_', ' ', $id ) ),
							$this->get_field_name($id),
							esc_attr(strip_tags($instance[$id]))
							);
						break;
					case 'select':
						printf(
							'<p><label for="%s">%s:</label> <select id="%1$s" name="%3$s">',
							$this->get_field_id($id),
							!empty($field['label']) ? esc_html($field['label']) : ucwords( str_replace( '_', ' ', $id ) ),
							$this->get_field_name($id)
							);
						foreach ($field['options'] as $value => $option)
						{
							printf('<option value="%s"%s>%s</option>',
								esc_attr($value),
								selected($instance[$id], $value, false),
								esc_html($option)
								);
						}
						echo '</select></p>';
						break;
					case 'checkbox':
						printf('<p><label for="%2$s"><input class="checkbox" type="checkbox" %1$s id="%2$s" name="%3$s"> %4$s</label></p>',
							checked($instance[$id], true, false),
							$this->get_field_id($id),
							$this->get_field_name($id),
							!empty($field['label']) ? esc_html($field['label']) : ucwords( str_replace( '_', ' ', $id ) )
						);
						break;
				}
			}
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

			foreach ($this->fields as $key => $field)
			{
				if ($field['type'] == 'checkbox') {
					$instance[$key] = !empty($new_instance[$key]) ? true : false;
				} elseif (!empty($new_instance[$key])) {
					$instance[$key] = trim( strip_tags( $new_instance[$key] ) );
				}
			}

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
				'title'				=> $this->title,
				'post_count'		=> $this->post_count,
				'post_type'			=> $this->post_type,
				//'category'		=> $this->category,
				'order_by'			=> $this->order_by,
				'show_images'		=> $this->show_images,
				'show_post_date'	=> $this->show_post_date
			);
			$instance = wp_parse_args( $instance, $defaults );

			$args = array(
				'posts_per_page'	=> $instance['post_count'],
				'post_type'			=> $instance['post_type'],
				'orderby'			=> $instance['order_by'],
				'post_status' 		=> 'publish'
			);
			$query = new WP_Query($args);

			echo $before_widget;

			if (!empty($instance['title']))
			{
				echo $before_title . $instance['title'] . $after_title;
			}

			if ($query->have_posts())
			{
				echo '<ul>';

				while ($query->have_posts())
				{
					$query->the_post();
					$class = 'no-thumbnail';
					$thumbnail = '';
					$format = get_post_format();

					switch($format)
						{
						case 'audio' : $thumbnail_icon = 'volume-up'; break;
						case 'link' : $thumbnail_icon = 'link'; break;
						case 'quote' : $thumbnail_icon = 'quote-left'; break;
						case 'video' : $thumbnail_icon = 'play'; break;
						case 'image' : $thumbnail_icon = 'camera'; break;
						case 'gallery' : $thumbnail_icon = 'picture'; break;
						default : $thumbnail_icon = 'align-left';
						}

					if( $instance['show_images'] == true )
					{
						$class = 'has-thumbnail';
						$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ) );

						if( !empty( $thumbnail ) ) {
							$thumbnail = '<div class="thumbnail"><a href="'. get_permalink() .'"><img src="'. $thumbnail[0] .'"></a></div>';
						} elseif( get_post_type() == 'post' ) {
							$thumbnail = '<div class="thumbnail"><a href="'. get_permalink() .'"><i class="icon-'. $thumbnail_icon .'"></i></a></div>';
						} else {
							$class = 'no-thumbnail';
						}
					}

					echo '<li class="'. $class .'">';

					echo $thumbnail;

					echo '<a href="'. get_permalink() .'">'. get_the_title() .'</a>';

					if( $instance['show_post_date'] == true )
					{
						echo '<span class="post-date">'. get_the_date() .'</span>';
					}

					echo '</li>';
				}

				echo '</ul>';
			}

			echo $after_widget;
		}
	}
	add_action( 'widgets_init', create_function( '', 'register_widget( "WPBase_Recent_Posts" );' ) );
}