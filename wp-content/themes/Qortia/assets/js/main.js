"use strict";

$(document).ready(function () {
    setHeadSectionHeight();
    $(document).on('click', '.modal_open', function () {
        $.fancybox.close();
        var href_ = $(this).attr('href');
        var title_ = $(this).attr('data-title');

        if (typeof title_ !== 'undefined' && title_ !== false) {
            $('.js-modal-name').val(title_);
        }

        $.fancybox.open($(this), {
            // closeBtn: false,
            // smallBtn: false,
            autoFocus: false,
            buttons: [],
            touch: false,
            hideScrollbar: false,
            swipe: false,
            mobile: {
                // clickContent : "close",
                clickSlide: "close"
            }
        });
    });
    $('.scroll-link ').click(function (e) {
        e.preventDefault();
        var target = $(this).closest('section').next();
        var h = $('header').outerHeight() - 1;

        if (target.length) {
            $('html, body').animate({
                scrollTop: target.offset().top - h
            }, 1000);
            return false;
        }
    });
    $(".sub-nav__list li a").on("mouseenter", function () {
        var img_ = $(this).attr('data-img');

        if (typeof img_ !== 'undefined' && img_ !== false) {
            var bg_ = $(this).closest('.sub-nav__group').find('.sub-nav__media span');
            bg_.append('<img src="' + img_ + '" alt="">');
        }
    }).on("mouseleave", function () {
        $(this).closest('.sub-nav__group').find('.sub-nav__media span img').remove();
    });
    $(".video-list__item video").on("mouseover", function (event) {
        this.play();
        $(this).closest('.video-list__item').siblings().addClass('sm');
    }).on('mouseout', function (event) {
        $(this).closest('.video-list__item').siblings().removeClass('sm');
        this.currentTime = 0;
        this.pause();
    });

    if ($(".stats").length > 0) {
        var l = $(".stats-item ");
        $(document).bind("scroll", function (e) {
            $(document).scrollTop() > l.offset().top - window.innerHeight && ($(".stats-item ").each(function () {
                $(this).prop("Counter", 0).animate({
                    Counter: $(this).find('.stats-item__title strong').text()
                }, {
                    duration: 4e3,
                    easing: "swing",
                    step: function step(e) {
                        var rez = Math.ceil(e); // var outrez = (rez + '').replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 ');

                        $(this).find('strong').text(rez);
                    }
                });
            }), $(document).unbind("scroll"));
        });
    }

    $('.js-collapse').on('click', '.js-collapse-title', function (event) {
        event.preventDefault();

        if ($(this).closest('.js-collapse-item').hasClass('active')) {
            $(this).closest('.js-collapse').find('.js-collapse-content').slideUp(400);
            $(this).closest('.js-collapse-item').removeClass('active');
            $('.product-tab .place-wrap__point ul li').removeClass('active');
        } else {
            $(this).closest('.js-collapse').find('.js-collapse-item').removeClass('active');
            $(this).closest('.js-collapse').find('.js-collapse-content').slideUp(400);
            $(this).closest('.js-collapse-item').addClass('active');
            $(this).closest('.js-collapse-item').find('.js-collapse-content').slideDown();
            $('.product-tab .place-wrap__point ul li').removeClass('active');
            var in_ = $('.product-tab .js-collapse-item.active').index();
            $('.product-tab .place-wrap__point ul li').eq(in_).addClass('active');
        }
    });

    $('.navigation>ul>li').each(function () {
        var list = $(this).find('.sub-nav');
        var as = $(this).find('>a');
        var con = '<span class="sub_toggle"></span>';

        if (list.length > 0) {
            $(this).addClass('li_sub');
            $(con).insertAfter(as);
        }
    });
    $('.sub_toggle').click(function (e) {
        e.preventDefault();

        if ($(this).hasClass('open')) {
            $(this).removeClass('open');
            $(this).next().slideUp();
        } else {
            $('.sub_toggle').removeClass('open').next().slideUp();
            $(this).addClass('open');
            $(this).next().slideDown();
        }
    });
    $('.tog-nav').on('click', function () {
        $(this).toggleClass('active');
        $('.navigation').slideToggle();
    });
    $('.stats-slider').slick({
        dots: true,
        infinite: true,
        arrows: false,
        speed: 1000,
        slidesToShow: 3,
        variableWidth: true,
        responsive: [{
            breakpoint: 600,
            settings: {
                variableWidth: false,
                slidesToShow: 1,
                slidesToScroll: 1
            }
        }]
    });
    $('.partners-slider').slick({
        dots: false,
        infinite: true,
        arrows: false,
        autoplay: true,
        autoplaySpeed: 0,
        speed: 8000,
        pauseOnHover: false,
        cssEase: 'linear',
        // slidesToShow: 6,
        variableWidth: true
    });
    $('.partners-slider_rev').slick({
        dots: false,
        infinite: true,
        arrows: false,
        autoplay: true,
        autoplaySpeed: 0,
        speed: 8000,
        pauseOnHover: false,
        cssEase: 'linear',
        rtl: true,
        // slidesToShow: 6,
        variableWidth: true
    });
    var bw = window.innerWidth;
    var bh = window.innerHeight;
    $('.section-head .container').css('min-height', bh);

    $(document).on('click', '.back-step', function (e) {
        e.preventDefault();
        $(this).closest('.step-form__item.active').removeClass('active').prev('.step-form__item').addClass('active');
        var in_ = $('.step-form__item.active').index();
        in_ = in_ - 1;
        $('.step-form__top-item').eq(in_).addClass('active').nextAll().removeClass('active');
    });

    $(document).on('change', '.upfile_hide', function () {
        if ($(this).val().length == 0) {
            $(this).closest('.up_file').find($('.up_file_text')).text($('.up_file').attr('data-text'));
        } else {
            $(this).closest('.up_file').find($('.up_file_text')).text('');

            for (var i = 0; i < this.files.length; i++) {
                var fileName = this.files[i].name;
                $(this).closest('.up_file').find($('.up_file_text')).append('<div class="fileName">' + fileName + '</div>');
            }
        }
    });

    if ($(".cooperate").length > 0) {
        var l = $(".cooperate");
        $(document).bind("scroll", function (e) {
            $(document).scrollTop() > l.offset().top - window.innerHeight && ($(".cooperate").each(function () {
                setInterval(function () {
                    updateClass();
                }, 1000);
            }), $(document).unbind("scroll"));
        });
    }

    $('.check_st').on('change', function () {
        var th_ = $(this);

        if (th_.is(':checked')) {
            th_.closest('.checked-item').find('.hide-drop').slideDown();

            if (th_.closest('.checked-item').find('.hide-drop .input').val() > 0) {
            } else {
                th_.closest('.checked-item').find('.hide-drop .input').attr('required', 'true');
            }
        } else {
            th_.closest('.checked-item').find('.hide-drop').slideUp();
            th_.closest('.checked-item').find('.hide-drop input').attr('required', 'false').val('');
        }
    });

    if ($('.section-error, .section-head ').length < 1) {
        $('.header').addClass('fix_header');
    }


    AOS.init({
        duration: 1200,
        // disable: 'mobile',
        once: true
    });
});

