;(function($){

  // base variables
  var windowWidth  = $(window).width(),
      windowHeight = $(window).height();

  // -- sticky header ---------------------------------------------------
  function setStickyHeigt() {
    var scrollPosition = $(window).scrollTop(),
          shadowHeight = '214px';
    if (windowWidth < 1250 && windowWidth > 1023) {
      shadowHeight = '92px';
    } else if (windowWidth < 1024 && windowWidth > 767) {
      shadowHeight = '137px';
    } else if (windowWidth < 768) {
      shadowHeight = '76px';
    }
    if (scrollPosition >= 162) {
      $(".site-header").addClass("sticky");
      $("#fejlec-menu").addClass("sticky");
      $(".shadow-header").css("height", shadowHeight);
    }
    else {
      $(".site-header").removeClass("sticky");
      $("#fejlec-menu").removeClass("sticky");
      $(".shadow-header").css("height", "0");
    }
  }
  // --------------------------------------------------------------------

  $(document).ready(function() {

    // detect browser
    function detectIE() {
      var ua = window.navigator.userAgent;

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
        // Edge (IE 12+) => return version number
        return parseInt(ua.substring(edge + 5, ua.indexOf('.', edge)), 10);
      }

      // other browser
      return false;
    }
    var version = detectIE();
    if (version === false) {
      $('body').addClass('it-is-not-a-Microsoft-browser');
    } else if (version >= 12) {
      $('body').addClass('it-is-Edge engine-version-'+version);
    } else {
      $('body').addClass('it-is-IE browser-version-'+version);
    }

    // search bar toggle
    if($('.site-header__middle').length > 0) {
      $(".site-header__button-search").on("click", function(e) {
        e.preventDefault();
        $('.site-header__middle').slideToggle();
      });
    }

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

        if (currentRowStart != topPosition) {
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

    // -- AJAX kosárhoz adás gomb -----------------------------------------
    var ajaxurl = $('meta[name=ajax-url]').attr("content");
    $( document.body).on('click', '.vw-add-to-cart', function(e) {
      e.preventDefault();
      var $this = $(this);
      $this.parent().parent().siblings('.procuct_card__cart-message').hide();
      $this.parent().parent().siblings('.add-to-cart-loader').show();
      if( $this.is(':disabled') ) {
        return;
      }
      var id = $(this).data("product-id");
      var data = {
          action     : 'my_custom_add_to_cart',
          product_id : id
      };
      $.post(ajaxurl, data, function(response) {
        if( response.success ) {
          console.log('added to cart');
          $this.parent().parent().siblings('.add-to-cart-loader').hide();

          $this.parent().parent().siblings('.procuct_card__cart-message.added').fadeIn();
          $this.attr('disabled', 'disabled');
          $( document.body ).trigger( 'wc_fragment_refresh' );
        }
        else {
          console.log('already in cart');
          $this.parent().parent().siblings('.add-to-cart-loader').hide();
          $this.parent().parent().siblings('.procuct_card__cart-message.already-in').fadeIn();
          $( document.body ).trigger( 'wc_fragment_refresh' );
        }
      }, 'json');
    })
    // --------------------------------------------------------------------

    var lineBreaker = null;
    $('.break-line').each(function() {
      lineBreaker = $(this).html().replace( '|', '<br>' );
      $(this).html( lineBreaker );
    });

    $('#fejlec-menu>.menu-item').children('ul').hide();
    $('#fejlec-menu>.menu-item>a').parent().hover(
      function() {
        $( this ).children('ul').fadeIn( 200 );
      }, function() {
        $( this ).children('ul').fadeOut( 200 );
      }
    );

    $('#mobil-menu>.menu-item-has-children, #mobil-menu>.menu-item-has-children>.sub-menu>.menu-item-has-children').click(function(e) {
      e.stopPropagation();
      $(this).children('.sub-menu').slideToggle();
    });

    // -- file input drag and drop ----------------------------------------
      $('.input-file').on('change', function() {
        $(this).parent().removeClass('drag-over');
        $(this).next('.filename').remove();
        $(this).siblings('.wpcf7-not-valid-tip').remove();
        value = $(this).val();
        if ( value != '' ) {
          value = value.replace('C:\\fakepath\\', '');
          fileName = '<span class="filename">' + value + '</span>';
          $(this).parent().append( fileName );
        }
      }).bind('dragover', function() {
        $(this).parent().addClass('drag-over');
      }).bind('dragleave', function() {
        $(this).parent().removeClass('drag-over');
      });
    // --------------------------------------------------------------------


    $(window).load(function() {

      // -- footer rögzítése az oldal aljára --------------------------------
        setTimeout(function() {
          if ( $('#main').height() < $('body').height() ) $('.site-footer').addClass('site-footer-fixed');
        }, 2000);
      // --------------------------------------------------------------------
      equalheight('.favourites__item-part', 0);
      equalheight('.product-list__item', 0);
      equalheight('.procuct_card__item-part', 0);

      setStickyHeigt();

    });


    $(window).resize(function(){

      // base variables
      var windowWidth  = $(window).width(),
          windowHeight = $(window).height();

      // -- footer rögzítése az oldal aljára --------------------------------
        if ( $('#main').height() < $('body').height() ) $('.site-footer').removeClass('site-footer-fixed');
        if ( $('#main').height() < $('body').height() ) $('.site-footer').addClass('site-footer-fixed');
      // --------------------------------------------------------------------

      equalheight('.favourites__item-part', 0);
      equalheight('.product-list__item', 0);
      equalheight('.procuct_card__item-part', 0);

      setStickyHeigt();

    });

    $(window).scroll(function () {

      setStickyHeigt();

    });

  });

})(jQuery);
