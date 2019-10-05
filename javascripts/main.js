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

    $(window).load(function() {
    });


    $(window).resize(function(){
    });

  });

})(jQuery);
