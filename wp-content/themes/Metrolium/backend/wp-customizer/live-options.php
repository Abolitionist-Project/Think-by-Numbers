<?php
/**
 * Dynamically generates dummy WP Customizer on frontend for demonstration purposes
 *
 * @since Euged 1.1
 */
class Euged_Live_Options
{
	public $customizer_options;
	private $path;

	public function __construct()
	{
		$this->path = dirname(dirname(dirname(__FILE__))) . '/includes/wp-customizer';
		require  $this->path . '/config.php';
		if (!empty($customizer_options)) {
			$this->customizer_options = $customizer_options;
			$this->render();
		}
		//$this->generate_live_options_js();
	}

	private function render()
	{
		if (empty($this->customizer_options) || !is_array($this->customizer_options)) {
			return;
		}

		$html = '';

		foreach($this->customizer_options as $section => $options)
		{
			$html.= '<li><a href="#" class="lo-title">' . ucwords( str_replace('_', ' ', $section) ) . '<i class="icon-chevron-down"></i></a><ul>';

			foreach($options as $option['id'] => $option)
			{
				$option['name']			= 'euga[' . $section . '_' . $option['id'] . ']';
				$option['label']		= !empty($option['label']) ? $option['label'] : ucwords(str_replace('_', ' ', $option['id']));
				$option['default']		= !empty($option['default']) ? $option['default'] : NULL;
				$option['value']		= $option['default'];
				$option['id']			= 'euged_' . $section . '_' . $option['id'];

				$html.= '<li>' . $this->render_control($option) . '</li>';
			}

			$html.= '</ul></li>';
		}

		require_once $this->path . '/live-options.php';
	}

	/**
	 * Generates WP Customizer live preview JS
	 *
	 * @access public
	 * @return void
	 */
	public function generate_live_options_js()
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

		$jquery_handlers = array(
			'text'			=> 'keyup',
			'textarea'		=> 'keyup',
			'select'		=> 'change',
			'radio'			=> 'change',
			'checkbox'		=> 'change'
		);


		$js = ";(function($){\$(document).ready(function(){";
		$js.= "$('#live-options-toggle').on('click', function(){\$('#live-options-toggle').hide(); $('#live-options').animate({left: 0}); $('body').addClass('live-options-active').animate({'padding-left': 225});$('header.main.follow').animate({left: 225}); return false; });";
		$js.= "$('#loclose').on('click',function(){\$('body').removeClass('live-options-active').animate({padding:0});$('header.main.follow').animate({left: 0});$('#live-options').animate({left:-225}, function(){\$('#live-options-toggle').show();}); $('body').animate({'padding-left': 0}); return false;});";
		$js.= "$('#loptions').accordion({heightStyle:\"content\",collapsible:true,active:0});";

		foreach($this->customizer_options as $section => $options)
		{
			foreach($options as $option['id'] => $option)
			{
				$option['id'] = 'euged_' . $section . '_' . $option['id'];
				if (array_key_exists('actions', $option))
				{
					foreach($option['actions'] as $action)
					{
						if (!empty($action['selector']))
						{
							if ($option['control'] == 'color_picker')
							{
								$js.= sprintf(
									"$('#%s').wpColorPicker({defaultColor:'%s',change:function(){\$('%s').css('%s',$('#%1\$s').wpColorPicker('color'))}});",
									$option['id'],
									$option['default'],
									$action['selector'],
									$action['attribute']
								);
							}
							else {
								$js .= sprintf(
									"$('#%s').on('%s',function(){var newval=$(this).val();$('%s')%s;});",
									$option['id'],
									$jquery_handlers[$option['control']],
									$action['selector'],
									!empty($action['jquery']) ? $jquery_actions[$action['jquery']] : $jquery_actions[$action['attribute']]
								);

								if (!empty($action['google_link_id']))
								{
									$js .= sprintf(
										"$('#%s').on('change',function(){var newval=$(this).val();$('%s')%s});",
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
		}

		$js .= "});})(jQuery);";

		file_put_contents( get_template_directory() . '/assets/js/live-options.js', $js, LOCK_EX );
	}

	private function render_control($option)
	{
		$id			= $option['id'];
		$name		= $option['name'];
		$options	= !empty($option['options']) ? $option['options'] : NULL;
		$label		= $option['label'];
		$value		= $option['value'];
		$rows		= !empty($option['rows']) ? $option['rows'] : NULL;

		switch($option['control'])
		{
			case 'text':
				return $this->render_text($id, $name, $label, $value);
				break;
			case 'textarea':
				return $this->render_textarea($id, $name, $label, $value, $rows);
				break;
			case 'select':
				return $this->render_select($id, $name, $options, $label, $value);
				break;
			case 'checkbox':
				return $this->render_checkbox($id, $name, $label, $value);
				break;
			case 'radio':
				return $this->render_radio($id, $name, $options, $label, $value);
				break;
			case 'color_picker':
				return $this->render_color_picker($id, $name, $label, $value);
				break;
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
		return sprintf('<div class="euged-control euged-control-text"><label><span class="euged-control-title">%s</span><input type="text" id="%s" name="%s" value="%s"></label></div>',
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
		return sprintf('<div class="euged-control euged-control-textarea"><label><span class="euged-control-title">%s</span><textarea type="text" id="%s" name="%s" rows="%s">%s</textarea></label></div>',
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
	 * @param array  $options
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

		return sprintf('<div class="euged-control euged-control-text"><label><span class="euged-control-title">%s</span>
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
	 * @param string $id
	 * @param string $name
	 * @param string $label
	 * @param string $value optional
	 * @return void
	 */
	private function render_checkbox($id, $name, $label, $value)
	{
		return sprintf('<div class="euged-control euged-control-checkbox"><label><input type="checkbox" value="%s" id="%s" name="%s" %s>%s</label></div>',
				esc_attr($value),
				esc_attr($id),
				esc_attr($name),
				checked($value, true, false),
				esc_html($label)
			);
	}

	/**
	 * Render Radio Form Element
	 *
	 * @access private
	 * @param string $id
	 * @param string $name
	 * @param array  $options
	 * @param string $label
	 * @param string $value optional
	 * @return void
	 */
	private function render_radio($id, $name, $options, $label, $value)
	{
		if (empty($options))
		{
			return;
		}

		$control = '<div class="euged-control euged-control-radio"><span class="euged-control-title">' . esc_html($label) . '</span><fieldset id="' . esc_attr($id) . '">';

		foreach ( $options as $v => $l )
		{
			$control .= sprintf(
				'<label><input type="radio" value="%s" name="%s" %s>%s</label><br>',
				esc_attr($v),
				esc_attr($name),
				checked($value, $v, false),
				esc_html($l)
			);
		}

		$control .= '</fieldset></div>';

		return $control;
	}

	/**
	 * Render Color Picker
	 *
	 * @access private
	 * @param object $option
	 * @return void
	 */
	private function render_color_picker($id, $name, $label, $value = null)
	{
		return sprintf('<div class="euged-control euged-control-color"><label><span class="euged-control-title">%s</span><input type="text" id="%s" name="%s" value="%s" class="color-picker-hex wp-color-picker"></label></div>',
				esc_html($label),
				esc_attr($id),
				esc_attr($name),
				esc_attr($value)
			);
	}
}
new Euged_Live_Options;