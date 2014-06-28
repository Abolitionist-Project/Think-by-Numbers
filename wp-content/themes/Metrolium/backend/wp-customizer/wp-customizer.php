<?php
/**
 * Contains methods for customizing the theme customization screen.
 *
 * @link http://codex.wordpress.org/Theme_Customization_API
 * @since Euged 1.1
 */
class Euged_WP_Customizer
{
	public $customizer_options;

	public function __construct()
	{
		require dirname(dirname(dirname(__FILE__))) . '/includes/wp-customizer/config.php';
		$this->customizer_options = $customizer_options;
	}

	/**
	* Dynamic Register Function
	*
	* @see add_action('customize_register',$func)
	* @param \WP_Customize_Manager $wp_customize
	* @since Euged 1.1
	*/
	public function register($wp_customize)
	{
		require_once dirname(__FILE__) . '/extends/textarea.php';

		$ewpc = new Euged_WP_Customizer();
		//$ewpc->generate_live_preview_js();

		//$wp_customize->remove_section('background_image');
		$wp_customize->remove_section('colors');
		$wp_customize->remove_section('header_image');
		$wp_customize->remove_section('nav');
		$wp_customize->remove_section('static_front_page');
		$wp_customize->remove_section('title_tagline');

		$default_wp_sections = array('title_tagline', 'colors', 'header_image', 'background_image', 'nav', 'static_front_page');
		$default_wp_controls = array('text', 'checkbox', 'radio', 'select');
		$added_sections = array();

		$priority = 0;

		foreach($ewpc->customizer_options as $section => $options)
		{
			foreach($options as $option['id'] => $option)
			{
				$option['type']			= !empty($option['type']) ? $option['type'] : 'theme_mod';
				$option['label']		= !empty($option['label']) ? $option['label'] : ucwords(str_replace('_', ' ', $option['id']));
				$option['id']			= 'euged_' . $section . '[' . $option['id'] . ']';
				$option['capability']	= !empty($option['capability']) ? $option['capability'] : 'edit_theme_options';
				$option['sanitize_callback'] = array(
					'text'			=> 'sanitize_text_field',
					'color_picker'	=> 'sanitize_hex_color'
				);

				// Add Section
				if ( !in_array($section, $default_wp_sections) && !in_array($section, $added_sections))
				{
					$wp_customize->add_section( $section , array( 'title' => ucwords(str_replace('_', ' ', $section) ), 'priority' => ++$priority ) );
					array_push($added_sections, $section);
				}

				// Add Setting
				$wp_customize->add_setting(
					$option['id'],
					array(
						'default'			=> !empty($option['default']) ? $option['default'] : NULL,
						'type'				=> $option['type'],
						'capability'		=> $option['capability'],
						'transport'			=> !empty($option['transport']) ? $option['transport'] : 'postMessage'
					)
				);

				// Add Control
				if (in_array($option['control'], $default_wp_controls))
				{
					$wp_customize->add_control(
						$option['id'],
						array(
							'label'		=> $option['label'],
							'type'		=> $option['control'],
							'choices'	=> !empty($option['options']) ? $option['options'] : NULL,
							'section'	=> $section,
							'priority'	=> ++$priority,
							'sanitize_callback' => !empty($option['sanitize_callback'][$option['control']]) ? $option['sanitize_callback'][$option['control']] : NULL
						)
					);
				}
				else
				{
					switch($option['control'])
					{
						case 'color_picker':
							$wp_customize->add_control(
								new WP_Customize_Color_Control(
									$wp_customize,
									$option['id'],
									array(
										'label'		=> $option['label'],
										'section'	=> $section,
										'settings'	=> $option['id'],
										'priority'	=> ++$priority
									)
								)
							);
							break;
						case 'image_upload':
							$wp_customize->add_control(
								new WP_Customize_Image_Control(
									$wp_customize,
									$option['id'],
									array(
										'label'		=> $option['label'],
										'section'	=> $section,
										'settings'	=> $option['id'],
										'priority'	=> ++$priority
									)
								)
							);
							break;
						case 'file_upload':
							$wp_customize->add_control(
								new WP_Customize_Upload_Control(
									$wp_customize,
									$option['id'],
									array(
										'label'		=> $option['label'],
										'section'	=> $section,
										'settings'	=> $option['id'],
										'priority'	=> ++$priority
									)
								)
							);
							break;
						case 'textarea':
							$wp_customize->add_control(
								new Euged_Customize_Textarea_Control(
									$wp_customize,
									$option['id'],
									array(
										'label'		=> $option['label'],
										'section'	=> $section,
										'settings'	=> $option['id'],
										'priority'	=> ++$priority
									)
								)
							);
							break;
					}
				}
			}
		}
	}

	/**
	 * Generates WP Customizer override CSS
	 *
	 * @access public
	 * @return void
	 */
	public function generate_css()
	{
		$css = array();
		$custom_overrides = array();

		foreach($this->customizer_options as $section => $options)
		{
			foreach($options as $option['id'] => $option)
			{
				if (array_key_exists('actions', $option))
				{
					foreach($option['actions'] as $action)
					{
						if (!empty($action['attribute']))
						{
							if (empty($custom_overrides[$section]))
							{
								$option['type'] = !empty($option['type']) ? $option['type'] : 'theme_mod';
								if ($option['type'] == 'option')
								{
									$custom_overrides[$section] = get_option('euged_' . $section);
								}
								else
								{
									$custom_overrides[$section] = get_theme_mod('euged_' . $section);
								}
							}

							$value = !empty($custom_overrides[$section][$option['id']]) ? $custom_overrides[$section][$option['id']] : $option['default'];

							$css[$action['selector']][$action['attribute']] = $value;
						}
					}
				}
			}
		}

		$compiled_css = "";
		foreach($css as $selector => $attributes)
		{
			$i = 0;
			$compiled_css .= $selector . " {";
			foreach($attributes as $attribute => $value)
			{
				$compiled_css .= ++$i != 1 ? ";" : "";
				$compiled_css .= $attribute == 'font-family' ? $attribute . ":'" . $value . "', Arial,Helvetica,sans-serif" : $attribute . ":" . $value;
			}
			$compiled_css .= "}";
		}

		if( is_multisite() )
		{
			$file_name = sprintf( '%s/assets/css/skin-override-%s.css', get_template_directory(), get_current_blog_id() );
		}
		else
		{
			$file_name = sprintf( '%s/assets/css/skin-override.css', get_template_directory() );
		}

		file_put_contents( $file_name, $compiled_css, LOCK_EX );
	}

