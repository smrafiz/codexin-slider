(function($) {
	'use strict';

	$(window).on('load', function() {
		// Check if element exists
		$.fn.elExists = function() {
			return this.length > 0;
		};

		/************************************************************
			Image Background Settings
		*************************************************************/

		if ($('.bg-img-wrapper').elExists()) {
			$('.bg-img-wrapper').each(function() {
				var $this = $(this);
				var img = $this.find('img.visually-hidden').attr('src');

				$this.find('.image-placeholder').css({
					backgroundImage: 'url(' + img + ')',
					backgroundSize: 'cover',
					backgroundPosition: 'center center'
				});
			});
		}

		/************************************************************
			Primary Slider Settings
		*************************************************************/

		var $pSlider = $('#primary_slider');
		if ($pSlider.elExists()) {
			var interleaveOffset = 0.5;
			var auto_delay = 999999999;
			var loop = codexin_slider_vars.loop ? codexin_slider_vars.loop : false;
			var effect = codexin_slider_vars.effect ? codexin_slider_vars.effect : 'slide';

			if (codexin_slider_vars.effect == 'fade') {
				interleaveOffset = 0;
			}

			if (codexin_slider_vars.autoplay) {
				var auto_delay = parseInt(codexin_slider_vars.autoplay_delay, 10);
				if (auto_delay.length === 0) {
					auto_delay = 7000;
				}
			}

			var swiperOptions = {
				loop: loop,
				speed: 1000,
				// effect: navigator.userAgent.toLowerCase().indexOf('firefox') > -1 ? 'fade' : 'slide', // Show fade effect instead of parallax slide in Firefox
				effect: effect,
				watchSlidesProgress: true,
				mousewheelControl: true,
				keyboardControl: true,
				disableOnInteraction: true,

				autoplay: {
					delay: auto_delay
				},

				navigation: {
					nextEl: '.swiper-arrow.next.slide',
					prevEl: '.swiper-arrow.prev.slide'
				},

				pagination: {
					el: '.swiper-pagination',
					clickable: true
				},

				// Giving slider a background parallax sliding effect
				on: {
					progress: function() {
						var swiper = this;
						for (var i = 0; i < swiper.slides.length; i++) {
							var slideProgress = swiper.slides[i].progress;
							var innerOffset = swiper.width * interleaveOffset;
							var innerTranslate = slideProgress * innerOffset;
							swiper.slides[i].querySelector('.slide-inner').style.transform =
								'translate3d(' + innerTranslate + 'px, 0, 0)';
						}
					},
					touchStart: function() {
						var swiper = this;
						for (var i = 0; i < swiper.slides.length; i++) {
							swiper.slides[i].style.transition = '';
						}
					},
					setTransition: function(speed) {
						var swiper = this;
						for (var i = 0; i < swiper.slides.length; i++) {
							swiper.slides[i].style.transition = speed + 'ms';
							swiper.slides[i].querySelector('.slide-inner').style.transition = speed + 'ms';
						}
					}
				}
			};

			var swiper = new Swiper($pSlider, swiperOptions);
		}
	});
})(jQuery);
