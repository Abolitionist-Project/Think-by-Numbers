<?php
/**
 * Social Icons Widget
 */
if (!class_exists('WPBase_Social_Icons'))
{
	class WPBase_Social_Icons extends WP_Widget
	{
		private $title;
		private $behance_url;
		private $deviantart_url;
		private $dribbble_url = 'http://dribbble.com/EugedLab';
		private $facebook_url = 'https://www.facebook.com/EugedLab';
		private $flickr_url;
		private $forrst_url;
		private $github_url;
		private $google_plus_url;
		private $instagram_url;
		private $lastfm_url;
		private $linkedin_url;
		private $pinterest_url;
		private $rss_url;
		private $soundcloud_url;
		private $tumblr_url;
		private $twitter_url = 'https://twitter.com/EugedLab';
		private $vimeo_url;
		private $wordpress_url;
		private $youtube_url;

		/**
		 * Register widget with WordPress.
		 */
		public function __construct()
		{
			parent::__construct(
				'social_icons', // Base ID
				'Social Icons', // Name
				// Args
				array(
					'classname' => __('widget_social_icons', 'wpbase'),
					'description' => __('A simple yet beautiful widget for displaying your social profiles as icons.', 'wpbase')
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
				'title'					=> $this->title,
				'behance_url'			=> $this->behance_url,
				'deviantart_url'		=> $this->deviantart_url,
				'dribbble_url'			=> $this->dribbble_url,
				'facebook_url'			=> $this->facebook_url,
				'flickr_url'			=> $this->flickr_url,
				'forrst_url'			=> $this->forrst_url,
				'github_url'			=> $this->github_url,
				'google_plus_url'		=> $this->google_plus_url,
				'instagram_url'			=> $this->instagram_url,
				'lastfm_url'			=> $this->lastfm_url,
				'linkedin_url'			=> $this->linkedin_url,
				'pinterest_url'			=> $this->pinterest_url,
				'rss_url'				=> $this->rss_url,
				'soundcloud_url'		=> $this->soundcloud_url,
				'tumblr_url'			=> $this->tumblr_url,
				'twitter_url'			=> $this->twitter_url,
				'vimeo_url'				=> $this->vimeo_url,
				'wordpress_url'			=> $this->wordpress_url,
				'youtube_url'			=> $this->youtube_url
			);
			$instance = wp_parse_args( $instance, $defaults );

			foreach ($defaults as $id => $field)
			{
				printf(
					'<p><label for="%1$s">%2$s:</label><input id="%1$s" name="%3$s" type="text" class="widefat" value="%4$s" /></p>',
					$this->get_field_id($id),
					ucwords( str_replace( '_', ' ', $id ) ),
					$this->get_field_name($id),
					esc_attr( strip_tags( $instance[$id] ) )
					);
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

			foreach ($new_instance as $key => $value)
			{
				$instance[$key] = trim( strip_tags( $new_instance[$key] ) );
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
				'title'					=> $this->title,
				'behance_url'			=> $this->behance_url,
				'deviantart_url'		=> $this->deviantart_url,
				'dribbble_url'			=> $this->dribbble_url,
				'facebook_url'			=> $this->facebook_url,
				'flickr_url'			=> $this->flickr_url,
				'forrst_url'			=> $this->forrst_url,
				'github_url'			=> $this->github_url,
				'google_plus_url'		=> $this->google_plus_url,
				'instagram_url'			=> $this->instagram_url,
				'lastfm_url'			=> $this->lastfm_url,
				'linkedin_url'			=> $this->linkedin_url,
				'pinterest_url'			=> $this->pinterest_url,
				'rss_url'				=> $this->rss_url,
				'soundcloud_url'		=> $this->soundcloud_url,
				'tumblr_url'			=> $this->tumblr_url,
				'twitter_url'			=> $this->twitter_url,
				'vimeo_url'				=> $this->vimeo_url,
				'wordpress_url'			=> $this->wordpress_url,
				'youtube_url'			=> $this->youtube_url
			);
			$instance = wp_parse_args( $instance, $defaults );

			$social_networks = array(
				'behance_url'			=> 'behance',
				'deviantart_url'		=> 'deviantart',
				'dribbble_url'			=> 'dribbble',
				'facebook_url'			=> 'facebook',
				'flickr_url'			=> 'flickr',
				'forrst_url'			=> 'forrst',
				'github_url'			=> 'github',
				'google_plus_url'		=> 'googleplus',
				'instagram_url'			=> 'instagram',
				'lastfm_url'			=> 'lastfm',
				'linkedin_url'			=> 'linkedin',
				'pinterest_url'			=> 'pinterest',
				'rss_url'				=> 'rss',
				'soundcloud_url'		=> 'soundcloud',
				'tumblr_url'			=> 'tumblr',
				'twitter_url'			=> 'twitter',
				'vimeo_url'				=> 'vimeo',
				'wordpress_url'			=> 'wordpress',
				'youtube_url'			=> 'youtube'
			);

			echo $before_widget;

			if (!empty($instance['title']))
				{
				echo $before_title.$instance['title'].$after_title;
				}

			global $Euged;

			echo '<ul>';
			foreach ($social_networks as $key => $name)
			{
				if (!empty($instance[$key]))
				{
					printf(
						'<li><a href="%s" class="social-icon %s" target="_blank">%s</a></li>',
						$Euged->parse_url($instance[$key]),
						strtolower( str_replace( array(' ', '.'), array('-', ''), $name ) ),
						'<i class="social-' . $name . '"></i>'
					);
				}
			}
			echo '</ul>';

			echo $after_widget;
		}
	}
	add_action( 'widgets_init', create_function( '', 'register_widget( "WPBase_Social_Icons" );' ) );
}