;(function($){

  $(document).ready(function() {

    var $body = $( 'body' );
    $body.on( 'change', 'input[name=payment_method]', function() {
      $body.trigger( 'update_checkout' );
    });
    $body.on( 'change', 'select#billing_country', function() {
      $body.trigger( 'update_checkout' );
    });
    $body.on( 'input', 'input#billing_address_1', function() {
      $body.trigger( 'update_checkout' );
    });
    $body.on( 'input', 'input#billing_city', function() {
      $body.trigger( 'update_checkout' );
    });
    $body.on( 'input', '#billing_postcode', function() {
      $body.trigger( 'update_checkout' );
    });

  });

})(jQuery);