	/**
	 * Generates WP Customizer live preview JS
	 *
	 * @access public
	 * @return void
	 */
	public function generate_live_preview_js()
	{
		$jquery_actions = array(
			'background-color'	=> ".css('background-color',newval)",
			'color'				=> ".css('color',newval)",
			'font-size'			=> ".css('font-size',newval)",
			'max-width'			=> ".css('max-width',newval)",
			'border-color'		=> ".css('border-color',newval)",
			'font-family'		=> ".css('font-family',newval)",
			'html'				=> ".html(newval)",
			'toggle'			=> ".toggle()",
			'class'				=> '.attr(\'class\',newval)'
		);

		$js = "(function($){";

		foreach($this->customizer_options as $section => $options)
		{
			foreach($options as $option['id'] => $option)
			{
				if (!empty($option['transport']) && $option['transport'] == 'refresh')
				{
					continue;
				}

				if (array_key_exists('actions', $option))
				{
					$option['id'] = 'euged_' . $section . '[' . $option['id'] . ']';
					foreach($option['actions'] as $action)
					{
						if (!empty($action['selector']))
						{
							$js .= sprintf(
								"wp.customize('%s',function(v){v.bind(function(newval){\$('%s')%s;});});",
								$option['id'],
								$action['selector'],
								!empty($action['jquery']) ? $jquery_actions[$action['jquery']] : $jquery_actions[$action['attribute']]
							);

							if (!empty($action['google_link_id']))
							{
								$js .= sprintf(
									"wp.customize('%s',function(v){v.bind(function(newval){\$('%s')%s;});});",
									$option['id'],
									$action['google_link_id'],
									".attr('href', 'http://fonts.googleapis.com/css?family=' + newval.replace(' ','+'));"
								);
							}
						}
					}
				}
			}
		}

		$js .= "})(jQuery);";

		file_put_contents( get_template_directory() . '/includes/wp-customizer/live-preview.js', $js, LOCK_EX );
	}

	/**
	* This outputs the javascript needed to automate the live settings preview.
	* Also keep in mind that this function isn't necessary unless your settings
	* are using 'transport'=>'postMessage' instead of the default 'transport'
	* => 'refresh'
	*
	* Used by hook: 'customize_preview_init'
	*
	* @see add_action('customize_preview_init',$func)
	* @since MyTheme 1.0
	*/
	public static function enqueue_live_preview()
	{
		$theme = wp_get_theme();

		wp_enqueue_script(
			'euged-wp-customizer', //Give the script an ID
			get_template_directory_uri() . '/includes/wp-customizer/live-preview.js', //Define it's JS file
			array( 'jquery','customize-preview' ), //Define dependencies
			$theme['Version'], //Define a version (optional)
			true //Specify whether to put in footer (leave this true)
		);
	}

	/**
	 * Updates theme mod with unix timestamp of when WP Customizer was last saved
	 *
	 * @access public
	 * @return void
	 */
	public function update_save_timestamp()
	{
		$now = new DateTime();
		set_theme_mod('wp_customizer_last_saved', $now->format('U'));
	}

	/**
	 * Checks if the wp customizer generated CSS is out of date
	 *
	 * @access public
	 * @return void
	 */
	public function check_if_css_is_out_of_date()
	{
		$theme_mods = get_theme_mods();

		if (empty($theme_mods['wp_customizer_css_version']) || empty($theme_mods['wp_customizer_last_saved']) || $theme_mods['wp_customizer_css_version'] != $theme_mods['wp_customizer_last_saved'])
		{
			if (empty($theme_mods['wp_customizer_last_saved']))
			{
				$now = new DateTime();
				set_theme_mod('wp_customizer_last_saved', $now->format('U'));
				$theme_mods['wp_customizer_last_saved'] = $now->format('U');
			}

			$ewpc = new Euged_WP_Customizer();
			$ewpc->generate_css();
			set_theme_mod('wp_customizer_css_version', $theme_mods['wp_customizer_last_saved']);
		}
	}
}

// Setup the Theme Customizer settings and controls...
add_action( 'customize_register' , array( 'Euged_WP_Customizer' , 'register' ) );

// Output custom CSS to live site
//add_action( 'wp_head' , array( 'Euged_WP_Customizer' , 'header_output' ) );

// Enqueue live preview javascript in Theme Customizer admin screen
add_action( 'customize_preview_init' , array( 'Euged_WP_Customizer' , 'enqueue_live_preview' ) );

// Update timestamp on save
add_action( 'customize_save' , array( 'Euged_WP_Customizer' , 'update_save_timestamp' ) );

// Check if CSS is out of date
add_action( 'init' , array( 'Euged_WP_Customizer' , 'check_if_css_is_out_of_date' ) );