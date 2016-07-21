/* ----------------- Start JS Document ----------------- */



// Page Loader
$(window).load(function () {
    "use strict";
    
    $('#loader').fadeOut();
});

$(document).ready(function ($) {
    "use strict";
    
    
    /*----------------------------------------------------*/
    /*  Back Top Link
    /*----------------------------------------------------*/
    
    var offset = 200;
    var duration = 500;
    $(window).scroll(function() {
        if ($(this).scrollTop() > offset) {
            $('.back-to-top').fadeIn(400);
        } else {
            $('.back-to-top').fadeOut(400);
        }
    });
    $('.back-to-top').click(function(event) {
        event.preventDefault();
        $('html, body').animate({scrollTop: 0}, 600);
        return false;
    })


    
    
    /*----------------------------------------------------*/
    /*  Css3 Transition
    /*----------------------------------------------------*/
    
    $('*').each(function(){
        if($(this).attr('data-animation')) {
            var $animationName = $(this).attr('data-animation'),
                $animationDelay = "delay-"+$(this).attr('data-animation-delay');
            $(this).appear(function() {
                $(this).addClass('animated').addClass($animationName);
                $(this).addClass('animated').addClass($animationDelay);
            });
        }
    });

    $('.nav-tabs > li a[title]').tooltip();
    
    //Wizard
    $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {

        var $target = $(e.target);
    
        if ($target.parent().hasClass('disabled')) {
            return false;
        }
    });

    $(".next-step").click(function (e) {

        var $active = $('.wizard .nav-tabs li.active');
        $active.next().removeClass('disabled');
        nextTab($active);

    });
    $(".prev-step").click(function (e) {

        var $active = $('.wizard .nav-tabs li.active');
        prevTab($active);

    });

    /*----------------------------------------------------*/
    /*  Sliders & Carousel
    /*----------------------------------------------------*/
    
    ////------- Touch Slider
    var time = 4.4,
        $progressBar,
        $bar,
        $elem,
        isPause,
        tick,
        percentTime;
    $('.touch-slider').each(function(){
        var owl = jQuery(this),
            sliderNav = $(this).attr('data-slider-navigation'),
            sliderPag = $(this).attr('data-slider-pagination'),
            sliderProgressBar = $(this).attr('data-slider-progress-bar');
            
        if ( sliderNav == 'false' || sliderNav == '0' ) {
            var returnSliderNav = false
        }else {
            var returnSliderNav = true
        }
        
        if ( sliderPag == 'true' || sliderPag == '1' ) {
            var returnSliderPag = true
        }else {
            var returnSliderPag = false
        }
        
        if ( sliderProgressBar == 'true' || sliderProgressBar == '1' ) {
            var returnSliderProgressBar = progressBar
            var returnAutoPlay = false
        }else {
            var returnSliderProgressBar = false
            var returnAutoPlay = true
        }
        
        owl.owlCarousel({
            navigation : returnSliderNav,
            pagination: returnSliderPag,
            slideSpeed : 400,
            paginationSpeed : 400,
            lazyLoad : true,
            singleItem: true,
            autoHeight : true,
            autoPlay: returnAutoPlay,
            stopOnHover: returnAutoPlay,
            transitionStyle : "fade",
            afterInit : returnSliderProgressBar,
            afterMove : moved,
            startDragging : pauseOnDragging
        });
        
    });

    function progressBar(elem){
        $elem = elem;
        buildProgressBar();
        start();
    }
    
    function buildProgressBar(){
        $progressBar = $("<div>",{
            id:"progressBar"
        });
        $bar = $("<div>",{
            id:"bar"
        });
        $progressBar.append($bar).prependTo($elem);
    }
    
    function start() {
        percentTime = 0;
        isPause = false;
        tick = setInterval(interval, 10);
    };
 
    function interval() {
        if(isPause === false){
            percentTime += 1 / time;
            $bar.css({
                width: percentTime+"%"
            });
            if(percentTime >= 100){
                $elem.trigger('owl.next')
            }
        }
    }
    
    function pauseOnDragging(){
      isPause = true;
    }
    
    function moved(){
      clearTimeout(tick);
      start();
    }
    
    
    
    ////------- Projects Carousel
    $(".projects-carousel").owlCarousel({
        navigation : true,
        pagination: false,
        slideSpeed : 400,
        stopOnHover: true,
        autoPlay: 3000,
        items : 4,
        itemsDesktopSmall : [900,3],
        itemsTablet: [600,2],
        itemsMobile : [479, 1]
    });
    
    
    
    ////------- Testimonials Carousel
    $(".testimonials-carousel").owlCarousel({
        navigation : true,
        pagination: false,
        slideSpeed : 2500,
        stopOnHover: true,
        autoPlay: 3000,
        singleItem:true,
        autoHeight : true,
        transitionStyle : "fade"
    });
    
    
    
    
    
    
    ////------- Custom Carousel
    $('.custom-carousel').each(function(){
        var owl = jQuery(this),
            itemsNum = $(this).attr('data-appeared-items'),
            sliderNavigation = $(this).attr('data-navigation');
            
        if ( sliderNavigation == 'false' || sliderNavigation == '0' ) {
            var returnSliderNavigation = false
        }else {
            var returnSliderNavigation = true
        }
        if( itemsNum == 1) {
            var deskitemsNum = 1;
            var desksmallitemsNum = 1;
            var tabletitemsNum = 1;
        } 
        else if (itemsNum >= 2 && itemsNum < 4) {
            var deskitemsNum = itemsNum;
            var desksmallitemsNum = itemsNum - 1;
            var tabletitemsNum = itemsNum - 1;
        } 
        else if (itemsNum >= 4 && itemsNum < 8) {
            var deskitemsNum = itemsNum -1;
            var desksmallitemsNum = itemsNum - 2;
            var tabletitemsNum = itemsNum - 3;
        } 
        else {
            var deskitemsNum = itemsNum -3;
            var desksmallitemsNum = itemsNum - 6;
            var tabletitemsNum = itemsNum - 8;
        }
        owl.owlCarousel({
            slideSpeed : 300,
            stopOnHover: true,
            autoPlay: false,
            navigation : returnSliderNavigation,
            pagination: false,
            lazyLoad : true,
            items : itemsNum,
            itemsDesktop : [1000,deskitemsNum],
            itemsDesktopSmall : [900,desksmallitemsNum],
            itemsTablet: [600,tabletitemsNum],
            itemsMobile : false,
            transitionStyle : "goDown",
        });
    });
    
    
    
    
    

});



