(function($) {
    "use strict";
    $('#mobile-menu-active').meanmenu( {
        meanScreenWidth: "991", meanMenuContainer: ".mobile-menu-area .mobile-menu",
    }
    );
    $('.nice-select-menu').niceSelect();
    $('.gallery-post').owlCarousel( {
        autoplay:false, autoplayTimeout:5000, animateOut:'fadeOut', animateIn:'fadeIn', loop:true, dots:false, nav:false, navText:["<i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"], item:1, responsive: {
            0: {
                items: 1
            }
            , 768: {
                items: 1
            }
            , 1000: {
                items: 1
            }
        }
    }
    ); 
    
    function headerStyle() {
        if($('.main-header').length) {
            var windowpos=$(window).scrollTop();
            var siteHeader=$('.main-header');
            var scrollLink=$('.scroll-top');
            if(windowpos>=250) {
                siteHeader.addClass('fixed-header');
                scrollLink.fadeIn(300);
            }
            else {
                siteHeader.removeClass('fixed-header');
                scrollLink.fadeOut(300);
            }
        }
    }
    headerStyle();
    $(window).on('scroll', function() {
        headerStyle();
    }
    );
    $('.product-carousel-active').owlCarousel( {
        loop:true, nav:true, navText:["<i class='ion-ios-arrow-left'></i>", "<i class='ion-ios-arrow-right'></i>"], autoplay:false, autoplayTimeout:5000, animateOut:'fadeOut', animateIn:'fadeIn', item:2, responsive: {
            0: {
                items: 1
            }
            , 768: {
                items: 1
            }
            , 992: {
                items: 1
            }
            , 1170: {
                items: 1
            }
            , 1366: {
                items: 2
            }
        }
    }
    ); 
    $('.product-carousel-active-home-four').owlCarousel( {
        loop:true, nav:true, navText:["<i class='ion-ios-arrow-left'></i>", "<i class='ion-ios-arrow-right'></i>"], autoplay:false, autoplayTimeout:5000, animateOut:'fadeOut', animateIn:'fadeIn', item:1, responsive: {
            0: {
                items: 1
            }
            , 768: {
                items: 1
            }
            , 992: {
                items: 1
            }
            , 1000: {
                items: 1
            }
        }
    }
    ); $('.home-three-product-carousel').owlCarousel( {
        loop:true, nav:true, navText:["<i class='ion-ios-arrow-left'></i>", "<i class='ion-ios-arrow-right'></i>"], autoplay:false, autoplayTimeout:5000, animateOut:'fadeOut', animateIn:'fadeIn', item:1, responsive: {
            0: {
                items: 1
            }
            , 768: {
                items: 1
            }
            , 992: {
                items: 1
            }
            , 1000: {
                items: 3
            }
            , 1600: {
                items: 1
            }
        }
    }
    ); $('.product-carousel-active-2').owlCarousel( {
        loop:true, nav:true, navText:["<i class='ion-ios-arrow-left'></i>", "<i class='ion-ios-arrow-right'></i>"], autoplay:false, autoplayTimeout:5000, animateOut:'fadeOut', animateIn:'fadeIn', item:5, responsiveClass:true, responsive: {
            0: {
                items: 1
            }
            , 768: {
                items: 3
            }
            , 992: {
                items: 3
            }
            , 1000: {
                items: 4
            }
            , 1366: {
                items: 5
            }
        }
    }
    );
        
    $('.product-carousel-active-h2').owlCarousel( {
        loop:true, nav:true, navText:["<i class='ion-ios-arrow-left'></i>", "<i class='ion-ios-arrow-right'></i>"], autoplay:false, autoplayTimeout:5000, animateOut:'fadeOut', animateIn:'fadeIn', item:5, responsiveClass:true, responsive: {
            0: {
                items: 1
            }
            , 768: {
                items: 3
            }
            , 992: {
                items: 3
            }
            , 1000: {
                items: 4
            }
            , 1366: {
                items: 4
            }
            , 1600: {
                items: 5
            }
        }
    }
    );
        
    $('.product-carousel-active-3').owlCarousel( {
        loop:true, nav:true, navText:["<i class='ion-ios-arrow-left'></i>", "<i class='ion-ios-arrow-right'></i>"], autoplay:false, autoplayTimeout:5000, animateOut:'fadeOut', animateIn:'fadeIn', item:6, responsive: {
            0: {
                items: 1
            }
            , 768: {
                items: 3
            }
            , 950: {
                items: 3
            }
            , 1000: {
                items: 4
            }
            , 1366: {
                items: 5
            }
            , 1600: {
                items: 5
            }
        }
    }
    );
    $('.product-carousel-active-4').owlCarousel( {
        loop:true, nav:true, navText:["<i class='ion-ios-arrow-left'></i>", "<i class='ion-ios-arrow-right'></i>"], autoplay:false, autoplayTimeout:5000, animateOut:'fadeOut', animateIn:'fadeIn', item:1, responsiveClass:true, responsive: {
            0: {
                items: 1
            }
            , 600: {
                items: 2
            }
            , 1000: {
                items: 2
            }
        }
    }
    ); $('.bestseller-sidebar').owlCarousel( {
        loop:true, nav:true, navText:["<i class='ion-ios-arrow-left'></i>", "<i class='ion-ios-arrow-right'></i>"], autoplay:false, autoplayTimeout:5000, animateOut:'fadeOut', animateIn:'fadeIn', item:1, responsive: {
            0: {
                items: 1
            }
            , 600: {
                items: 1
            }
            , 768: {
                items: 2
            }
            , 992: {
                items: 3
            }
            , 1000: {
                items: 3
            }
            , 1170: {
                items: 3
            }
            , 1366: {
                items: 1
            }
        }
    }
    );
        
    $('.newarival-sidebar').owlCarousel( {
        loop:true, nav:true, navText:["<i class='ion-ios-arrow-left'></i>", "<i class='ion-ios-arrow-right'></i>"], autoplay:false, autoplayTimeout:5000, animateOut:'fadeOut', animateIn:'fadeIn', item:1, responsiveClass:true, responsive: {
            0: {
                items: 1
            }
            , 600: {
                items: 2
            }
            , 992: {
                items: 3
            }
            , 1000: {
                items: 3
            }
            , 1170: {
                items: 3
            }
            , 1366: {
                items: 1
            }
        }
    }
    );
        
    $('.testimonial-sidebar').owlCarousel( {
        loop:true, nav:true, navText:["<i class='ion-ios-arrow-left'></i>", "<i class='ion-ios-arrow-right'></i>"], autoplay:false, autoplayTimeout:5000, animateOut:'fadeOut', animateIn:'fadeIn', item:1, responsiveClass:true, responsive: {
            0: {
                items: 1
            }
            , 600: {
                items: 1
            }
            , 1000: {
                items: 1
            }
        }
    }
    );
        
    $('.mini-product').owlCarousel( {
        loop:true, nav:true, navText:["<i class='ion-ios-arrow-left'></i>", "<i class='ion-ios-arrow-right'></i>"], autoplay:false, autoplayTimeout:5000, animateOut:'fadeOut', animateIn:'fadeIn', item:1, responsiveClass:true, responsive: {
            0: {
                items: 1
            }
            , 600: {
                items: 1
            }
            , 992: {
                items: 1
            }
            , 1000: {
                items: 1
            }
            , 1170: {
                items: 1
            }
        }
    }
    );
        
    $('.mini-product-2').owlCarousel( {
        loop:true, nav:true, navText:["<i class='ion-ios-arrow-left'></i>", "<i class='ion-ios-arrow-right'></i>"], autoplay:false, autoplayTimeout:5000, animateOut:'fadeOut', animateIn:'fadeIn', item:1, responsiveClass:true, responsive: {
            0: {
                items: 1
            }
            , 600: {
                items: 1
            }
            , 768: {
                items: 2
            }
            , 992: {
                items: 3
            }
            , 1000: {
                items: 3
            }
            , 1170: {
                items: 3
            }
            , 1366: {
                items: 1
            }
        }
    }
    );
        
    $('.home-two-product-carousel-active').owlCarousel( {
        loop:true, nav:true, navText:["<i class='ion-ios-arrow-left'></i>", "<i class='ion-ios-arrow-right'></i>"], autoplay:false, autoplayTimeout:5000, animateOut:'fadeOut', animateIn:'fadeIn', item:4, responsiveClass:true, responsive: {
            0: {
                items: 1
            }
            , 768: {
                items: 2
            }
            , 950: {
                items: 3
            }
            , 1000: {
                items: 4
            }
        }
    }
    );
        
    $('.home-two-sidebar-product').owlCarousel( {
        loop:true, nav:true, navText:["<i class='ion-ios-arrow-left'></i>", "<i class='ion-ios-arrow-right'></i>"], autoplay:false, autoplayTimeout:5000, animateOut:'fadeOut', animateIn:'fadeIn', item:1, dots:false, responsiveClass:true, responsive: {
            0: {
                items: 1,
            }
            , 768: {
                items: 2,
            }
            , 950: {
                items: 3,
            }
            , 1000: {
                items: 3,
            }
        }
    }
    );
        
    $('.brand-carousel-active').owlCarousel( {
        loop:true, nav:true, navText:["<i class='ion-ios-arrow-left'></i>", "<i class='ion-ios-arrow-right'></i>"], autoplay:true, autoplayTimeout:5000, animateOut:'fadeOut', animateIn:'fadeIn', item:8, responsiveClass:true, responsive: {
            0: {
                items: 1, center: true
            }
            , 768: {
                items: 4
            }
            , 1000: {
                items: 8
            }
        }
    }
    );
        
    $('.four-brand-carousel-active').owlCarousel( {
        loop:true, nav:true, navText:["<i class='ion-ios-arrow-left'></i>", "<i class='ion-ios-arrow-right'></i>"], autoplay:true, autoplayTimeout:5000, animateOut:'fadeOut', animateIn:'fadeIn', item:6, responsiveClass:true, responsive: {
            0: {
                items: 1, center: true
            }
            , 768: {
                items: 3
            }
            , 1000: {
                items: 6
            }
        }
    }
    );
    
    $('.product-dec-slider-qui').owlCarousel( {
        loop:true, nav:false, navText:["<i class='ion-ios-arrow-left'></i>", "<i class='ion-ios-arrow-right'></i>"], autoplay:false, autoplayTimeout:5000, animateOut:'fadeOut', animateIn:'fadeIn', item:4, responsiveClass:true, responsive: {
            0: {
                items: 1, center: true
            }
            , 768: {
                items: 3
            }
            , 1000: {
                items: 4
            }
        }
    }
    );
    $('.product-dec-slider').slick( {
        dots: true, vertical: true, slidesToShow: 4, slidesToScroll: 4, verticalSwiping: true, arrows: true, nextArrow: '<i class="fa fa-chevron-down"></i>', prevArrow: '<i class="fa fa-chevron-up"></i>',
    }
    );
    $('.banner-call-to-action-carousel-active').owlCarousel( {
        loop:true, nav:true, navText:["<img src='images/icons/arrow-left.png'>", "<img src='images/icons/arrow-right.png'>"], autoplay:false, autoplayTimeout:5000, animateOut:'fadeOut', animateIn:'fadeIn', item:1, responsiveClass:true, responsive: {
            0: {
                items: 1
            }
            , 768: {
                items: 1
            }
            , 1000: {
                items: 1
            }
        }
    }
    );
    $('[data-countdown]').each(function() {
        var $this=$(this), finalDate=$(this).data('countdown');
        $this.countdown(finalDate, function(event) {
            $this.html(event.strftime('<span class="cdown days"><span class="time-count">%-D</span><span>D : </span></span> <span class="cdown hour"><span class="time-count">%-H</span><span>H : </span></span> <span class="cdown minutes"><span class="time-count">%M</span><span>M : </span></span> <span class="cdown second"> <span><span class="time-count">%S</span><span>S</span></span>'));
        }
        );
    }
    );
    $('.product-popup').magnificPopup( {
        delegate: 'a', type: 'image'
    }
    );
    $('.product-details-small a').on('click', function(e) {
        e.preventDefault();
        var $href=$(this).attr('href');
        $('.product-details-small a').removeClass('active');
        $(this).addClass('active');
        $('.product-details-large .tab-pane').removeClass('active');
        $('.product-details-large '+$href).addClass('active');
    }
    );
    $('[rel="tooltip"]').tooltip();
    $(".cart-plus-minus").prepend('<div class="dec qtybutton">-</div>');
    $(".cart-plus-minus").append('<div class="inc qtybutton">+</div>');
    $(".qtybutton").on("click", function() {
        var $button=$(this);
        var oldValue=$button.parent().find("input").val();
        if($button.text()=="+") {
            var newVal=parseFloat(oldValue)+1;
        }
        else {
            if(oldValue>0) {
                var newVal=parseFloat(oldValue)-1;
            }
            else {
                newVal=0;
            }
        }
        $button.parent().find("input").val(newVal);
    }
    );
    $('#price-range').slider( {
        range:true, min:0, max:700, values:[0, 700], slide:function(event, ui) {
            $('.price-amount').val('$'+ui.values[0]+' - $'+ui.values[1]);
        }
    }
    );
    $('.price-amount').val('$'+$('#price-range').slider('values', 0)+' - $'+$('#price-range').slider('values', 1));
    $('.product-filter-toggle').on('click', function() {
        $('.product-filter-wrapper').slideToggle();
    }
    );
         $('.panel-heading a').on('click', function() {
        $('.panel-default').removeClass('show');
        $(this).parents('.panel-default').addClass('show');
    }
    );
    $('.counter').counterUp( {
        delay: 10, time: 1000
    }
    );
    var isotopFilter=$('.isotop-filter');
    var isotopGrid=$('.isotop-grid');
    var isotopGridMasonry=$('.isotop-grid-masonry');
    var isotopGridItem='.isotop-item';
    isotopGrid.imagesLoaded(function() {
        isotopFilter.on('click', 'button', function() {
            isotopFilter.find('button').removeClass('active');
            $(this).addClass('active');
            var filterValue=$(this).attr('data-filter');
            isotopGrid.isotope( {
                filter: filterValue
            }
            );
        }
        );
        isotopGrid.isotope( {
            itemSelector:isotopGridItem, layoutMode:'fitRows', masonry: {
                columnWidth: 1,
            }
        }
        );
        isotopGridMasonry.isotope( {
            itemSelector:isotopGridItem, layoutMode:'masonry', masonry: {
                columnWidth: 1,
            }
        }
        );
    }
    );
    var imagePopup=$('.image-popup');
    imagePopup.magnificPopup( {
        type: 'image',
    }
    );
    $('iframe[src*="youtube"]').parent().fitVids();
    $.scrollUp( {
        scrollText: '<i class="ion-arrow-up-c"></i>', easingType: 'linear', scrollSpeed: 900, animation: 'fade'
    }
    );
    $('#mainSlider').nivoSlider( {
        manualAdvance: false, directionNav: true, animSpeed: 500, slices: 18, pauseTime: 5000, pauseOnHover: false, controlNav: false, prevText: '<i class="fa fa-angle-left nivo-prev-icon"></i>', nextText: '<i class="fa fa-angle-right nivo-next-icon"></i>'
    }
    );
}

)(jQuery);
var swiper=new Swiper('.swiper-container', {
    pagination: {
        el: '.swiper-pagination',
    }
    ,
});

