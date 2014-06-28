/**
 *	Dynamic Meta Box Options
 *	Copyright (c) 2013 David Knight - Euged.com
 *
 *	On change of the handler, show toggles if the condition element's value is not in the condition array
 *
 *	First level indexes are handler element ids to which change events should be bound.
 *	Each handler contains an object with two items; conditions and toggles.
 *	Conditions (element_id:array) is basically a list of elements whose value should not be in the array.
 *	Toggles are elements that should be shown is the handler conditions have all been met.
 *	Optionally, you may add additional conditions to specific toggles.
 *
 *	var controls = {
 *		'#hander_id': {
 *			'conditions': {
 *				'#show_toggles_if_this_element_value_is_not_found_in': ['value','array']
 *			},
 *			'toggles': {
 *				'#toggle_element_id': {
 *					// Optional: Additional Toggle Specific Conditions
 *					'#show_toggle_if_this_element_value_is_not_found_in': ['value','array']
 *				}
 *			},
 *		}
 *	}
 */

(function($) {

	/**
	 * Controls Object
	 */
	var controls = {
		// PAGE GENERAL

		// Breadcrumbs
		'#page_options_show_breadcrumbs': {
			'conditions': {
				'#page_options_show_breadcrumbs': [false],
				'#page_options_titlebar_style': ['hidden']
			},
			'toggles': {
				'#tr-page_options_breadcrumbs_position': {}
			}
		},
		// Sidebar
		'#page_options_sidebar': {
			'conditions': {
				'#page_options_sidebar': ['no-sidebar']
			},
			'toggles': {
				'#tr-page_options_sidebar_position': {}
			}
		},
		// Title Bar
		'#page_options_titlebar_style': {
			'conditions': {
				'#page_options_titlebar_style': ['hidden']
			},
			'toggles': {
				'#tr-page_options_breadcrumbs_position': {
					'#page_options_show_breadcrumbs': [false]
				},
				'#tr-page_options_slider_shortcode': {
					'#page_options_titlebar_style': ['titlebar-v1','hidden']
				},
				'#tr-page_options_show_subtitle': {
					'#page_options_titlebar_style': ['titlebar-slider']
				},
				'#tr-page_options_subtitle': {
					'#page_options_show_subtitle': [false],
					'#page_options_titlebar_style': ['titlebar-slider']
				},
				'#tr-page_options_titlebar_textalign': {
					'#page_options_titlebar_style': ['titlebar-slider']
				},
				'#tr-page_options_show_titlebar_cta': {
					'#page_options_titlebar_style': ['titlebar-slider'],
					'#page_options_titlebar_textalign_left': [false]
				},
				'#tr-page_options_titlebar_cta_link': {
					'#page_options_show_titlebar_cta': [false],
					'#page_options_titlebar_style': ['titlebar-slider']
				},
				'#tr-page_options_titlebar_cta_text': {
					'#page_options_show_titlebar_cta': [false],
					'#page_options_titlebar_style': ['titlebar-slider']
				}
			}
		},
		// Subtitle
		'#page_options_show_subtitle': {
			'conditions': {
				'#page_options_show_subtitle': [false],
				'#page_options_titlebar_style': ['titlebar-slider','hidden']
			},
			'toggles': {
				'#tr-page_options_subtitle': {},
				'#tr-page_options_subtitle_align': {}
			}

		},
		// Text Align
		'#page_options_titlebar_textalign_left,#page_options_titlebar_textalign_center': {
			'conditions': {
				'#page_options_titlebar_style': ['titlebar-slider','hidden'],
				'#page_options_titlebar_textalign_left': [false]
			},
			'toggles': {
				'#tr-page_options_show_titlebar_cta': {},
				'#tr-page_options_titlebar_cta_link': {
					'#page_options_show_titlebar_cta': [false]
				},
				'#tr-page_options_titlebar_cta_text': {
					'#page_options_show_titlebar_cta': [false]
				}
			}
		},
		// Subtitle CTA
		'#page_options_show_titlebar_cta': {
			'conditions': {
				'#page_options_titlebar_style': ['titlebar-slider','hidden'],
				'#page_options_show_titlebar_cta': [false],
				'#page_options_titlebar_textalign_left': [false]
			},
			'toggles': {
				'#tr-page_options_titlebar_cta_link': {},
				'#tr-page_options_titlebar_cta_text': {}
			}
		},

		// PORTFOLIO
		'#testimonial_show_testimonial': {
			'conditions': {
				'#testimonial_show_testimonial': [false]
			},
			'toggles': {
				'#tr-testimonial_author': {},
				'#tr-testimonial_author_role': {},
				'#tr-testimonial_content': {}
			}
		},
		'#portfolio_options_show_other_projects': {
			'conditions': {
				'#portfolio_options_show_other_projects': [false]
			},
			'toggles': {
				'#tr-portfolio_options_other_projects_order': {},
				'#tr-portfolio_options_other_project_count': {}
			}
		}
	};

	/**
	 * Helper Functions
	 */
	var helpers = {

		/**
		 * Checks if value is null.
		 *
		 * @param {mixed} a The value to check.
		 * @return {bool}
		 */
		is_null: function(a) {
			return (a === null);
		},

		/**
		 * Checks if value is undefined.
		 *
		 * @param {mixed} a The value to check.
		 * @return {bool}
		 */
		is_undefined: function(a) {
			return (this.is_null(a) || typeof a === 'undefined' || a === '' || a === 'undefined');
		},

		/**
		 * Checks if value exists in array.
		 *
		 * @param {string} needle The value to check for.
		 * @param {array} haystack The array to check in.
		 * @return {int} -1 if not found, otherwise index of found value.
		 */
		in_array: function(needle, haystack) {
			return haystack.indexOf(needle) >= 0 ? true : false;
		},

		/**
		 * Log value to console.
		 *
		 * @param {mixed} a The value to log to console.
		 * @return {void}
		 */
		debug: function(a) {
			window.console.log(a);
		}

	};

	/**
	 * Run initial toggle and bind change events
	 *
	 * @constructor
	 */
	function init() {
		// Run initial toggle
		toggle(controls);

		// Bind change events on controls to fire toggle
		$.each(controls, function(handler, config) {
			$(handler).on('change', function() {
				toggle({handler: config});
			});
		});
	}

	/**
	 * Checks if conditions have been met.
	 *
	 * @param {object} conditions The conditions object to be checked.
	 * @return {bool}
	 */
	function check_conditions(conditions) {
		var conditions_met = true;
		$.each(conditions, function(control, values) {
			var jcontrol = $(control);
			var value = jcontrol.val();

			if (jcontrol.is('input[type="checkbox"]') || jcontrol.is('input[type="radio"]')) {
				value = jcontrol.is(':checked');
			}

			if (conditions_met && helpers.in_array(value, values)) {
				conditions_met = false;
			}
		});
		return conditions_met;
	}

	/**
	 * Toggle (show|hide) controls.
	 *
	 * @param {object} controls The controls to toggle.
	 * @return {void}
	 */
	function toggle(controls) {
		$.each(controls, function(handler, config) {
			$.each(config.toggles, function(toggle, conditions) {
				var toggle_action = check_conditions(config.conditions);

				if (toggle_action && !helpers.is_undefined(conditions)) {
					toggle_action = check_conditions(conditions);
				}

				if (toggle_action) {
					$(toggle).show();
				} else {
					$(toggle).hide();
				}
			});
		});
	}

	$(document).ready(function() { init(); });

})(jQuery);