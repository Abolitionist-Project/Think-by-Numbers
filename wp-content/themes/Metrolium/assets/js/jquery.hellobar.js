/*
 *	Hello Bar jQuery Plugin
 *	Demo's and documentation:
 *	http://www.euged.com/plugins/jquery/hello-bar
 *
 *	Copyright (c) 2013 David Knight - Euged.com
 *
 *	Dual licensed under the MIT and GPL licenses.
 *	http://en.wikipedia.org/wiki/MIT_License
 *	http://en.wikipedia.org/wiki/GNU_General_Public_License
 */

;(function ( $, window, document, undefined ) {

	var plugin_name = "eugedHelloBar",
		defaults = {
			'days': 30
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

			this.hellobar = $(this.element);
			this.ehb_message_hash = $('#hellobar-message').data('hash');
			this.ehb_cookie_value = this.get_cookie('euged_hellobar');

			// If no cookie, show hello bar
			if ( this.helpers.is_undefined( this.ehb_cookie_value ) ) {
				this.hellobar.show();
			}

			// If message hash doesn't match cookie, message must have changed since, show hellobar with new message
			if ( !this.helpers.is_undefined( this.ehb_cookie_value ) && this.ehb_message_hash !== this.ehb_cookie_value ) {
				this.hellobar.show();
			}

			// Bind click event on close button
			this.hellobar.on('click', '.hide', function(e) {
				e.preventDefault();
				that.create_cookie('euged_hellobar', that.ehb_message_hash);
				that.hellobar.slideUp();
			});

		},

		create_cookie: function(name, value, days) {
			var expires = "";
			if (days) {
				var date = new Date();
				date.setTime( date.getTime() + (days*24*60*60*1000) );
				expires = "; expires=" + date.toGMTString();
			}
			document.cookie = name + "=" + value + expires + "; path=/";
		},

		get_cookie: function(name) {
			var nameEQ = name + "=";
			var ca = document.cookie.split(';');
			for (var i = 0; i < ca.length; i++) {
				var c = ca[i];
				while (c.charAt(0) === ' ') {
					c = c.substring(1, c.length);
				}
				if (c.indexOf(nameEQ) === 0) {
					return c.substring(nameEQ.length, c.length);
				}
			}
			return null;
		},

		delete_cookie: function(name) {
			if (this.get_cookie(name)) {
				this.create_cookie(name, "", -1);
			}
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

	$.fn[plugin_name] = function ( options ) {
		return this.each(function () {
			if (!$.data(this, "plugin_" + plugin_name)) {
				$.data(this, "plugin_" + plugin_name, new Plugin( this, options ));
			}
		});
	};

})( jQuery, window, document );