     function openNav() {
    document.getElementById("mySidepanel").style.width = "250px";
}

    function closeNav() {
    document.getElementById("mySidepanel").style.width = "0";
}




//Search Pop up

$(function () {
    $('a[href="#search"]').on('click', function(event) {
        event.preventDefault();
        $('#search').addClass('open');
        $('#search > form > input[type="search"]').focus();
    });

    $('#search, #search button.close').on('click keyup', function(event) {
        if (event.target == this || event.target.className == 'close' || event.keyCode == 27) {
            $(this).removeClass('open');
        }
    });


    //Do not include! This prevents the form from submitting for DEMO purposes only!
    $('form').submit(function(event) {
        event.preventDefault();
        return false;
    })
});


//Book Appointment

//$(window).scroll(function(){
// if ($(this).scrollTop() > 2000) {
// $('#book-app').fadeOut("slow");
//} else {
//  $('#book-app').fadeIn("slow");
//}
//});


//Scroll top

$(document).ready(function(){
  setTimeout(() => {
    $("#navbarSupportedContent").find(".nav-link").click(function(){
      setTimeout(() => {
      $(this).parents("#navbarSupportedContent").removeClass("show");
      }, 1000);
    });
    $("#navbarSupportedContent").find(".dropdown a").click(function(){
      setTimeout(() => {
      $(this).parents("#navbarSupportedContent").removeClass("show");
      }, 1000);
    });
  }, 3000);


    setTimeout(() => {
        $("#navbarSupportedContentprofile").find(".nav-link").click(function(){
            setTimeout(() => {
                $(this).parents("#navbarSupportedContentprofile").removeClass("show");
            }, 1000);
        });
        $("#navbarSupportedContentprofile").find(".dropdown a").click(function(){
            setTimeout(() => {
                $(this).parents("#navbarSupportedContentprofile").removeClass("show");
            }, 1000);
        });
    }, 3000);

    // $("#navbarSupportedContent").removeClass("show")

  let url = location.href.replace(/\/$/, "");

  if (location.hash) {
    const hash = url.split("#");
    $('#myTab a[href="#'+hash[1]+'"]').tab("show");
    url = location.href.replace(/\/#/, "#");
    history.replaceState(null, null, url);
    setTimeout(() => {
      $(window).scrollTop(0);
    }, 400);
  }

  $('a[data-toggle="tab"]').on("click", function() {
    let newUrl;
    const hash = $(this).attr("href");
    if(hash == "#home") {
      newUrl = url.split("#")[0];
    } else {
      newUrl = url.split("#")[0] + hash;
    }
    newUrl += "/";
    history.replaceState(null, null, newUrl);
  });



    $(document).click(function(e) {
        // get the clicked element
        $clicked = $(e.currentTarget);
        // if the clicked element is not a descendent of the dropdown
        if ($clicked.closest('.dropdown-menu').length === 0) {
          // close the dropdown
          $('.dropdown-menu').removeClass('show');
        }
      });
    $(window).on('load',function(){
        $('#MAINMODAL').modal('show');
    });
    $('body').on('hidden.bs.modal', '.modal', function () {
        $('video').trigger('pause');
        });

    // $('.banner-slider').slick({
    //     dots: true,
    //     arrows: false,
    //     infinite: true,
    //     speed: 300,
    //     slidesToShow: 1,
    // });
    $(window).scroll(function(){
        if ($(this).scrollTop() > 2200) {
            $('#scroll').fadeIn();
        } else {
            $('#scroll').fadeOut();
        }
    });
    $('#scroll').click(function(){
        $("html, body").animate({ scrollTop: 0 }, 600);
        return false;
    });
    $('.department-slide').slick({
        dots: false,
        arrows: true,
        infinite: true,
        speed: 2000,
        slidesToShow: 1,
    });
});


// Item slider inner details page

$('.slider-for').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: true,
    dots:false,
    fade: true,
    asNavFor: '.slider-nav'
});
$('.slider-nav').slick({
    slidesToShow: 5,
    slidesToScroll: 1,
    asNavFor: '.slider-for',
    dots: false,
    arrows: true,
    centerMode: false,
    focusOnSelect: true,
    responsive: [
        {
            breakpoint: 992,
            settings: {
                slidesToShow: 5
            }
        },
        {
            breakpoint: 768,
            settings: {
                slidesToShow: 3
            }
        }
    ]
});







