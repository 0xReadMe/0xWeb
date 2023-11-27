$(document).ready(function() {

    var winHeight = $(window).height();
    var winWidth = $(window).width();
    var translateY = "translateY(" + winHeight + "px)";
    var translateX = "translateX(" + winWidth + "px)";

    // detect IE
    var IEversion = detectIE();

    if (IEversion !== false) {
        $('.circle-container').addClass('ie');
    }

    /**
     * detect IE
     * returns version of IE or false, if browser is not Internet Explorer
     */
    function detectIE() {
        var ua = window.navigator.userAgent;

        // test values
        // IE 10
        //ua = 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; Trident/6.0)';
        // IE 11
        //ua = 'Mozilla/5.0 (Windows NT 6.3; Trident/7.0; rv:11.0) like Gecko';
        // IE 12 / Spartan
        //ua = 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.71 Safari/537.36 Edge/12.0';

        var msie = ua.indexOf('MSIE ');
        if (msie > 0) {
            // IE 10 or older => return version number
            return parseInt(ua.substring(msie + 5, ua.indexOf('.', msie)), 10);
        }

        var trident = ua.indexOf('Trident/');
        if (trident > 0) {
            // IE 11 => return version number
            var rv = ua.indexOf('rv:');
            return parseInt(ua.substring(rv + 3, ua.indexOf('.', rv)), 10);
        }

        var edge = ua.indexOf('Edge/');
        if (edge > 0) {
            // IE 12 => return version number
            return parseInt(ua.substring(edge + 5, ua.indexOf('.', edge)), 10);
        }

        // other browser
        return false;
    }

    $('.slider, .section-3-img, .section-6-img').css("transform", translateY);
    $('.section-5-img').css("transform", translateX);


    $('.pager-item').click(function(){
        var ind = $(this).index();
        ind++;
        if (!$(this).hasClass('active')) {
            $(this).parents('.slider-pager').find('.active').removeClass('active');
            $(this).addClass('active');
            $('.slider-img').removeClass('active').hide();
            $('.slider-img:nth-of-type('+ind+')').addClass('active').fadeIn();
        }
        return false;
    });

    function changeSlide() {
        var ind = $('.pager-item.active').index() + 1;
        window.timerId = setInterval(function() {
            if ($('.section-2').hasClass('active')) {
                if (ind === 5) {ind = 0}
                if (ind === 0) {$('.pager-item').removeClass('active');}
                $('.pager-item').click(function(){
                    clearInterval(window.timerId)
                });
                $('.pager-item:nth-of-type('+ind+')').removeClass('active');
                ++ind + 1;
                $('.slider-img').removeClass('active').hide();
                $('.pager-item:nth-of-type('+ind+')').addClass('active');
                $('.slider-img:nth-of-type('+ind+')').addClass('active').fadeIn();
            }
            else {
                clearInterval(window.timerId)
                }
        }, 5000);
    }

    $('#fullpage').fullpage({
        scrollingSpeed: 800,
        verticalCentered: true,
        navigation: true,
        navigationPosition: 'left',
        anchors: ['section-1', 'section-2', 'section-3', 'section-4', 'section-5', 'section-6', 'section-7'],
        afterLoad: function(anchorLink, index){
            $.fn.fullpage.setAllowScrolling(false);
            var enable_csroll = function(){
                $.fn.fullpage.setAllowScrolling(true);
            };
            setTimeout(enable_csroll, 500);
            $('.circle-container').addClass('active');
            if(index == 1){
                clearInterval(window.timerId)
            }
            if(index == 2){
                $('.slider-pager, .slider').addClass('active');
                changeSlide();
            }
            if(index == 3){
                $('.section-3-img, .section-3-content').addClass('active');
                clearInterval(window.timerId)
            }
            if(index == 4){
                $('.section-4-img').addClass('active');
            }
            if(index == 5){
                $('.section-5-img').addClass('active');
            }
            if(index == 6){
                $('.section-6-img').addClass('active');
            }
        }
    });

    if ($(window).height() < 620 || $(window).width() < 720) {
        $.fn.fullpage.setAutoScrolling(false);
        $.fn.fullpage.setFitToSection(false);
        $('body').addClass('head1');
        $(window).scroll(function(){
            if ($(window).scrollTop() > $('.section-7').offset().top - $('.second-header').height() || $(window).scrollTop() < $('.section-1').height() - $('.header').height()) {
                $('body').removeClass('head2').addClass('head1');
            }
            else {
                $('body').removeClass('head1').addClass('head2');
            }
            if ($(window).scrollTop() > $('.section-7').offset().top - $('.second-header').height()) {
                $('body').addClass('fp-viewing-6');
            }
            else {
                $('body').removeClass('fp-viewing-6');
            }
        });
    } else {
        $.fn.fullpage.setAutoScrolling(true);
        $.fn.fullpage.setFitToSection(true);
        $('body').removeClass('head1');
    }
    $('.bottom-arrow').click(function(e){
        e.preventDefault();
        $.fn.fullpage.moveSectionDown();
    });

});

$(window).resize(function(){
    if ($(window).height() < 620 || $(window).width() < 720) {
        $.fn.fullpage.setAutoScrolling(false);
        $.fn.fullpage.setFitToSection(false);
        $('body').addClass('head1');
        $(window).scroll(function(){
            if ($(window).scrollTop() > $('.section-7').offset().top - $('.second-header').height() || $(window).scrollTop() < $('.section-1').height() - $('.header').height()) {
                $('body').removeClass('head2').addClass('head1');
            }
            else {
                $('body').removeClass('head1').addClass('head2');
            }
            if ($(window).scrollTop() > $('.section-7').offset().top - $('.second-header').height()) {
                $('body').addClass('fp-viewing-6');
            }
            else {
                $('body').removeClass('fp-viewing-6');
            }
        });
    } else {
        $.fn.fullpage.setAutoScrolling(true);
        $.fn.fullpage.setFitToSection(true);
        $('body').removeClass('head1');
    }

    var winHeight = $(window).height();
    var winWidth = $(window).width();
    var translateY = "translateY(" + winHeight + "px)";
    var translateX = "translateX(" + winWidth + "px)";
    $('.slider, .section-3-img, .section-6-img').css("transform", translateY);
    $('.section-5-img').css("transform", translateX);
});