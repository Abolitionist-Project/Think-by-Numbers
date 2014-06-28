(function($) {

	$(document).ready(function() {

		$(".tab-group").tabs();

		$(".accordions").each(function() {
			$(this).accordion({
				heightStyle: "content",
				collapsible: true,
				active: $(this).data('active-panel') !== undefined ? $(this).data('active-panel') -1 : false
			});
		});

		$('#hellobar').eugedHelloBar();

		$('#primary-navigation').mobileMenu({
			button_show: $('#mobile-menu-toggle').html(),
			button_hide: $('#mobile-menu-toggle').data('hide'),
			init: function(){
				if ($(".ls-wp-container").length > 0) {
					$(".ls-wp-container").data("LayerSlider").stop();
				}
			},
			close: function(){
				if ($(".ls-wp-container").length > 0) {
					$(".ls-wp-container").data("LayerSlider").start();
				}
			}
		});

		$(".fancybox").fancybox();

		$('.showbiz-enabled').each(function() {

			var entrySizeOffset = 0,
				containerOffsetRight = 0,
				heightOffsetBottom = 0,
				carousel = "off";
				visibleElementsArray = [4,3,2,1],
				dragAndScroll = "off"

			if ($(this).data('sb_entry_size_offset')) {
				entrySizeOffset = $(this).data('sb_entry_size_offset');
			}

			if ($(this).data('sb_container_offset_right')) {
				containerOffsetRight = $(this).data('sb_container_offset_right');
			}

			if ($(this).data('sb_height_offset_bottom')) {
				heightOffsetBottom = $(this).data('sb_height_offset_bottom');
			}

			if ($(this).data('sb_carousel')) {
				carousel = $(this).data('sb_carousel');
			}

			if ($(this).data('sb_visible_elements_array')) {
				visibleElementsArray = $(this).data('sb_visible_elements_array');
				visibleElementsArray = visibleElementsArray.split(",");
			}

			if ($(this).data('sb_drag_and_scroll')) {
				dragAndScroll = $(this).data('sb_drag_and_scroll');
			}

			window.console.log(dragAndScroll);

			$(this).showbizpro({
				entrySizeOffset: entrySizeOffset,
				containerOffsetRight: containerOffsetRight,
				heightOffsetBottom: heightOffsetBottom,
				carousel: carousel,
				visibleElementsArray: visibleElementsArray,
				dragAndScroll: dragAndScroll
			});
		});

	});

	$(window).load(function() {

		$(".typography, .fitvid").fitVids();

		if ($(".flexslider").length > 0) {
			$('.flexslider.default').flexslider({
				animation: "slide",
				selector: ".slides > .slide",
				slideshow: false,
				smoothHeight: true,
				controlNav: false,
				directionNav: true,
				prevText: "<i class=\"icon-chevron-left\"></i>",
				nextText: "<i class=\"icon-chevron-right\"></i>"
			});

			$('.flexslider.thumbnails').flexslider({
				animation: "slide",
				selector: ".slides > .slide",
				slideshow: false,
				smoothHeight: true,
				controlNav: true,
				directionNav: true,
				manualControls: ".flex-thumbnail-nav li",
				prevText: "<i class=\"icon-chevron-left\"></i>",
				nextText: "<i class=\"icon-chevron-right\"></i>"
			});
		}

		// Isotope
		if ($(".isotope-grid").length > 0) {

			var container = $('.isotope-grid'),
				layoutMode = container.data('layoutmode');

			container.isotope({
				animationOptions: {easing: 'easeInQuint'},
				itemSelector : '.isotope-item',
				layoutMode : layoutMode
			});

			$('.isotope-filter a').on('click', function() {
				if ( $(this).hasClass('selected') ) {
					return false;
				}
				$(this).parent().siblings().removeClass('selected');
				$(this).parent().addClass('selected');
				var selector = $(this).attr('data-filter');
				container.isotope({ filter: selector });
				return false;
			});

			$(window).resize(function() {
				container.isotope( 'reLayout' );
			});
                        
                        $('.isotope-filter .selected a').trigger('click');                     

		}

		// Sticky Nav Logic
		var header_height = $('header.main.header-v1').height();

		$(window).scroll(function() {
			if ($('header.main.header-v1').hasClass('stickynav-on')) {

				var scroll_top = $(window).scrollTop();

				if (scroll_top >= header_height && $(window).width() >= 768) {
					$('body').css('padding-top', header_height);
					$('body').addClass('sticky-active');
					$('header.main.header-v1').addClass('follow');
				} else {
					$('body').css('padding-top', 0);
					$('body').removeClass('sticky-active');
					$('header.main.header-v1').removeClass('follow');
				}
			}
		});

	});

})(jQuery);