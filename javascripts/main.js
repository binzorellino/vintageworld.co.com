;(function($){

  $(document).ready(function() {

    // open in new window
    if($('.new-window').length > 0) {
      $(function() {
        $('a.new-window').click(function() {
          window.open(this.href);
          return false;
        });
      });
    }

    $(function () {
      $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
          $('#back-top').fadeIn();
        } else {
          $('#back-top').fadeOut();
        }
      });

      $('#back-top').click(function () {
        $('body,html').animate({
          scrollTop: 0
        }, 800);
        return false;
      });
    });

    function popupwindow(url, width, height) {
      var wleft = (screen.width / 2) - (width / 2),
        wtop = (screen.height / 2) - (height / 2);
      window.open(
        url,
        "",
        "menubar=no,toolbar=no,resizable=yes,scrollbars=yes,width=" + width + ",height=" + height + ",top=" + wtop + ",left=" + wleft
      );
    }

    $(".share-post").on("click", function(e) {
      e.preventDefault();
      popupwindow($(this).attr("href"), 500, 300);
    });

    equalheight = function(container, plusheight){

      var currentTallest = 0,
      currentRowStart = 0,
      rowDivs = new Array(),
      $el,
      topPosition = 0;

      $(container).each(function() {

        $el = $(this);
        $($el).height('auto')
        topPostion = $el.position().top;

        if (currentRowStart != topPostion) {
          for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
            rowDivs[currentDiv].height(currentTallest + plusheight);
          }
          rowDivs.length = 0; // empty the array
          currentRowStart = topPostion;
          currentTallest = $el.height();
          rowDivs.push($el);
        } else {
          rowDivs.push($el);
          currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
        }

        for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
          rowDivs[currentDiv].height(currentTallest + plusheight);
        }

      });

    }

    // -- főoldali slider -------------------------------------------------
      if ( $( '.heroslider__container' ).length > 0 ) {
        var heroSlider = $('.heroslider__container').bxSlider({
                  //'mode': 'horizontal',
                  //'mode': 'vertical',
                    'mode': 'fade',
                'controls': false,
                   'pager': false,
          'adaptiveHeight': false,
                    'auto': true,
            'infiniteLoop': true,
             'slideMargin': 0,
            'onSlideAfter': function() { heroSlider.stopAuto(); heroSlider.startAuto(); },
                'nextText': '<span>></span>',
                'prevText': '<span><</span>',
                   'speed': 1000,
                   'pause': 5000,
                //'easing': 'linear',
                  'easing': 'ease',
                //'easing': 'ease-in',
                //'easing': 'ease-out',
                //'easing': 'ease-in-out',
                //'easing': 'cubic-bezier(n,n,n,n)',
           'preloadImages': 'visible',
             'tickerHover': true,
         //'touchEnabled' : false,
            //'slideWidth': 620,
               'minSlides': 1,
               'maxSlides': 10
        });
      }
    // --------------------------------------------------------------------

    $(window).load(function() {
    });


    $(window).resize(function(){
    });

  });

})(jQuery);
