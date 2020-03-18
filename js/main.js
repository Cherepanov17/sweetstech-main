(function ($) {
    "use strict";
    var nav = $('nav');
    var navHeight = nav.outerHeight();

    $('.navbar-toggler').on('click', function () {
        if (!$('#mainNav').hasClass('navbar-reduce')) {
            $('#mainNav').addClass('navbar-reduce');
        }
    })


    // Preloader
    $(window).on('load', function () {
        if ($('#preloader').length) {
            $('#preloader').delay(100).fadeOut('slow', function () {
                $(this).remove();
            });
        }
    });

    (function () {
        let isScrolling = false;
        var items = $('.js-animated-item');

        window.addEventListener("scroll", throttleScroll, false);

        function throttleScroll() {
            if (!isScrolling) {
                window.requestAnimationFrame(function () {
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


    // Back to top button
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

    // Closes responsive menu when a scroll trigger link is clicked
    $('.js-scroll').on("click", function () {
        $('.navbar-collapse').collapse('hide');
    });

    $(() => {


        //Click Logo To Scroll To Top
        $('#logo').on('click', () => {
            $('html,body').animate({
                scrollTop: 0
            }, 500);
        });

        //Smooth Scrolling Using Navigation Menu
        $('a[href*="#"]').on('click', function (e) {
            $('html,body').animate({
                scrollTop: $($(this).attr('href')).offset().top - 100
            }, 500);
            e.preventDefault();
        });

        //Toggle Menu
        $('#menu-toggle').on('click', () => {
            $('#menu-toggle').toggleClass('closeMenu');
            $('ul').toggleClass('showMenu');

            $('li').on('click', () => {
                $('ul').removeClass('showMenu');
                $('#menu-toggle').removeClass('closeMenu');
            });
        });

    });

})(jQuery);

$('.js-form-close').on('click', function () {
    $('.js-form-display').removeClass('form-display--active');
    $('html, body').css({'overflow-y': 'auto'});
    $('.js-show-form').removeClass('opacity');
    $('.js-to-top').removeClass('opacity');
});

$('.js-show-form').on('click', function () {
    $('.js-form-display').addClass('form-display--active');
    $('html, body').css({'overflow-y': 'hidden'});
    $(this).addClass('opacity');
    $('.js-to-top').addClass('opacity');
});

document.querySelector('.form-style').addEventListener('submit', function (e) {
    e.preventDefault()
})

