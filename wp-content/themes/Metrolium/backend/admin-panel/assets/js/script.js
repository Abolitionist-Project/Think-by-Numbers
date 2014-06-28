;(function ( $, window, document, undefined ) {

	var helpers = {
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
		 * Checks if needle is in haystack.
		 *
		 * @param {string} needle The value to check for.
		 * @param {mixed} haystack The haystack in which to check. Can be either string or array.
		 * @return {bool}
		 */
		is_in_haystack: function(needle, haystack) {
			return haystack.indexOf(needle) >= 0 ? true : false;
		}
	};

	var sidebars = {
		add: function() {
			var sidebars = $('#euged-sidebars').val();
			var sidebar = $('#euga_sidebar').val();
			var sidebar_id = sidebar.toLowerCase().split(' ').join('-');

			if (helpers.is_undefined(sidebars)) {
				$('#euged-sidebars').val(sidebar_id);
				return;
			}

			if (helpers.is_in_haystack(sidebar_id, sidebars.split(','))) {
				//alert('That sidebar exists.');
				return;
			}

			$('#euged-sidebars').val(sidebars + ',' + sidebar_id);
			$('#euged-sidebars-sortable').append('<li id="' + sidebar_id + '"><i class="icon-reorder"></i>' + sidebar + '<i class="icon-remove"></i></li>');

			$('#euga_sidebar').val('');

		}
	};

	$(document).ready(function($) {

		$('#euged-tabs').tabs();

		$('#euged-sidebars-sortable').sortable({
			update: function() {
				var sidebar_order = $(this).sortable('toArray').toString();
				$('#euged-sidebars').val(sidebar_order);
			}
		});

		$('#euged-sidebars-sortable').on('click', 'li .icon-remove', function() {
			$(this).parent().remove();
			var sidebar_order = $('#euged-sidebars-sortable').sortable('toArray').toString();
			$('#euged-sidebars').val(sidebar_order);
		});

		$('#euged-sidebars-add').on('click', function(e) {
			e.preventDefault();
			sidebars.add();
		});

	});

})( jQuery, window, document );