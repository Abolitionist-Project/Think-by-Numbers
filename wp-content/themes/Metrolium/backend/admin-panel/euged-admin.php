<?php
class Euged_theme_options
{
	public function __construct()
	{
		add_action('admin_menu', array($this, 'register_theme_options_page'));
		add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));

		if (!empty($_POST[sanitize_key('euga')]))
		{
			$this->save_options($_POST[sanitize_key('euga')]);
		}

		if (!empty($_GET[sanitize_key('euga-reset')]))
		{
			$this->reset_options();
		}
	}

	/**
	 * Register Theme Options Page
	 *
	 * @access public
	 * @return void
	 */
	public function register_theme_options_page()
	{
		$this->saved_options = get_option('euga_options');
		if (!empty($this->saved_options))
		{
			$this->saved_options = json_decode($this->saved_options, true);
		}

		add_theme_page(
			'Theme Options', // Page Title
			'Theme Options', // Menu Title
			'add_users', // Capability
			basename(__FILE__), // Menu Slug
			array($this, 'render_admin') // Function
		);

		require dirname(dirname(dirname(__FILE__))) . '/includes/admin-panel/config.php';
		$this->theme_options = $theme_options;
	}

	/**
	 * Render Theme Options Page
	 *
	 * @access public
	 * @return void
	 */
	public function render_admin()
	{
		$this->load_view('header');
		$this->load_view('sidebar', $this->theme_options);

		foreach($this->theme_options as $section => $options)
		{
			if ($section == 'welcome')
			{
				global $global_admin_options;
				if (!empty($global_admin_options['welcome_hide'])) {
					continue;
				}
			}

			echo '<div id="' . $section . '">';


			if ($section == 'sidebars')
			{
				$this->render_sidebar_control($options['default']);
				echo '</div>';
				continue;
			}

			foreach($options as $option['id'] => $option)
			{
				$option['name']			= 'euga[' . $section . '_' . $option['id'] . ']';
				$option['label']		= !empty($option['label']) ? $option['label'] : ucwords(str_replace('_', ' ', $option['id']));
				$option['default']		= !empty($option['default']) ? $option['default'] : NULL;
				$option['value']		= !empty($this->saved_options[$section . '_' . $option['id']]) ? $this->saved_options[$section . '_' . $option['id']] : $option['default'];
				$option['id']			= 'euga_' . $option['id'];
				$option['capability']	= !empty($option['capability']) ? $option['capability'] : 'edit_theme_options';
				$option['sanitize_callback'] = array(
					'text'			=> 'sanitize_text_field',
					'color_picker'	=> 'sanitize_hex_color'
				);

				switch($option['control'])
				{
					case 'text':
						$this->render_text($option['id'], $option['name'], $option['label'], $option['value']);
						break;
					case 'textarea':
						$this->render_textarea($option['id'], $option['name'], $option['label'], $option['value'], $option['rows']);
						break;
					case 'select':
						$this->render_select($option['id'], $option['name'], $option['options'], $option['label'], $option['value']);
						break;
					case 'checkbox':
						$this->render_checkbox($option);
						break;
					case 'radio':
						$this->render_radio($option);
						break;
					case 'html':
						$this->render_html($option['content']);
						break;
				}
			}

			echo '</div>';
		}

		$this->load_view('footer');
	}

	/**
	 * Enqueue Plugin Required JavaScript
	 *
	 * @access public
	 * @return void
	 */
	public function enqueue_scripts()
	{
		if (get_current_screen()->id == 'appearance_page_euged-admin')
		{
			wp_register_script(
				'ead-upload',
				get_template_directory_uri() . '/backend/admin-panel/assets/js/upload.js',
				array('jquery','media-upload','thickbox')
			);

			wp_register_script(
				'ead-script',
				get_template_directory_uri() . '/backend/admin-panel/assets/js/script.js'
			);

			wp_register_style(
				'jquery-ui-css',
				'http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css'
			);

			wp_register_style(
				'ead-style',
				get_template_directory_uri() . '/backend/admin-panel/assets/css/style.css'
			);

			wp_register_style(
				'font-awesome',
				get_template_directory_uri() . '/assets/css/libs/fontawesome/font-awesome.css'
			);

			wp_enqueue_script('jquery');
			wp_enqueue_script('jquery-ui-tabs');
			wp_enqueue_script('jquery-ui-sortable');

			wp_enqueue_style('ead-style');
			wp_enqueue_style('font-awesome');

			wp_enqueue_script('thickbox');
			wp_enqueue_style('thickbox');

			wp_enqueue_script('media-upload');
			wp_enqueue_script('ead-upload');
			wp_enqueue_script('ead-script');
		}
	}

	/**
	 * Reset theme options back to default
	 *
	 * @access private
	 * @return void
	 */
	private function reset_options()
	{
		delete_option('euga_options');
	}

	/**
	 * Load View
	 *
	 * @access private
	 * @param string $view View filename
	 * @param mixed $data optional Any data to be used by the view
	 * @return void
	 */
	private function load_view($view, $data = null)
	{
		require_once dirname(__FILE__) . '/views/' . $view . '.php';
	}

	/**
	 * Save Options
	 *
	 * @access private
	 * @param array $options
	 * @return void
	 */
	private function save_options($options)
	{
		require dirname(dirname(dirname(__FILE__))) . '/includes/admin-panel/config.php';

		foreach ($theme_options as $section => $os)
		{
			foreach($os as $option['id'] => $option)
			{
				if (!empty($option['control'])) {
					$option_control[$section . '_' . $option['id']] = $option['control'];
				}
			}
		}

		$options = stripslashes_deep($options);

		foreach ($options as $key => $option)
		{
			if (!empty($option_control[$key]))
			{
				if ($option_control[$key] == 'text') {
					$options[$key] = sanitize_text_field($option);
				}
				else if ($option_control[$key] == 'textarea') {
					$options[$key] = esc_textarea($option);
				} else if ($option_control[$key] == 'checkbox') {
					$options[$key] = true;
				}
			}
		}

		$options = json_encode($options);

		if (get_option('euga_options') != $options)
		{
			update_option('euga_options', $options);
		}
		else
		{
			$deprecated = '';
			$autoload = 'yes';
			add_option('euga_options', $options, $deprecated, $autoload);
		}
	}

	/**
	 * Render Text Form Element
	 *
	 * @access private
	 * @param string $id
	 * @param string $name
	 * @param string $label
	 * @param string $value optional
	 * @return void
	 */
	private function render_text($id, $name, $label, $value = null)
	{
		printf('<div class="euged-control euged-control-text"><label><span class="euged-control-title">%s</span><input type="text" id="%s" name="%s" value="%s"></label></div>',
				esc_html($label),
				esc_attr($id),
				esc_attr($name),
				esc_attr($value)
			);
	}

	/**
	 * Render Textarea Form Element
	 *
	 * @access private
	 * @param string $id
	 * @param string $name
	 * @param string $label
	 * @param string $rows
	 * @param string $value optional
	 * @return void
	 */
	private function render_textarea($id, $name, $label, $value = null, $rows = 4)
	{
		printf('<div class="euged-control euged-control-textarea"><label><span class="euged-control-title">%s</span><textarea type="text" id="%s" name="%s" rows="%s">%s</textarea></label></div>',
				esc_html($label),
				esc_attr($id),
				esc_attr($name),
				esc_attr($rows),
				esc_attr($value)
			);
	}

	/**
	 * Render Select Form Element
	 *
	 * @access private
	 * @param string $id
	 * @param string $name
	 * @param array $options
	 * @param string $label
	 * @param string $value optional
	 * @return void
	 */
	private function render_select($id, $name, $options, $label, $value = null)
	{
		$opts = "";
		foreach ($options as $v => $o)
		{
			$opts .= sprintf('<option value="%s"%s>%s</option>',
					esc_attr($v),
					$value == $v ? ' selected="selected"' : NULL,
					esc_html($o)
				);
		}

		printf('<div class="euged-control euged-control-text"><label><span class="euged-control-title">%s</span>
				<select id="%s" name="%s">%s</select></label></div>',
				esc_html($label),
				esc_attr($id),
				esc_attr($name),
				$opts
			);
	}

	/**
	 * Render Checkbox Form Element
	 *
	 * @access private
	 * @param object $option
	 * @return void
	 */
	private function render_checkbox($option)
	{
		printf('<div class="euged-control euged-control-checkbox"><label><span class="euged-control-title">%s</span><input type="checkbox" value="%s" %s name="%s"></label></div>',
				esc_html($option['label']),
				esc_attr($option['value']),
				checked($option['value'], true, false),
				esc_attr($option['name'])
			);
	}

	/**
	 * Render Radio Form Element
	 *
	 * @access private
	 * @param object $option
	 * @return void
	 */
	private function render_radio($option)
	{
		if (empty($option['options']))
		{
			return;
		}

		$control = '<div class="euged-control euged-control-radio"><span class="euged-control-title">' . esc_html($option['label']) . '</span>';

		foreach ( $option['options'] as $value => $label )
		{
			$control .= sprintf(
				'<label><input type="radio" value="%s" name="%s" %s><br></label>',
				esc_attr($value),
				esc_attr($option['name']),
				checked($option['value'], $value, false),
				esc_html($label)
			);
		}

		$control .= '</div>';

		echo $control;
	}

	/**
	 * Render Sidebar Control
	 *
	 * @access private
	 * @param array $sidebars optional
	 * @return void
	 */
	private function render_sidebar_control($sidebars = null)
	{
		if (empty($sidebars))
		{
			return;
		}

		$sidebars = !empty($this->saved_options['sidebars']) ? $this->saved_options['sidebars'] : implode(',', $sidebars);

		foreach (explode(',', $sidebars) as $id)
		{
			$data['sidebars'][$id] = ucwords( str_replace( '-', ' ', $id ) );
		}

		$this->load_view('sidebars', $data);
	}

	/**
	 * Render plain text / html
	 *
	 * @access private
	 * @param string $content
	 * @return void
	 */
	private function render_html($content)
	{
		printf('<div class="euged-control euged-control-html">%s</div>', $content);
	}
}
new Euged_theme_options();