$.fn.isInViewport = function () {
    var elementTop = $(this).offset().top;
    var elementBottom = elementTop + $(this).outerHeight();
    var viewportTop = $(window).scrollTop() - 350;
    var viewportBottom = viewportTop + $(window).height();
    return elementBottom > viewportTop && elementTop < viewportBottom;
};

function setHeadSectionHeight() {
    var bw = window.innerWidth;
    var bh = window.innerHeight;
    $('.section-head .container').css('min-height', bh);
}

$(window).on('load resize scroll', function () {

    scrollNav();
    $('.history-list__item:not(active)').each(function () {
        if ($(this).isInViewport()) {
            var $el1 = $(this);
            $('.history-list__item').removeClass('active');
            $el1.addClass('active');
            var n = $el1.index() + 1; // $('.nav-section__progress span').css('width', n / n_ * 100 + '%');

            var name_ = $('.history-list__item.active').attr('data-year');
            $('.history-year').text(name_);
        }
    });
    $('section:not(active)').each(function () {
        if ($(this).isInViewport()) {
            var $el1 = $(this); // $('.history-list__item').removeClass('active');

            $el1.addClass('active');
            var n = $el1.index() + 1; // $('.nav-section__progress span').css('width', n / n_ * 100 + '%');
        }
    });
    $(".price-wrap__table").each(function () {
        if ($(this).hasScrollBar()) {
            $(this).addClass('scrollable');
        } else {
            $(this).removeClass('scrollable');
        }
    });
});

function scrollNav() {
    if ($(window).scrollTop() > 1) {
        $('.header').addClass('fix_header');
    } else {
        if ($('.section-error, .section-head ').length > 0) {
            $('.header').removeClass('fix_header');
        }
    }
}

(function ($) {
    $.fn.hasScrollBar = function () {
        return this.get(0).scrollWidth > this.innerWidth();
    };
})(jQuery);

if ($('.scroll-link__text-item').length > 0) {
    var text = $('.scroll-link__text-item').html();
    var textLen = text.length;
    wrapLettersInSpan(text);
}

addTransformCss();

function wrapLettersInSpan(text) {
    var arr = text.split('');

    for (var i = 0; i < textLen; i++) {
        arr[i] = "<span class='letter'>" + arr[i] + "</span>";
    }

    $('.scroll-link__text-item').html(arr.join(''));
    $('.scroll-link').css('opacity', '1');

}

function addTransformCss() {
    var transformStart = -90;
    var transformStep = 140 / (textLen - 1);
    $('.letter').each(function (i, elem) {
        $(elem).css({
            transform: 'rotate(' + transformStart + 'deg)'
        });
        transformStart += transformStep;
    });
}

function updateClass() {
    $('.cooperate-item:first-child').addClass('active');
    setTimeout(function () {
        var a = $(".cooperate-item.active");
        a = a.next().addClass('active');
    }, 1000);
}

function setInputFilter(textbox, inputFilter) {
    ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function (event) {
        textbox.bind(event, function () {
            if (inputFilter(this.value)) {
                this.oldValue = this.value;
                this.oldSelectionStart = this.selectionStart;
                this.oldSelectionEnd = this.selectionEnd;
            } else if (this.hasOwnProperty("oldValue")) {
                this.value = this.oldValue;
                this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
            }
        });
    });
}