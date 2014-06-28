<?php
/**
 * Adds 'Recent Tweets' widget
 *
 * Fetch and display your recent tweets from the Twitter API
 */
class WPBase_Twitter_Feed extends WP_Widget
{
	private $title					= "Recent Tweets";
	private $twitter_username		= "";
	private $number_of_tweets		= "2";
	private $consumer_key			= "";
	private $consumer_secret		= "";
	private $access_token			= "";
	private $access_token_secret	= "";

	/**
	 * Register widget with WordPress.
	 */
	public function __construct()
	{
		parent::__construct(
			'euged_twitter_feed', // Base ID
			'Recent Tweets', // Name
			// Args
			array(
				'classname' => __('widget_twitter_feed', 'wpbase'),
				'description' => __('Show your most recent tweets.', 'wpbase')
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
		if( !function_exists('curl_version') )
		{
			_e('CURL extension not found. You need enable it to use this Widget', 'euged');
			return;
		}

		$defaults = array(
			'title'					=> $this->title,
			'twitter_username'		=> $this->twitter_username,
			'number_of_tweets'		=> $this->number_of_tweets,
			'consumer_key'			=> $this->consumer_key,
			'consumer_secret'		=> $this->consumer_secret,
			'access_token'			=> $this->access_token,
			'access_token_secret'	=> $this->access_token_secret
		);
		$instance = wp_parse_args( $instance, $defaults );

		printf(
				'<p><label for="%1$s">Title:</label><input id="%1$s" name="%2$s" type="text" class="widefat" value="%3$s" /></p>',
				$this->get_field_id('title'),
				$this->get_field_name('title'),
				esc_attr( strip_tags( $instance['title'] ) )
			);

		printf(
				'<p><label for="%1$s">Twitter Username:</label><input id="%1$s" name="%2$s" type="text" class="widefat" value="%3$s" /></p>',
				$this->get_field_id('twitter_username'),
				$this->get_field_name('twitter_username'),
				esc_attr( strip_tags( $instance['twitter_username'] ) )
			);

		printf(
				'<p><label for="%1$s">Number of Tweets:</label><input id="%1$s" name="%2$s" type="text" class="widefat" value="%3$s" /></p>',
				$this->get_field_id('number_of_tweets'),
				$this->get_field_name('number_of_tweets'),
				esc_attr( strip_tags( $instance['number_of_tweets'] ) )
			);

		printf(
				'<p><label for="%1$s">Consumer key:</label><input id="%1$s" name="%2$s" type="text" class="widefat" value="%3$s" /></p>',
				$this->get_field_id('consumer_key'),
				$this->get_field_name('consumer_key'),
				esc_attr( strip_tags( $instance['consumer_key'] ) )
			);

		printf(
				'<p><label for="%1$s">Consumer secret:</label><input id="%1$s" name="%2$s" type="text" class="widefat" value="%3$s" /></p>',
				$this->get_field_id('consumer_secret'),
				$this->get_field_name('consumer_secret'),
				esc_attr( strip_tags( $instance['consumer_secret'] ) )
			);

		printf(
				'<p><label for="%1$s">Access token:</label><input id="%1$s" name="%2$s" type="text" class="widefat" value="%3$s" /></p>',
				$this->get_field_id('access_token'),
				$this->get_field_name('access_token'),
				esc_attr( strip_tags( $instance['access_token'] ) )
			);

		printf(
				'<p><label for="%1$s">Access token secret:</label><input id="%1$s" name="%2$s" type="text" class="widefat" value="%3$s" /></p>',
				$this->get_field_id('access_token_secret'),
				$this->get_field_name('access_token_secret'),
				esc_attr( strip_tags( $instance['access_token_secret'] ) )
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
			'twitter_username'		=> $this->twitter_username,
			'number_of_tweets'		=> $this->number_of_tweets,
			'consumer_key'			=> $this->consumer_key,
			'consumer_secret'		=> $this->consumer_secret,
			'access_token'			=> $this->access_token,
			'access_token_secret'	=> $this->access_token_secret
		);
		$instance = wp_parse_args( $instance, $defaults );

		if( !function_exists('curl_version') )
		{
			echo '<p class="notice error">'.__('CURL extension not found. You need enable it to use this Widget', 'euged').'</p>';
			return;
		}

		if( !class_exists( 'TwitterOAuth' ) )
		{
			require_once dirname(dirname(__FILE__)).'/twitteroauth.php';
		}

		echo $before_widget;

		if (!empty($instance['title']))
			{
			echo $before_title.$instance['title'].$after_title;
			}

		// Reset Transition (development only)
		//delete_transient('euged_twitter_feed_cache');

		// Get the caches data
		$twitter_feed_cache = get_transient('euged_twitter_feed_cache');

		// If it's empty, re-create the data and set a new transient
		if( empty($twitter_feed_cache) )
		{
			$connection = new TwitterOAuth($instance['consumer_key'], $instance['consumer_secret'], $instance['access_token'], $instance['access_token_secret']);
			$request = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$instance['twitter_username']."&count=".$instance['number_of_tweets']);

			if( !isset($request->errors) )
			{
				$twitter_feed_cache = $request;
				set_transient( 'euged_twitter_feed_cache', $twitter_feed_cache, 60*10 ); // 10 minutes
			}
		}

		if( !empty($twitter_feed_cache) )
		{
			// Output Tweets
			foreach($twitter_feed_cache as $tweet)
			{
				// Parse @id
				$output = preg_replace( '/@(\w+)/', ' @<a href="http://twitter.com/$1" class="at">$1</a>',$tweet->text );

				// Parse #hashtag
				$output = preg_replace( '/\s#(\w+)/', ' <a href="http://twitter.com/#!/search?q=%23$1" class="hashtag">#$1</a>', $output );

				// Convert string links to anchors
				$output = make_clickable($output);
				$output = preg_replace('/<a /', '<a target="_blank" ', $output);

				global $Euged;

				printf(
					'<div class="tweet detail"><p class="content">%s</p><p class="meta"><a href="http://twitter.com/%s/status/%s" target="_blank">%s</a></p></div>',
					$output,
					$tweet->user->screen_name,
					$tweet->id_str,
					$Euged->human_date( strtotime( $tweet->created_at ) )
				);
			}

			printf(
				'<a href="http://www.twitter.com/%s" title="'.__( 'Follow us on Twitter', 'euged' ).'" target="_blank" class="follow"><i class="icon-twitter"></i> '.__( 'Follow us on Twitter', 'euged' ).'</a>',
				$instance['twitter_username']
			);
		}
		else
		{
			echo '<p class="notice error">'.__('An error has occured fetching your tweets, please double check all widget settings', 'euged').' ['.$request->errors[0]->code.']</p>';
		}

		echo $after_widget;
	}
}

add_action( 'widgets_init', create_function( '', 'register_widget( "WPBase_Twitter_Feed" );' ) );