$(".ourDoctors-slide").slick({
    dots: false,
    arrows: false,
    infinite: true,
    speed: 1000,
    autoplay: true,
    pauseOnHover: false,
    autoplaySpeed: 7000,
    slidesToShow: 1,
    slidesToScroll: 1,
    rows:1,
    slidesPerRow:2,
    fade: true,
    responsive: [
        {
            breakpoint: 992,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                slidesPerRow:1
            }
        }
    ]
});

$('.inner-slider').on('mouseover', function (e) {
    "use strict";
    var mouseSide;
    if ((e.pageX - this.offsetLeft) < $(this).width() / 2) {
        $('.inner-slider').slickPrev();
    } else {
        $('.inner-slider').slickNext();
    }
});


$(".inner-slider").slick({
    dots: false,
    arrows: true,
    infinite: true,
    speed: 300,
    slidesToShow: 4,
    autoplay: false,
    slidesToScroll: 1,
    responsive: [
        {
            breakpoint: 1199,
            settings: {
                slidesToShow: 3,
                arrows: false,
            }
        },
        {
            breakpoint: 992,
            settings: {
                slidesToShow: 2,
                arrows: false,
            }
        },
        {
            breakpoint: 767,
            settings: {
                slidesToShow: 1,
                arrows: false,
            }
        }
    ]
});