function openNav() {
    document.getElementById("mySidenav").style.width="280px";
}

function closeNav() {
    document.getElementById("mySidenav").style.width="0";
}


$(function() {
    $('nav#menu').mmenu();
});
function onScroll(event) {
    var scrollPos=$(document).scrollTop();
    $('.tab-item a').each(function() {
        var currLink=$(this);
        var refElement=$(currLink.attr("href"));
        if(refElement.position().top<=scrollPos&&refElement.position().top+refElement.height()>scrollPos) {
            $('.tab-item  a').removeClass("active");
            currLink.addClass("active");
        }
        else {
            currLink.removeClass("active");
        }
    }
    );
}

$(document).ready(function() {
    $(document).on("scroll", onScroll);
    $('.tab-detail a[href^="#"]').on('click', function(e) {
        e.preventDefault();
        $(document).off("scroll");
        $('.tab-item a').each(function() {
            $(this).removeClass('active');
        }
        );
        $(this).addClass('active');
        var target=this.hash;
        $target=$(target);
        $('html, body').stop().animate( {
            'scrollTop': $target.offset().top
        }
        , 500, 'swing', function() {
            window.location.hash=target;
            $(document).on("scroll", onScroll);
        }
        );
    }
    );
}

);
jQuery(document).ready(function($) {
    setTimeout(function() {
        $('#lab-slide-bottom-popup').modal('show');
    }
    , 5000);
    $(document).ready(function() {
        $('.lab-slide-up').find('a').attr('data-toggle', 'modal');
        $('.lab-slide-up').find('a').attr('data-target', '#lab-slide-bottom-popup');
    }
    );
}

);
(function(window) {
    'use strict';
    function classReg(className) {
        return new RegExp("(^|\\s+)"+className+"(\\s+|$)");
    }
    var hasClass, addClass, removeClass;
    if('classList'in document.documentElement) {
        hasClass=function(elem, c) {
            return elem.classList.contains(c);
        }
        ;
        addClass=function(elem, c) {
            elem.classList.add(c);
        }
        ;
        removeClass=function(elem, c) {
            elem.classList.remove(c);
        }
        ;
    }
    else {
        hasClass=function(elem, c) {
            return classReg(c).test(elem.className);
        }
        ;
        addClass=function(elem, c) {
            if(!hasClass(elem, c)) {
                elem.className=elem.className+' '+c;
            }
        }
        ;
        removeClass=function(elem, c) {
            elem.className=elem.className.replace(classReg(c), ' ');
        }
        ;
    }
    function toggleClass(elem, c) {
        var fn=hasClass(elem, c)?removeClass: addClass;
        fn(elem, c);
    }
    var classie= {
        hasClass: hasClass, addClass: addClass, removeClass: removeClass, toggleClass: toggleClass, has: hasClass, add: addClass, remove: removeClass, toggle: toggleClass
    }
    ;
    if(typeof define==='function'&&define.amd) {
        define(classie);
    }
    else {
        window.classie=classie;
    }
}

)(window);
var ModalEffects=(function() {
    function init() {
        var overlay=document.querySelector('.md-overlay');
        [].slice.call(document.querySelectorAll('.md-trigger')).forEach(function(el, i) {
            var modal=document.querySelector('#'+el.getAttribute('data-modal')), close=modal.querySelector('.md-close');
            document.getElementById("bottom-actions-placeholder").style.display="none";
            function removeModal(hasPerspective) {
                classie.remove(modal, 'md-show');
                document.getElementById("bottom-actions-placeholder").style.display="none";
                if(hasPerspective) {
                    classie.remove(document.documentElement, 'md-perspective');
                }
            }
            function removeModalHandler() {
                removeModal(classie.has(el, 'md-setperspective'));
            }
            el.addEventListener('click', function(ev) {
                classie.add(modal, 'md-show');
                document.getElementById("bottom-actions-placeholder").style.display="block";
                overlay.removeEventListener('click', removeModalHandler);
                overlay.addEventListener('click', removeModalHandler);
                if(classie.has(el, 'md-setperspective')) {
                    setTimeout(function() {
                        classie.add(document.documentElement, 'md-perspective');
                    }
                    , 25);
                }
            }
            );
            close.addEventListener('click', function(ev) {
                ev.stopPropagation();
                removeModalHandler();
            }
            );
        }
        );
    }
    init();
}

)();
$("#btn-detail-seo").click(function() {
    $(".section-body").toggleClass("all");
}

);
$("#btn-list-view, #btn-gallery-view").click(function() {
    $(".btn-switch-view").toggleClass("hide show");
    $("#ai-product-list").toggleClass("gallery list");
    $(".contact-wrap").toggleClass("active");
    if($(".contact-wrap").hasClass("active")) {
        $(".contact-wrap").text("CONTACT SUPPLIER");
    }
    else {
        $(".contact-wrap").text("CONTACT");
    }
}

);