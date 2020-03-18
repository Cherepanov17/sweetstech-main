$(document).ready(function() {
	(function () {
		$('.js-main_nav').on('click', function(e) {
			e.preventDefault();
			var link = $(e.target).closest('.js-main_nav-link').data('section');
			if (link) {
				$('.js-main_nav').removeClass('main_nav--active');
				$('html, body').css({'overflow-y': 'auto'});
				var sectionName = '#' + link;
				var position = $(sectionName).offset().top - 100;
				$('html, body').stop().animate({ scrollTop: position }, 500);
			}
		});
	})();

	$(window).scroll(function () {
		if ($(this).scrollTop() > 400) {
			$('.js-to-top').addClass('to-top--active');
		} else {
			$('.js-to-top').removeClass('to-top--active');
		}
	});
	$('.js-to-top').on('click', function () {
		$('body,html').stop().animate({
			scrollTop: 0
		}, 500);
		return false;
	});

	(function () {
		$('.js-main_nav-show').on('click', function () {
			$('.js-main_nav').addClass('main_nav--active');
			$('html, body').css({'overflow-y': 'hidden'});
		});

		$('.js-main_nav-list')
			.prepend('<div class="main_nav-close_wrapper"><button class="main_nav-close js-main_nav-close"></button></div>');

		$('.js-main_nav-close').on('click', function () {
			$('.js-main_nav').removeClass('main_nav--active');
			$('html, body').css({'overflow-y': 'auto'});
		});

		$('.js-main_nav').on('click', function (e) {
			if ($(e.target).hasClass('js-main_nav')) {
				$(this).removeClass('main_nav--active');
				$('html, body').css({'overflow-y': 'auto'});
			}
		});
	})();

	(function () {
		$('.owl-carousel').each(function () {
			$(this).owlCarousel({
				loop:true, //Зацикливаем слайдер
				nav:true, //Отключение навигации
				autoplay:true, //Автозапуск слайдера
				smartSpeed:1000, //Время движения слайда
				autoplayTimeout:5000, //Время смены слайда
				responsive:{ //Адаптивность. Кол-во выводимых элементов при определенной ширине.
					0:{
						items:1
					}
				}
			});
		});
	})();

	(function () {
		let isScrolling = false;
		var items = $('.js-animated-item');

		window.addEventListener("scroll", throttleScroll, false);

		function throttleScroll() {
			if (! isScrolling) {
				window.requestAnimationFrame(function() {
					dealWithScrolling();
					isScrolling = false;
				});
			}
			isScrolling = true;
		}

		function dealWithScrolling() {
			makeVisible();
		}

		function makeVisible() {
			items.each(function () {
				var item = $(this);
				if (item.hasClass('animated-item--active')) {
					return;
				}

				var elementBoundary = item[0].getBoundingClientRect();

				var top = elementBoundary.top;
				var bottom = elementBoundary.bottom;

				if ((top >= 0) && (bottom - 80 <= window.innerHeight)) {
					item.addClass('animated-item--active');
				}
			});
		}

		makeVisible();
	})();

	$('.js-form-accept').on('change', function () {
		$('.js-form-btn').attr('disabled', ! $(this).is(':checked'));
	});

	$('.form').on('submit', function (e) {
		e.preventDefault();
		if (! $('.js-form-accept').is(':checked')) {
			return;
		}
		var $form = $(this);
		$('.form-invalid').remove();
		var $btn = $('.js-form-btn');
		$('.js-spinner').css({'display': 'inline-block'});
		$btn.prop('disabled', true);
		$('.js-form-btn_txt').hide();
		$.ajax({
			type: $form.attr('method'),
			url: $form.attr('action'),
			data: $form.serialize(),
			headers: {
				'X-Requested-With': 'XMLHttpRequest'
			},
			success: function(response) {
				$('.js-spinner').css({'display': 'none'});
				$('.js-form-btn').prop('disabled', false);
				$('.js-form-btn_txt').show();

				if (response.errs) {
					Object.keys(response.errs).forEach(function (key) {
						$('input[name=' + key + ']').parent().append('<p class="form-invalid">' + response.errs[key] + '</p>');
					});
					return;
				}

				if (response.resp === 'success') {
					$('.js-form-btn_txt').text('Заказ принят');
					$('.order-success-txt span').text(response.txt);
					$('.order-success').addClass('order-success--active');
				}
			},
			error: function(response) {
				console.log('error')
			}
		})
	});

	$('.order-success-close').on('click', function () {
		$('.order-success').removeClass('order-success--active');
	})

	$('.js-form-input').on('focus', function () {
		$(this).parent().addClass('input_wrapper--active');
	});

	$('.js-form-input').on('blur', function () {
		if (! $(this).val()) {
			$(this).parent().removeClass('input_wrapper--active');
		}
	});

	$('.js-show-form').on('click', function () {
		$('.js-contacts-form_wrapper').addClass('contacts-form_wrapper--active');
		$('html, body').css({'overflow-y': 'hidden'});
		$(this).addClass('opacity');
		$('.js-to-top').addClass('opacity');
	});

	$(window).on('scroll', function () {
		if(($(this).scrollTop() + $(this).height() - 450 >= $('.js-contacts').offset().top) && ! localStorage.getItem('show_form')) {
			setTimeout(function () {
				$('.js-contacts-form_wrapper').addClass('contacts-form_wrapper--active');
				$('html, body').css({'overflow-y': 'hidden'});
				$('.js-show-form').addClass('opacity');
				$('.js-to-top').addClass('opacity');
				localStorage.setItem('show_form', '1');
			}, 5000);
		}
	});

	window.onbeforeunload = function() {
		localStorage.removeItem('show_form');
	};

	$('.js-form-close').on('click', function () {
		$('.js-contacts-form_wrapper').removeClass('contacts-form_wrapper--active');
		$('html, body').css({'overflow-y': 'auto'});
		$('.js-show-form').removeClass('opacity');
		$('.js-to-top').removeClass('opacity');
	});

	$('.js-contacts-form_wrapper').on('click', function (e) {
		if ($(e.target).hasClass('js-contacts-form_wrapper')) {
			$(this).removeClass('contacts-form_wrapper--active');
			$('html, body').css({'overflow-y': 'auto'});
			$('.js-show-form').removeClass('opacity');
			$('.js-to-top').removeClass('opacity');
		}
	});

	(function () {
		var bg = $('.js-contacts-bg');
		var contacts = $('.js-contacts');

		var visible = function () {
			// Все позиции элемента
			var targetPosition = {
					top: window.pageYOffset + contacts[0].getBoundingClientRect().top,
					bottom: window.pageYOffset + contacts[0].getBoundingClientRect().bottom
				},
				// Получаем позиции окна
				windowPosition = {
					top: window.pageYOffset,
					bottom: window.pageYOffset + document.documentElement.clientHeight
				};

			if (targetPosition.bottom > windowPosition.top && targetPosition.top < windowPosition.bottom) {
				var value = (window.pageYOffset) / - 50 + 30;
				value = value >= 0 ? 0 : value;
				value = value <= -35 ? -35 : value;
				bg.css({"transform": "translate3d(0, " + value + "%, 0)"});
			}
		};

		$(window).on('scroll', visible);
	})();

	$(function() {
		$('.line-img-wrapper')
			.on('mouseenter', function(e) {
				var parentOffset = $(this).offset(),
					relX = e.pageX - parentOffset.left,
					relY = e.pageY - parentOffset.top;
				$(this).find('span').css({top:relY, left:relX})
			})
			.on('mouseout', function(e) {
				var parentOffset = $(this).offset(),
					relX = e.pageX - parentOffset.left,
					relY = e.pageY - parentOffset.top;
				$(this).find('span').css({top:relY, left:relX})
			});
	});
});