/* ========================================================================
 * Bootstrap: affix.js v3.3.7
 * http://getbootstrap.com/javascript/#affix
 * ========================================================================
 * Copyright 2011-2016 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
    'use strict';

    // AFFIX CLASS DEFINITION
    // ======================

    var Affix = function (element, options) {
        this.options = $.extend({}, Affix.DEFAULTS, options)

        this.$target = $(this.options.target)
            .on('scroll.bs.affix.data-api', $.proxy(this.checkPosition, this))
            .on('click.bs.affix.data-api',  $.proxy(this.checkPositionWithEventLoop, this))

        this.$element     = $(element)
        this.affixed      = null
        this.unpin        = null
        this.pinnedOffset = null

        this.checkPosition()
    }

    Affix.VERSION  = '3.3.7'

    Affix.RESET    = 'affix affix-top affix-bottom'

    Affix.DEFAULTS = {
        offset: 0,
        target: window
    }

    Affix.prototype.getState = function (scrollHeight, height, offsetTop, offsetBottom) {
        var scrollTop    = this.$target.scrollTop()
        var position     = this.$element.offset()
        var targetHeight = this.$target.height()

        if (offsetTop != null && this.affixed == 'top') return scrollTop < offsetTop ? 'top' : false

        if (this.affixed == 'bottom') {
            if (offsetTop != null) return (scrollTop + this.unpin <= position.top) ? false : 'bottom'
            return (scrollTop + targetHeight <= scrollHeight - offsetBottom) ? false : 'bottom'
        }

        var initializing   = this.affixed == null
        var colliderTop    = initializing ? scrollTop : position.top
        var colliderHeight = initializing ? targetHeight : height

        if (offsetTop != null && scrollTop <= offsetTop) return 'top'
        if (offsetBottom != null && (colliderTop + colliderHeight >= scrollHeight - offsetBottom)) return 'bottom'

        return false
    }

    Affix.prototype.getPinnedOffset = function () {
        if (this.pinnedOffset) return this.pinnedOffset
        this.$element.removeClass(Affix.RESET).addClass('affix')
        var scrollTop = this.$target.scrollTop()
        var position  = this.$element.offset()
        return (this.pinnedOffset = position.top - scrollTop)
    }

    Affix.prototype.checkPositionWithEventLoop = function () {
        setTimeout($.proxy(this.checkPosition, this), 1)
    }

    Affix.prototype.checkPosition = function () {
        if (!this.$element.is(':visible')) return

        var height       = this.$element.height()
        var offset       = this.options.offset
        var offsetTop    = offset.top
        var offsetBottom = offset.bottom
        var scrollHeight = Math.max($(document).height(), $(document.body).height())

        if (typeof offset != 'object')         offsetBottom = offsetTop = offset
        if (typeof offsetTop == 'function')    offsetTop    = offset.top(this.$element)
        if (typeof offsetBottom == 'function') offsetBottom = offset.bottom(this.$element)

        var affix = this.getState(scrollHeight, height, offsetTop, offsetBottom)

        if (this.affixed != affix) {
            if (this.unpin != null) this.$element.css('top', '')

            var affixType = 'affix' + (affix ? '-' + affix : '')
            var e         = $.Event(affixType + '.bs.affix')

            this.$element.trigger(e)

            if (e.isDefaultPrevented()) return

            this.affixed = affix
            this.unpin = affix == 'bottom' ? this.getPinnedOffset() : null

            this.$element
                .removeClass(Affix.RESET)
                .addClass(affixType)
                .trigger(affixType.replace('affix', 'affixed') + '.bs.affix')
        }

        if (affix == 'bottom') {
            this.$element.offset({
                top: scrollHeight - height - offsetBottom
            })
        }
    }


    // AFFIX PLUGIN DEFINITION
    // =======================

    function Plugin(option) {
        return this.each(function () {
            var $this   = $(this)
            var data    = $this.data('bs.affix')
            var options = typeof option == 'object' && option

            if (!data) $this.data('bs.affix', (data = new Affix(this, options)))
            if (typeof option == 'string') data[option]()
        })
    }

    var old = $.fn.affix

    $.fn.affix             = Plugin
    $.fn.affix.Constructor = Affix


    // AFFIX NO CONFLICT
    // =================

    $.fn.affix.noConflict = function () {
        $.fn.affix = old
        return this
    }


    // AFFIX DATA-API
    // ==============

    $(window).on('load', function () {
        $('[data-spy="affix"]').each(function () {
            var $spy = $(this)
            var data = $spy.data()

            data.offset = data.offset || {}

            if (data.offsetBottom != null) data.offset.bottom = data.offsetBottom
            if (data.offsetTop    != null) data.offset.top    = data.offsetTop

            Plugin.call($spy, data)
        })
    })

}(jQuery);

//Live Chat

$(".chat-clk").click(function(){
    $(".chat-box").toggle(400);
});
$(".clox").click(function(){
    $(".chat-box").hide(400);
});


//Department Horizontal Accordion

(function(){
    // $('.flex-container').waitForImages(function() {
    //     $('.spinner').fadeOut();
    // }, $.noop, true);

    $(".flex-slide").each(function(){
        $(this).hover(function(){
            $(this).find('.flex-title').css({
                transform: 'rotate(0deg)',
                top: '10%'
            });
            $(this).find('.flex-about').css({
                opacity: '1'
            });
        }, function(){
            $(this).find('.flex-title').css({
                transform: 'rotate(90deg)',
                top: '15%'
            });
            $(this).find('.flex-about').css({
                opacity: '0'
            });
        })
    });
})();

// File upload file get push value

$('#file-upload').change(function() {
    var i = $(this).prev('label').clone();
    var file = $('#file-upload')[0].files[0].name;
    $(this).prev('label').text(file);
});

$('#file-upload2').change(function() {
    var i = $(this).prev('label').clone();
    var file = $('#file-upload2')[0].files[0].name;
    $(this).prev('label').text(file);
});

$('#file-upload3').change(function() {
    var i = $(this).prev('label').clone();
    var file = $('#file-upload3')[0].files[0].name;
    $(this).prev('label').text(file);
});

$('.upload').on('change',function(event){
    var files = event.originalEvent.target.files;
    $(this).parent().siblings('#uploadFile').val(files[0].name);
    $(this).parent().siblings('#uploadFile1').val(files[0].name);
});

$('.upload_front_civil').on('change',function(event){
    var civil_files = event.originalEvent.target.files;
    $(this).parent().siblings('#uploadCivilFrontFile').val(civil_files[0].name);
    $(this).parent().siblings('#uploadCivilFrontFile1').val(civil_files[0].name);
});

$('.upload_back_civil').on('change',function(event){
    var civil_files = event.originalEvent.target.files;
    $(this).parent().siblings('#uploadCivilBackFile').val(civil_files[0].name);
    $(this).parent().siblings('#uploadCivilBackFile1').val(civil_files[0].name);
});

$('.upload_passport').on('change',function(event){
    var passport_files = event.originalEvent.target.files;
    $(this).parent().siblings('#uploadPassportFile').val(passport_files[0].name);
    $(this).parent().siblings('#uploadPassportFile1').val(passport_files[0].name);
});

$('.close').on("click", function () {
    $(this).parents('.quantity').fadeOut();
});







// setTimeout(() => {
//   var slideWrapper = $(".carousel-main"),
//     iframes = slideWrapper.find('.embed-player'),
//     lazyImages = slideWrapper.find('.slide-image'),
//     lazyCounter = 0;

// // POST commands to YouTube or Vimeo API
// function postMessageToPlayer(player, command){
//   if (player == null || command == null) return;
//   player.contentWindow.postMessage(JSON.stringify(command), "*");
// }

// // When the slide is changing
// function playPauseVideo(slick, control){
//   var currentSlide, slideType, startTime, player, video;

//   currentSlide = slick.find(".slick-current");
//   slideType = currentSlide.attr("class").split(" ")[1];
//   player = currentSlide.find("iframe").get(0);
//   startTime = currentSlide.data("video-start");

//   if (slideType === "vimeo") {
//     switch (control) {
//       case "play":
//         if ((startTime != null && startTime > 0 ) && !currentSlide.hasClass('started')) {
//           currentSlide.addClass('started');
//           postMessageToPlayer(player, {
//             "method": "setCurrentTime",
//             "value" : startTime
//           });
//         }
//         postMessageToPlayer(player, {
//           "method": "play",
//           "value" : 1
//         });
//         break;
//       case "pause":
//         postMessageToPlayer(player, {
//           "method": "pause",
//           "value": 1
//         });
//         break;
//     }
//   } else if (slideType === "youtube") {
//     switch (control) {
//       case "play":
//         postMessageToPlayer(player, {
//           "event": "command",
//           "func": "mute"
//         });
//         postMessageToPlayer(player, {
//           "event": "command",
//           "func": "playVideo"
//         });
//         break;
//       case "pause":
//         postMessageToPlayer(player, {
//           "event": "command",
//           "func": "pauseVideo"
//         });
//         break;
//     }
//   } else if (slideType === "video") {
//     video = currentSlide.children("video").get(0);
//     if (video != null) {
//       if (control === "play"){
//         video.play();
//       } else {
//         video.pause();
//       }
//     }
//   }
// }

// // Resize player
// function resizePlayer(iframes, ratio) {
//   if (!iframes[0]) return;
//   var win = $(".carousel-main"),
//       width = win.width(),
//       playerWidth,
//       height = win.height(),
//       playerHeight,
//       ratio = ratio || 16/9;

//   iframes.each(function(){
//     var current = $(this);
//     if (width / ratio < height) {
//       playerWidth = Math.ceil(height * ratio);
//       current.width(playerWidth).height(height).css({
//         left: (width - playerWidth) / 2,
//          top: 0
//         });
//     } else {
//       playerHeight = Math.ceil(width / ratio);
//       current.width(width).height(playerHeight).css({
//         left: 0,
//         top: (height - playerHeight) / 2
//       });
//     }
//   });
// }

// // DOM Ready
// $(function() {
//   // Initialize
//   slideWrapper.on("init", function(slick){
//     slick = $(slick.currentTarget);
//     setTimeout(function(){
//       playPauseVideo(slick,"play");
//     }, 1000);
//     resizePlayer(iframes, 16/9);
//   });
//   slideWrapper.on("beforeChange", function(event, slick) {
//     slick = $(slick.$slider);
//     playPauseVideo(slick,"pause");
//   });
//   slideWrapper.on("afterChange", function(event, slick) {
//     slick = $(slick.$slider);
//     playPauseVideo(slick,"play");
//   });
//   slideWrapper.on("lazyLoaded", function(event, slick, image, imageSource) {
//     lazyCounter++;
//     if (lazyCounter === lazyImages.length){
//       lazyImages.addClass('show');
//       // slideWrapper.slick("slickPlay");
//     }
//   });

//   //start the slider
//   slideWrapper.slick({
//     // fade:true,
//     autoplaySpeed:4000,
//     lazyLoad:"progressive",
//     speed:600,
//     arrows:false,
//     dots:true,
//     cssEase:"cubic-bezier(0.87, 0.03, 0.41, 0.9)"
//   });
// });

// // Resize event
// $(window).on("resize.slickVideoPlayer", function(){
//   resizePlayer(iframes, 16/9);
// });

// }, 3100);





