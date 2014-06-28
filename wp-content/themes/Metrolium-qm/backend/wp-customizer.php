<?php
/**
 * Contains QuantiModo-specific methods for customizing the theme customization screen. 
 *
 * @link http://codex.wordpress.org/Theme_Customization_API
 * @since Euged 1.1
 */
class QM_WP_Customizer
{
	public $customizer_options;

	public function __construct()
	{
		require get_stylesheet_directory() . '/includes/wp-customizer/config.php';
		$this->customizer_options = $customizer_options;
	}
	
	public function register($wp_customize)
	{
		$ewpc = new QM_WP_Customizer();

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
}

add_action( 'customize_register' , array( 'QM_WP_Customizer' , 'register' ) );