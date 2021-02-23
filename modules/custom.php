<?php
//ADD TO CART FUNCTION
add_action('wp_ajax_my_custom_add_to_cart', "my_custom_add_to_cart");
add_action('wp_ajax_nopriv_my_custom_add_to_cart', "my_custom_add_to_cart");
function my_custom_add_to_cart() {
	$retval = array(
		'success' => false,
		'message' => ""
	);
	if( !function_exists( "WC" ) ) {
		$retval['message'] = "woocommerce not installed";
	} elseif( empty( $_POST['product_id'] ) ) {
		$retval['message'] = "no product id provided";
	} else {
		$product_id = $_POST['product_id'];
		if( my_custom_cart_contains( $product_id ) ) {
			$retval['message'] = "product already in cart";
		} else {
			$cart = WC()->cart;
			$retval['success'] = $cart->add_to_cart( $product_id );
			if( !$retval['success'] ) {
				$retval['message'] = "product could not be added to cart";
			} else {
				$retval['message'] = "product added to cart";
			}
		}
	}
	echo json_encode( $retval );
	wp_die();
}
function my_custom_cart_contains( $product_id ) {
	$cart = WC()->cart;
	$cart_items = $cart->get_cart();
	if( $cart_items ) {
		foreach( $cart_items as $item ) {
			$product = $item['data'];
			if( $product_id == $product->id ) {
				return true;
			}
		}
	}
	return false;
}

// alapértelmezett woocommerce stíluslap eltávolítása
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
/*add_action( 'wp_enqueue_scripts', 'remove_woocommerce_admin_css', 10 );
function remove_woocommerce_admin_css() {
	wp_deregister_style('woocommerce_admin_styles');
}*/

add_filter('woocommerce_attribute_show_in_nav_menus', 'wc_reg_for_menus', 1, 2);
function wc_reg_for_menus( $register, $name = '' ) {
     if ( $name == 'pa_occasion' || $name == 'pa_colour' || $name == 'pa_occasion' ) $register = true;
     return $register;
}

// -- telefonszám formátum "tisztító"
function sanitize_phone_number($phone) {
	$sanitized_phone_number = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);
	$symbols_to_remove = array("-", ".");
	$phone_only_plus_symbol_enabled = str_replace($symbols_to_remove, "", $sanitized_phone_number);
	return $phone_only_plus_symbol_enabled;
}
