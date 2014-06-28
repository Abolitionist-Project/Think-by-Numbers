/*
 *	Mobile Menu jQuery Plugin
 *
 *	A simple, yet powerful mobile menu jQuery plugin that clones the markup of your existing main navigation and creates an app style mobile menu with side slide in and out. Powered by hardware accellerated CSS3 animations in modern browsers with jQuery fallback for older browsers that lack CSS3 support for the required attributes.
 *
 *	Demo's and documentation:
 *	http://www.euged.com/plugins/jquery/mobile-menu
 *
 *	Copyright (c) 2013 David Knight - Euged.com
 *
 *	Dual licensed under the MIT and GPL licenses.
 *	http://en.wikipedia.org/wiki/MIT_License
 *	http://en.wikipedia.org/wiki/GNU_General_Public_License
 */

;(function ( $, window, document, undefined ) {

	var plugin_name = "mobileMenu",
		defaults = {
			animate: true,					// Bool: Use CSS3 transitions
			transition: 300,				// Int: Speed of the transition in milliseconds
			target: '#mobile-menu',			// String: Mobile menu container id or class
			button: '#mobile-menu-toggle',	// String: Mobile menu button id or class
			label: 'Menu',					// String: Label for the navigation toggle
			move: ['#site'],				// Array: Element(s) to move when menu opens
			direction: 'right',				// String: Direction of animation
			insert: 'append',				// String: Whether to append or prepend the menu html
			button_show: '☰ Show Menu',		// String: Button text to display when menu is hidden
			button_hide: '☰ Hide Menu',		// String: Button text to display when menu is visible
			init: function(){},				// Function: Init callback
			open: function(){},				// Function: Open callback
			close: function(){}				// Function: Close callback
		};

	function Plugin( element, options ) {
		this.element = element;
		this.options = $.extend( {}, defaults, options );

		this._defaults = defaults;
		this._name = plugin_name;

		this.init();
	}

	Plugin.prototype = {

		init: function() {
			var that = this;

			// Setup jQuery Objects
			this.nav = $(this.element);
			this.mobile_menu = $(this.options.target);
			this.menu_button = $(this.options.button);
			this.move = $(this.options.move.join());

			// Add selector to elements that should be moved when menu is open
			this.move.addClass('mobile-menu-move');

			// Copy navigation to mobile menu
			if (this.options.insert === 'prepend') {
				this.mobile_menu.prepend(this.nav.html());
			} else {
				this.mobile_menu.append(this.nav.html());
			}

			// Bind Event Listeners
			this.menu_button.on('click', function(){
				that.toggle_menu();
				return false;
			});

			this.mobile_menu.find('li.has-sub-menu > a').on('click', function(){
				var sub_menu = $(this).parent().children('.sub-menu');
				if (sub_menu.is(':hidden')) {
					$(this).parent().addClass('sub-menu-open');
					sub_menu.slideDown();
				} else {
					sub_menu.slideUp();
				}
				return false;
			});

			$('body').on('transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd', function(e){
				if ('#' + e.target.id === that.options.move[0]) {
					if (that.mobile_menu.hasClass('mobile-menu-visible')) {
						// Run Open Callback
						that.menu_open(that);
					} else {
						// Run Close Callback
						that.menu_close(that);
					}
				}
			});
		},

		toggle_menu: function() {
			// Run Init Callback
			this.options.init();

			var that = this;

			this.move.toggleClass('mobile-menu-visible');
			this.mobile_menu.toggleClass('mobile-menu-visible');

			if (!this.browser.supports('transition') || !this.browser.supports('transform')) {
				if (this.mobile_menu.hasClass('mobile-menu-visible')) {
					this.move.animate({
						'margin-left': this.mobile_menu.width()
					}, 400, 'swing', function(){ that.menu_open(that); });
				} else {
					this.move.animate({
						'margin-left': 0
					}, 400, 'swing', function(){ that.menu_close(that); });
				}
			}

			if (!this.mobile_menu.hasClass('mobile-menu-visible')) {
				this.menu_button.html(this.options.button_show);
			}
		},

		menu_open: function(that) {
			that.mobile_menu.css('z-index','9999');
			$('html,body').css('overflow', 'hidden');
			/*
			$(document).on('touchmove', function(e){
				if ($(e.target).parents(that.options.target).length === 0) {
					e.preventDefault();
					e.stopPropagation();
				}
			});
			*/
			that.menu_button.html(that.options.button_hide);
			that.options.open();
		},

		menu_close: function(that) {
			that.mobile_menu.css('z-index','-1');
			$('html,body').css('overflow', '');
			//$('html,body').off('touchmove');
			that.options.close();
		}

	};

	/**
	 * Helper Functions
	 */
	Plugin.prototype.helpers = {

		/**
		 * Checks if value is a jquery object.
		 *
		 * @param {mixed} a The value to check.
		 * @return {bool}
		 */
		is_jquery: function(a) {
			return (a instanceof jQuery);
		},

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

	Plugin.prototype.browser = {
		supports: (function() {
			var div = document.createElement('div'),
				vendors = ['Khtml','ms','O','Moz','Webkit'],
				len = vendors.length;

			return function(property) {
				if ( property in div.style ) {
					return true;
				}

				property = property.replace(/^[a-z]/, function(val) {
					return val.toUpperCase();
				});

				for (var i = 0; i < len; i++) {
					// DEBUG: window.console.log('Checking: ' + vendors[i] + property );
					if ( vendors[i] + property in div.style ) {
						return true;
					}
				}
				return false;
			};
		})()

	};

	$.fn[plugin_name] = function ( options ) {
		return this.each(function () {
			if (!$.data(this, "plugin_" + plugin_name)) {
				$.data(this, "plugin_" + plugin_name, new Plugin( this, options ));
			}
		});
	};

})( jQuery, window, document );